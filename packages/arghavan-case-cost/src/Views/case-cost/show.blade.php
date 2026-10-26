@extends('behin-layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h3>Results for {{ $caseNumber }}</h3>

        @include('CaseCostView::case-cost.partials.cost-summary-card', ['label' => 'Consumable Parts Cost', 'value' => $data['consumable_parts_cost'] ?? 0])
        @include('CaseCostView::case-cost.partials.cost-summary-card', ['label' => 'Part Repair Cost', 'value' => $data['part_repair_cost'] ?? 0])
        @include('CaseCostView::case-cost.partials.cost-summary-card', ['label' => 'Device Repair Cost', 'value' => $data['device_repair_cost'] ?? 0])
        @include('CaseCostView::case-cost.partials.cost-summary-card', ['label' => 'Petty Cash Cost', 'value' => $data['petty_cash_cost'] ?? 0])

        @include('CaseCostView::case-cost.partials.cost-summary-card', ['label' => 'Total Cost', 'value' => $data['total_cost'] ?? 0])

        <a href="{{ route('case-cost.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
