<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Bank;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        config(['site.page' => 'bank']);
        $data = Bank::all();
        return view('admin.setting.bank', compact('data'));
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'image'=>'required|file|image',
        ]);
        
        $item = new Bank();
        $item->name = $request->get("name");        
        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "bank_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/bank_images/'), $imageName);
            $item->image = 'images/uploaded/bank_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', __('words.created_successfully'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = Bank::find($request->get("id"));
        $item->name = $request->get("name");
        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "bank_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/bank_images/'), $imageName);
            $item->image = 'images/uploaded/bank_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', __('words.updated_successfully'));
    }

    public function delete($id){
        Bank::destroy($id);        
        return back()->with("success", __('words.deleted_successfully'));
    }
}
