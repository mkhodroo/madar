<form action="{{ route('simpleWorkflowReport.consumable-parts.additional-info.update', $consumablePart->id) }}"
    method="POST" id="additional-info-form" class="row">
    @csrf
    @method('PUT')
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'order_date',
        'fieldId' => 'order_date',
        'fieldClass' => 'col-sm-12',
        'readOnly' => false,
        'required' => false,
        'showLabel' => true,
        'fieldValue' => $consumablePart?->additional_info?->order_date ?? null,
        'fieldValueAlt' => $consumablePart?->additional_info?->order_date_alt ?? null,
    ])
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'receipt_date',
        'fieldId' => 'receipt_date',
        'fieldClass' => 'col-sm-12',
        'readOnly' => false,
        'required' => false,
        'showLabel' => true,
        'fieldValue' => $consumablePart?->additional_info?->receipt_date ?? null,
        'fieldValueAlt' => $consumablePart?->additional_info?->receipt_date_alt ?? null,
    ])
    <div class="col-sm-4">
        <label for="unit_price">قیمت واحد</label>
        <input type="text" name="unit_price" id="unit_price" value="[[ $consumablePart?->additional_info?->unit_price ]]"
            dir="ltr" class="form-control formatted-digit" style="width: 150px">
    </div>
    <div class="col-sm-4">
        <label for="currency">واحد پول</label>
        <select name="currency" id="currency" class="form-control" style="width: 150px">
            <option value="">انتخاب کنید</option>
            @foreach ($currencies ?? [] as $currency)
                <option value="{{ $currency['key'] }}"
                    {{ ($consumablePart?->additional_info?->currency ?? '') == $currency['key'] ? 'selected' : '' }}>
                    {{ $currency['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-12">
        <button type="submit" class="btn btn-sm btn-primary">ذخیره</button>
    </div>
</form>


<script>
    init_view()
</script>
