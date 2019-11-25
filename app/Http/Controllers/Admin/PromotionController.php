<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promotion;

use Imagick;

class PromotionController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        config(['site.page' => 'promotion']);
        $data = Promotion::all();
        return view('admin.promotion.index', compact('data'));
    }

    public function create()
    {
        config(['site.page' => 'promotion']);
        return view('admin.promotion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $item = new Promotion();
        $item->title = $request->title;
        $item->start_at = $request->start_at;
        $item->end_at = $request->end_at;
        $item->content = $request->content;
        $item->amount = $request->amount ?? 0;
        $item->rate = $request->rate ?? 0;
        if($request->has("image_en")){
            $picture = request()->file('image_en');
            $imageName = "promotion_en_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_en = 'images/uploaded/promotion_images/'.$imageName;
        }
        if($request->has("image_malaya")){
            $picture = request()->file('image_malaya');
            $imageName = "promotion_malaya_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_malaya = 'images/uploaded/promotion_images/'.$imageName;
        }
        if($request->has("image_zh_cn")){
            $picture = request()->file('image_zh_cn');
            $imageName = "promotion_zh_cn_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_zh_cn = 'images/uploaded/promotion_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', __('words.created_successfully'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        config(['site.page' => 'promotion']);
        $promotion = Promotion::find($id);
        return view('admin.promotion.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $item = Promotion::find($id);
        $item->title = $request->title;
        $item->start_at = $request->start_at;
        $item->end_at = $request->end_at;
        $item->content = $request->content;
        $item->amount = $request->amount ?? 0;
        $item->rate = $request->rate ?? 0;
        if($request->has("image_en")){
            $picture = request()->file('image_en');
            $imageName = "promotion_en_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_en = 'images/uploaded/promotion_images/'.$imageName;
        }
        if($request->has("image_malaya")){
            $picture = request()->file('image_malaya');
            $imageName = "promotion_malaya_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_malaya = 'images/uploaded/promotion_images/'.$imageName;
        }
        if($request->has("image_zh_cn")){
            $picture = request()->file('image_zh_cn');
            $imageName = "promotion_zh_cn_".time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/uploaded/promotion_images/'), $imageName);
            $item->image_zh_cn = 'images/uploaded/promotion_images/'.$imageName;
        }
        $item->save();
        return back()->with('success', __('words.created_successfully'));
    }

    public function destroy($id)
    {
        Promotion::destroy($id);
    }
}
