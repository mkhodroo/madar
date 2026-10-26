<?php

namespace Arghavan\OfficialOfficeTransaction\Controllers;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Models\Entities\Financial_transactions;
use Behin\SimpleWorkflowReport\Models\PettyCash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Behin\SimpleWorkflow\Models\Entities\Petty_cash_transactions;
class GetOfficialOfficeTransactionController extends Controller
{
    public static function baseQuery()
    {
        $query = Financial_transactions::query();
        $query = $query->where('official_office', 1);
        return $query;
    }
}

