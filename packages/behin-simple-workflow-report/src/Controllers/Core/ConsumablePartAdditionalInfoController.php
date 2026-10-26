<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Behin\SimpleWorkflow\Controllers\Core\ScriptController;
use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use Behin\SimpleWorkflow\Models\Entities\Borrow_requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;
use Behin\SimpleWorkflow\Models\Entities\Consumable_parts;
use Behin\SimpleWorkflow\Models\Entities\Consumable_part_additional_info;
use Behin\Sms\Controllers\ArsanSmsController;
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\Log;
use Throwable;

class ConsumablePartAdditionalInfoController extends Controller
{
    public function show(Consumable_parts $consumablePart)
    {
        $currencies = config('simpleWorkflowReport.consumable_parts.currencies', []);
        return view('SimpleWorkflowReportView::Core.ConsumablePart.additional-info', compact('consumablePart', 'currencies'));
    }

    public function update(Request $request, Consumable_parts $consumablePart)
    {
        $currencies = config('simpleWorkflowReport.consumable_parts.currencies', []);
        $validCurrencyKeys = array_column($currencies, 'key');
        $validated = $request->validate([
            'currency' => 'nullable|string|in:' . implode(',', $validCurrencyKeys),
        ]);

        $data = [
            'order_date' => $request->order_date,
            'order_date_alt' => $request->order_date_alt,
            'receipt_date' => $request->receipt_date,
            'receipt_date_alt' => $request->receipt_date_alt,
            'unit_price' => $request->unit_price,
            'currency' => $validated['currency'] ?? null,
        ];

        $additionalInfo = $consumablePart->additional_info;

        if (!$additionalInfo) {
            $additionalInfo = $consumablePart->additional_info()->create($data);
        }

        $additionalInfo->update($data);
        return redirect()->route('simpleWorkflowReport.consumable-parts.index')->with(['success' => 'ذخیره شد']);
    }
}
