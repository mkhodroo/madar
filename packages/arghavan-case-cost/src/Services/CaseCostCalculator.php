<?php

namespace Arghavan\CaseCost\Services;

use Arghavan\CaseCost\Models\CaseCostSettings;
use Behin\SimpleWorkflow\Models\Entities\Case_misson;
use Behin\SimpleWorkflow\Models\Entities\Consumable_parts;
use Behin\SimpleWorkflow\Models\Entities\Employee_salaries;
use Behin\SimpleWorkflow\Models\Entities\Financial_transactions;
use Behin\SimpleWorkflow\Models\Entities\Mapa_center_fix_report;
use Behin\SimpleWorkflow\Models\Entities\Missions;
use Behin\SimpleWorkflow\Models\Entities\Part_reports;
use Behin\SimpleWorkflow\Models\Entities\Repair_reports;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class CaseCostCalculator
{
    private $settings;
    public function __construct()
    {
        $this->settings = CaseCostSettings::get();
    }
    public function calculate(string $caseNumber): array
    {
        $consumable = $this->consumablePartsCost($caseNumber);
        $partRepair = $this->partRepairCost($caseNumber);
        $deviceRepair = $this->deviceRepairCost($caseNumber);
        $roundTripRepairCost = $this->roundTripRepairCost($caseNumber);
        $missionCost = $this->caseMissionCost($caseNumber);
        $petty = $this->pettyCashCost($caseNumber);
        $mapaCenterFixReport = $this->mapaCenterFixReport($caseNumber);

        $total = $consumable + $partRepair + $deviceRepair + $roundTripRepairCost + $missionCost + $petty + $mapaCenterFixReport;
        $overheadCost = $total * $this->settings->where('name', 'overhead_cost')->first()?->percentage / 100;
        return [
            'consumable_parts_cost' => round($consumable),
            'part_repair_cost' => round($partRepair),
            'device_repair_cost' => round($deviceRepair),
            'round_trip_repair_cost' => round($roundTripRepairCost),
            'mission_cost' => round($missionCost),
            'petty_cash_cost' => round($petty),
            'mapa_center_fix_report' => round($mapaCenterFixReport),
            'total_cost' => round($total),
            'overhead_cost' => round($overheadCost),
        ];
    }

    private function consumablePartsCost(string $caseNumber): float
    {
        // Sum `amount` from wf_entity_consumable_parts; column is numeric/bigint
        $sum = Consumable_parts::where('case_number', $caseNumber)
            ->sum('amount');

        return (float) $sum;
    }

    private function pettyCashCost(string $caseNumber): float
    {
        $ids = config('case_cost_config.petty_cash_counterparty_ids', []);
        $creditType = config('case_cost_config.credit_financial_type'); // TODO confirm exact value

        // Use Eloquent sum to stay DB-agnostic (works for SQLite in tests)
        $sum = Financial_transactions::where('case_number', $caseNumber)
            ->whereIn('counterparty_id', $ids)
            ->where('financial_type', $creditType)
            ->sum('amount');

        return (float) ($sum ?? 0);
    }

    private function partRepairCost(string $caseNumber): float
    {
        // Join part reports to employee salaries via registered_by -> employee_salary_user_column
        // ASSUMPTION: values stored in `registered_by` (part reports) and `mapa_expert` (repair reports)
        // match the identifier stored in the employee salary table column configured by
        // `config('case_cost_config.employee_salary_user_column')`. Verify this against real data.
        $rows = Part_reports::where('case_number', $caseNumber)->get();
        $total = 0.0;

        foreach ($rows as $r) {
            $duration = (float) $r->repair_duration; // assumed hours
            $salary = Employee_salaries::where('user_id', $r->registered_by)->first();
            $hourlySalary = $this->hourlySalary($salary->real_salary);
            $jobRank = $r->part()?->job_rank;
            switch ($jobRank) {
                case 'ندارد':
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
                case '1':
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
                case '2':
                    $jobRank = $this->settings->where('name', 'job_rank_2_percentage')->first()?->percentage;
                    break;
                case '3':
                    $jobRank = $this->settings->where('name', 'job_rank_3_percentage')->first()?->percentage;
                    break;
                case '4':
                    $jobRank = $this->settings->where('name', 'job_rank_4_percentage')->first()?->percentage;
                    break;
                case '5':
                    $jobRank = $this->settings->where('name', 'job_rank_5_percentage')->first()?->percentage;
                    break;
                case '6':
                    $jobRank = $this->settings->where('name', 'job_rank_6_percentage')->first()?->percentage;
                    break;
                case '7':
                    $jobRank = $this->settings->where('name', 'job_rank_7_percentage')->first()?->percentage;
                    break;
                case '8':
                    $jobRank = $this->settings->where('name', 'job_rank_8_percentage')->first()?->percentage;
                    break;
                case '9':
                    $jobRank = $this->settings->where('name', 'job_rank_9_percentage')->first()?->percentage;
                    break;
                case '10':
                    $jobRank = $this->settings->where('name', 'job_rank_10_percentage')->first()?->percentage;
                    break;
                default:
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
            }
            if ($salary) {
                $total += $duration * $hourlySalary * (1 + $jobRank /100);
            }
        }
        // return $jobRank;
        return $total;
    }

    private function deviceRepairCost(string $caseNumber): float
    {
        $rows = Repair_reports::where('case_number', $caseNumber)->get();
        $total = 0.0;
        foreach ($rows as $row) {
            $startDate = convertPersianToEnglish($row->start_date);
            $startTime = convertPersianToEnglish($row->start_time);
            if (strlen($startTime) < 5) {
                if (strlen($startTime) == 2) {
                    $startTime = $startTime . ':00';
                }
            }
            $row->start = Jalalian::fromFormat('Y-m-d H:i', "$startDate $startTime")
                ->toCarbon()
                ->timestamp;

            $endDate = convertPersianToEnglish($row->end_date);
            $endTime = convertPersianToEnglish($row->end_time);
            if (strlen($endTime) < 5) {
                if (strlen($endTime) == 2) {
                    $endTime = $endTime . ':00';
                }
            }
            $row->end = Jalalian::fromFormat('Y-m-d H:i', "$endDate $endTime")
                ->toCarbon()
                ->timestamp;

            $row->duration = round((($row->end ?? 0) - ($row->start ?? 0)) / 3600, 2);
            $jobRank = $row->job_rank;
            switch ($jobRank) {
                case 'ندارد':
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
                case '1':
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
                case '2':
                    $jobRank = $this->settings->where('name', 'job_rank_2_percentage')->first()?->percentage;
                    break;
                case '3':
                    $jobRank = $this->settings->where('name', 'job_rank_3_percentage')->first()?->percentage;
                    break;
                case '4':
                    $jobRank = $this->settings->where('name', 'job_rank_4_percentage')->first()?->percentage;
                    break;
                case '5':
                    $jobRank = $this->settings->where('name', 'job_rank_5_percentage')->first()?->percentage;
                    break;
                case '6':
                    $jobRank = $this->settings->where('name', 'job_rank_6_percentage')->first()?->percentage;
                    break;
                case '7':
                    $jobRank = $this->settings->where('name', 'job_rank_7_percentage')->first()?->percentage;
                    break;
                case '8':
                    $jobRank = $this->settings->where('name', 'job_rank_8_percentage')->first()?->percentage;
                    break;
                case '9':
                    $jobRank = $this->settings->where('name', 'job_rank_9_percentage')->first()?->percentage;
                    break;
                case '10':
                    $jobRank = $this->settings->where('name', 'job_rank_10_percentage')->first()?->percentage;
                    break;
                default:
                    $jobRank = $this->settings->where('name', 'job_rank_1_percentage')->first()?->percentage;
                    break;
            }

            $duration = $row->duration;

            $salary = Employee_salaries::where('user_id', $row->mapa_expert)->first();
            $hourlySalary = $this->hourlySalary($salary->real_salary);
            if ($salary) {
                $total += ($duration * $hourlySalary) * (1 + $jobRank / 100);
            }
        }

        return round($total);
    }

    private function roundTripRepairCost(string $caseNumber): float
    {
        $rows = Repair_reports::where('case_number', $caseNumber)->get();
        $total = 0.0;
        foreach ($rows as $row) {
            $startDate = convertPersianToEnglish($row->start_date);
            $startTime = convertPersianToEnglish($row->start_time);
            if (strlen($startTime) < 5) {
                if (strlen($startTime) == 2) {
                    $startTime = $startTime . ':00';
                }
            }
            $row->start = Jalalian::fromFormat('Y-m-d H:i', "$startDate $startTime")
                ->toCarbon()
                ->timestamp;

            $endDate = convertPersianToEnglish($row->end_date);
            $endTime = convertPersianToEnglish($row->end_time);
            if (strlen($endTime) < 5) {
                if (strlen($endTime) == 2) {
                    $endTime = $endTime . ':00';
                }
            }
            $row->end = Jalalian::fromFormat('Y-m-d H:i', "$endDate $endTime")
                ->toCarbon()
                ->timestamp;


            // return $row->duration;
            if ($row->round_trip_time) {
                $roundTripDuration = $this->convertToHours($row->round_trip_time);
            } else {
                $roundTripDuration = 0;
            }

            $salary = Employee_salaries::where('user_id', $row->mapa_expert)->first();
            $hourlySalary = $this->hourlySalary($salary->real_salary);
            if ($salary) {
                $total += ($roundTripDuration * $hourlySalary) * (1 + $this->settings->where('name', 'round_trip_repair_cost')->first()?->percentage / 100);
            }
        }

        return round($total);
    }

    private function caseMissionCost(string $caseNumber): float
    {
        $rows = Missions::where('case_number', $caseNumber)->get();
        $rows = Case_misson::where('related_case_number', $caseNumber)->get();
        $total = 0.0;
        foreach ($rows as $row) {
            $mission = Missions::where('case_number',$row->case_number)->first();
            $start = $mission?->start_datetime_alt;
            $end = $mission?->end_datetime_alt;
            


            $duration = $end - $start;
            $duration = $duration / 1000 / 3600 ;

            $salary = Employee_salaries::where('user_id', $row->created_by)->first();
            $hourlySalary = $this->hourlySalary($salary->real_salary);
            if ($salary) {
                $total += ($duration * $hourlySalary) * 1.4;
            }
        }

        return round($total);
    }

    private function mapaCenterFixReport($caseNumber)
    {
        $reports = Mapa_center_fix_report::where('case_number', $caseNumber)->get();
        $total = 0.0;

        foreach ($reports as $report) {
            $duration = round(((int) $report->end - (int) $report->start) / 3600, 2);
            $salary = Employee_salaries::where('user_id', $report->expert)->first();
            $hourlySalary = $this->hourlySalary($salary->real_salary);
            if ($salary) {
                $total += $duration * $hourlySalary;
            }
        }
        return round($total);
    }

    private function parseDateTime(string $date, string $time): ?\DateTimeImmutable
    {
        $value = trim($date . ' ' . $time);

        if ($value === '') {
            return null;
        }

        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function hourlySalary($realSalary)
    {
        return $realSalary / 200;
    }

    private function convertToHours($time)
    {
        $time = trim(convertPersianToEnglish($time));

        // فقط عدد => ساعت
        if (is_numeric($time)) {
            return (float) $time;
        }

        // فرمت HH:MM
        if (preg_match('/^(\d{1,2}):(\d{2})$/', $time, $matches)) {
            return (int)$matches[1] + ((int)$matches[2] / 60);
        }

        $hours = 0;
        $minutes = 0;

        if (preg_match('/(\d+(?:\.\d+)?)\s*ساعت/', $time, $matches)) {
            $hours = (float)$matches[1];
        }

        if (preg_match('/(\d+)\s*دقیقه/', $time, $matches)) {
            $minutes = (int)$matches[1];
        }

        return $hours + ($minutes / 60);
    }
}
