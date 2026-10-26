<?php

namespace Arghavan\CaseCost\Controllers;

use Arghavan\CaseCost\Models\CaseCostSettings;
use Arghavan\CaseCost\Requests\CaseCostRequest;
use Arghavan\CaseCost\Resources\CaseCostResource;
use Arghavan\CaseCost\Services\CaseCostCalculator;
use Behin\SimpleWorkflow\Controllers\Core\CaseController;
use Behin\SimpleWorkflow\Models\Core\Cases;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CaseCostSettingsController
{
    public function index()
    {
        $settings = CaseCostSettings::get();
        return view('CaseCostView::case-cost.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'job_rank_1_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_2_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_3_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_4_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_5_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_6_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_7_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_8_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_9_percentage'  => ['required', 'numeric', 'min:0', 'max:100'],
            'job_rank_10_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        foreach ($validated as $name => $percentage) {
            CaseCostSettings::where('name', $name)
                ->update([
                    'percentage' => $percentage
                ]);
        }
        CaseCostSettings::where('name', 'overhead_cost')
            ->update([
                'percentage' => $request->overhead_cost
            ]);

        CaseCostSettings::where('name', 'round_trip_repair_cost')
            ->update([
                'percentage' => $request->round_trip_repair_cost
            ]);

        return redirect()
            ->route('case-cost.settings')
            ->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}
