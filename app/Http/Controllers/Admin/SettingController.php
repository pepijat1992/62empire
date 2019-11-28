<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    protected $setting;
    public function __construct(){
        $this->middleware('auth.admin');
        $this->setting = Setting::find(1);
    }

    public function index(Request $request) {
        config(['site.page' => 'setting']);
        $setting = $this->setting;
        return view('admin.setting.index', compact('setting'));
    }

    public function save_setting(Request $request) {
        $this->setting->update([
            'first_passcode' => $request->first_passcode,
        ]);
        return back()->with('success', __('words.successfully_set'));
    }

    public function withdraw_flag(Request $request) {
        $flag = $request->flag;
        $this->setting->update(['withdraw_flag' => $flag]);
        return response()->json('success');
    }

    public function deposit_flag(Request $request) {
        $flag = $request->flag;
        $this->setting->update(['deposit_flag' => $flag]);
        return response()->json('success');
    }
}
