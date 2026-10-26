<?php

namespace BehinUserRoles\Controllers;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Models\Entities\Counter_parties;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use BehinUserRoles\Controllers\GetRoleController;
use BehinUserRoles\Models\User;
use BehinUserRoles\Controllers\DepartmentController;
use BehinUserRoles\Models\UserDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public static function getAll()
    {
        return User::get();
    }
    public function index($id)
    {
        if ($id == 'all'):
            $activeUsers = User::withoutGlobalScopes()
                ->where(function ($q) {
                    $q->where('is_disabled', false)->orWhereNull('is_disabled');
                })->get();
            $disabledUsers = User::withoutGlobalScopes()->where('is_disabled', true)->get();
            $users = User::withoutGlobalScopes()->get();
            return view('URPackageView::user.all')->with([
                'users' => $users,
                'activeUsers' => $activeUsers,
                'disabledUsers' => $disabledUsers,
            ]);
        else:

            $user = User::withoutGlobalScopes()->with('counterParties')->find($id);

            return view('URPackageView::user.edit')->with([
                'user' => $user,
                'roles' => GetRoleController::getAll(),
                'departments' => DepartmentController::getAll($id),
                'counterParties' => Counter_parties::with('user')->orderBy('name')->get(),
            ]);
        endif;
    }

    public function create()
    {
        $roles = GetRoleController::getAll();
        return view('URPackageView::user.create')->with(['roles' => $roles]);
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'sms_reminder_enabled' => $request->boolean('sms_reminder_enabled', true),
        ]);
        return redirect()->back()->with('success', 'User created successfully');
    }

    public function update(Request $r, $id)
    {
        User::where('id', $id)->update([
            'number' => $r->number,
            'name' => $r->name,
            'email' => $r->email,
            'login_with_ip' => $r->login_with_ip,
            'valid_ip' => $r->valid_ip,
            'sms_reminder_enabled' => $r->boolean('sms_reminder_enabled', true)
        ]);
        return redirect()->back()->with('success', 'User updated successfully');
    }


    public function ChangePass(Request $request, $id)
    {
        User::where('id', $id)->update(['password' => Hash::make($request->pass)]);
        return redirect()->back()->with('success', 'Password changed successfully');
    }

    function changePMUsername(Request $r, $id)
    {
        User::where('id', $id)->update(['pm_username' => $r->pm_username]);
        return redirect()->back();
    }

    public function ChangeIp(Request $r, $user_id)
    {
        User::where('id', $user_id)->update(['valid_ip' => $r->valid_ip]);
        return redirect()->back();
    }

    public function changeShowInReport(Request $r, $id)
    {
        if (isset($r->showInReport))
            $showInReport = true;
        else
            $showInReport = false;
        User::where('id', $id)->update(['showInReport' => $showInReport]);
        return redirect()->back();
    }

    public function updateCounterParties(Request $request, $id)
    {
        $user = User::withoutGlobalScopes()->findOrFail($id);

        $validated = $request->validate([
            'counterparty_ids' => ['nullable', 'array'],
            'counterparty_ids.*' => ['string', 'distinct', 'exists:wf_entity_counter_parties,id'],
        ]);

        $selectedCounterParties = $validated['counterparty_ids'] ?? [];

        DB::transaction(function () use ($user, $selectedCounterParties) {
            $query = Counter_parties::where('user_id', $user->id);

            if (!empty($selectedCounterParties)) {
                $query->whereNotIn('id', $selectedCounterParties);
            }

            $query->update(['user_id' => null]);

            if (!empty($selectedCounterParties)) {
                Counter_parties::whereIn('id', $selectedCounterParties)->update(['user_id' => $user->id]);
            }
        });

        return redirect()->back()->with('success', 'طرف حساب‌های کاربر با موفقیت به‌روزرسانی شد.');
    }

    public function addToDepartment(Request $r, $id)
    {
        $user = User::find($id);
        $department_id = $r->department_id;
        UserDepartment::updateOrCreate([
            'user_id' => $id,
            'department_id' => $department_id
        ]);
        return redirect()->back()->with('success', 'User added to department successfully');
    }

    public function removeFromDepartment(Request $r, $id)
    {
        $user = User::find($id);
        $departmentId = $r->departmentId;
        UserDepartment::where([
            'user_id' => $id,
            'department_id' => $departmentId
        ])->delete();
        return redirect()->back()->with('success', 'User removed from department successfully');
    }

    public function invalidateSessions($id)
    {
        $user = User::findOrFail($id);

        // 1. حذف همه سشن‌های کاربر
        DB::table('sessions')->where('user_id', $user->id)->delete();

        // 2. بی‌اعتبار کردن remember_token
        $user->remember_token = Str::random(60);
        $user->save();

        return back()->with('success', 'کاربر از همه دستگاه‌ها و نشست‌ها خارج شد.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.all', ['id' => 'all'])->with('success', 'User deleted successfully');
    }

    public function disable($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        // if (!$user) {
        //     abort(404);
        // }

        $isDisabled = !$user->is_disabled;

        DB::table('users')
            ->where('id', $id)
            ->update([
                'is_disabled' => $isDisabled,
            ]);

        // اگر کاربر غیرفعال شد، تمام Sessionهای او را باطل کن
        if ($isDisabled) {
            $this->invalidateSessions($id);
        }

        return redirect()->back();
            
    }
}
