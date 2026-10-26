<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Behin\SimpleWorkflow\Controllers\Core\ProcessController;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use Behin\SimpleWorkflow\Models\Entities\Borrow_requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class MapacenterCasesController extends Controller
{
    public function index()
    {
        $process= ProcessController::getById('ab17ef68-6ec7-4dc8-83b0-5fb6ffcedc50');
        return view('SimpleWorkflowReportView::Core.MapaCenter.index', compact(
            'process',
        ));
    }

}
