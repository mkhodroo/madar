@extends('behin-layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Case Cost Lookup</h3>
                <form method="POST" action="{{ route('case-cost.calculate') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Case Number</label>
                        <input type="text" name="case_number" class="form-control" value="{{ old('case_number') }}" required>
                    </div>
                    <button class="btn btn-primary">Calculate</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
