
            <form action="{{ route('simpleWorkflowReport.consumable-parts.update', $consumablePart->id) }}" method="POST" id="edit-form-{{ $consumablePart->id }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label-{{ $consumablePart->id }}">ویرایش درخواست کالا</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $consumablePart->id }}">

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">نام کالا</label>
                        <div class="col-lg-6 col-md-7">
                            <input type="text" name="product_name" class="form-control material-input" value="{{ $consumablePart->product_name ?? $consumablePart->additional_info?->product_name ?? '' }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">مبلغ</label>
                        <div class="col-lg-6 col-md-7">
                            <input type="number" name="amount" class="form-control material-input" value="{{ $consumablePart->amount ?? 0 }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">قیمت واحد</label>
                        <div class="col-lg-6 col-md-7">
                            <input type="text" name="unit_price" class="form-control material-input formatted-digit" value="{{ $consumablePart?->additional_info?->unit_price ?? '' }}" dir="ltr" style="width: 150px">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">توضیحات</label>
                        <div class="col-lg-6 col-md-7">
                            <textarea name="description" class="form-control material-input">{{ $consumablePart->description ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">درخواست کننده</label>
                        <div class="col-lg-6 col-md-7">
                            <select name="requester_id" class="form-control material-select">
                                <option value="">انتخاب کنید</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $consumablePart->created_by == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">وضعیت</label>
                        <div class="col-lg-6 col-md-7">
                            <select name="consumable_part_status" class="form-control material-select">
                                @foreach ($statuses as $statusKey => $statusValue)
                                    <option value="{{ $statusValue['label'] }}" {{ $consumablePart->consumable_part_status == $statusValue['label'] ? 'selected' : '' }}>{{ $statusValue['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-3 col-md-4">تاریخ درخواست</label>
                        <div class="col-lg-6 col-md-7">
                            <input type="text" name="created_at" class="form-control material-input" value="{{ \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d H:i:s', $consumablePart->created_at)->format('Y-m-d H:i') ?? '' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                </div>
            </form>