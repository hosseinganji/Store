<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(20);
        return view("admin.banners.index" , compact("banners"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.banners.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "banner_image" => "required",
            "title" => "nullable",
            "text" => "nullable",
            "priority" => "required",
            "is_active" => "required",
            "type" => "required",
            "button_text" => "nullable",
            "button_link" => "nullable",
            "button_icon" => "nullable",
        ]);

        try {
            DB::beginTransaction();

            $bannerImageName = getGeneralName($request->banner_image->getClientOriginalName());
            $request->banner_image->move( public_path(env("BANNER_PATH_IMAGES")) , $bannerImageName );    

            Banner::create([
                "image" => $bannerImageName,
                "title" => $request->title,
                "text" => $request->text,
                "priority" => $request->priority,
                "is_active" => $request->is_active,
                "type" => $request->type,
                "button_text" => $request->button_text,
                "button_link" => $request->button_link,
                "button_icon" => $request->button_icon,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد بنر', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق','بنر با موفقیت اضافه شد');
        return redirect()->route("admin.banners.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return view("admin.banners.show" , compact("banner"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view("admin.banners.edit" , compact("banner"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        // dd($request->all());

        $request->validate([
            "banner_image" => "required",
            "title" => "nullable",
            "text" => "nullable",
            "priority" => "required",
            "is_active" => "required",
            "type" => "required",
            "button_text" => "nullable",
            "button_link" => "nullable",
            "button_icon" => "nullable",
        ]);

        try {
            DB::beginTransaction();

            $bannerImageName = getGeneralName($request->banner_image->getClientOriginalName());
            $request->banner_image->move( public_path(env("BANNER_PATH_IMAGES")) , $bannerImageName );    

            $banner->update([
                "image" => $bannerImageName,
                "title" => $request->title,
                "text" => $request->text,
                "priority" => $request->priority,
                "is_active" => $request->is_active,
                "type" => $request->type,
                "button_text" => $request->button_text,
                "button_link" => $request->button_link,
                "button_icon" => $request->button_icon,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش بنر', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق','بنر با موفقیت ویرایش شد');
        return redirect()->route("admin.banners.index");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        alert()->success('موفق','بنر با موفقیت حذف شد');

        return redirect()->route("admin.banners.index");
    }
}
