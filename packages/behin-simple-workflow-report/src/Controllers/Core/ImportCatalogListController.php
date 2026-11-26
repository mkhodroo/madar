<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use BehinUserRoles\Models\User;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use Behin\SimpleWorkflow\Models\Entities\Borrow_requests;
use Behin\SimpleWorkflowReport\Exports\BorrowRequestsExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Behin\SimpleWorkflow\Models\Entities\Catalog_list;

class ImportCatalogListController extends Controller
{
    public function index()
    {
        return view('simpleWorkflowReport::borrow-requests.import-catalog-list');
    }

    public function importCatalogListFromExcel(Request $request)
    {
        $file = $request->file('file');
        $excel = Excel::read($file);
        $catalogList = $excel->toArray()[0];
        foreach ($catalogList as $item) {
            $catalog = Catalog_list::updateOrCreate(
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'number' => $item['number'],
                    'category' => $item['category'],
                    'model' => $item['model'],
                ],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'number' => $item['number'],
                    'category' => $item['category'],
                    'model' => $item['model'],
                ]
            );
        }
        return redirect()->back()->with('success', 'فایل اکسل ');
    }
}
