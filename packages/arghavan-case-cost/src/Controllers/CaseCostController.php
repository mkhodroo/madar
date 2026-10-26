<?php

namespace Arghavan\CaseCost\Controllers;

use Arghavan\CaseCost\Requests\CaseCostRequest;
use Arghavan\CaseCost\Resources\CaseCostResource;
use Arghavan\CaseCost\Services\CaseCostCalculator;
use Behin\SimpleWorkflow\Controllers\Core\CaseController;
use Behin\SimpleWorkflow\Models\Core\Cases;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CaseCostController
{
    protected $calculator;

    public function __construct(CaseCostCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function index()
    {
        return view('CaseCostView::case-cost.index');
    }

    public function calculate(CaseCostRequest $request)
    {
        $caseNumber = $request->input('case_number');

        $case = Cases::where('number', $caseNumber)->first();
        if(!$case){
            $caseNumber = Cases::where('id', $caseNumber)->first()?->number;
        }

        $data = $this->calculator->calculate($caseNumber);

        return view('CaseCostView::case-cost.show', ['caseNumber' => $caseNumber, 'data' => $data]);
    }

    public function show(string $caseNumber)
    {
        $case = Cases::where('number', $caseNumber)->first();
        if(!$case){
            $caseNumber = Cases::where('id', $caseNumber)->first()?->number;
        }
        $data = $this->calculator->calculate($caseNumber);
        return view('CaseCostView::case-cost.show', ['caseNumber' => $caseNumber, 'data' => $data]);
    }

    public function apiShow(string $caseNumber)
    {
        $case = Cases::where('number', $caseNumber)->first();
        if(!$case){
            $caseNumber = Cases::where('id', $caseNumber)->first()?->number;
        }
        $data = $this->calculator->calculate($caseNumber);
        return new CaseCostResource($data);
    }
}
