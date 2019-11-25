<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Models\Game;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        config(['site.page' => 'game']);
        $data = Game::paginate(15);
        return view('admin.setting.game', compact('data'));
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'title'=>'required|string',
        ]);
        
        $item = new Game();
        $item->name = $request->get("name");
        
        $item->save();
        return back()->with('success', __('words.created_successfully'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = Game::find($request->get("id"));
        $item->name = $request->get("name");
        $item->title = $request->get("title");
        $item->domain = $request->get("domain");
        $item->link_android = $request->get("link_android");
        $item->link_iphone = $request->get("link_iphone");
        $item->agent = $request->get("agent");
        $item->api_key = $request->get("api_key");
        $item->token = $request->get("token");
        $item->username = $request->get("username");
        $item->password = $request->get("password");
        $item->status = $request->get("status");
        if($request->has("image")){
            $picture = request()->file('image');
            $imageName = "api_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/api_images/'), $imageName);
            $item->image = 'images/uploaded/api_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', __('words.updated_successfully'));
    }

    public function delete($id){
        Game::destroy($id);        
        return back()->with("success", __('words.deleted_successfully'));
    }
}
