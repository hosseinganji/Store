<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(20);

        return view("admin.categories.index" , compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::where("parent_id" , 0)->get();

        $attributes = Attribute::all();

        return view("admin.categories.create" , compact("parentCategories" , "attributes"));
        
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
            "name" => "required",
            "slug" => "required|unique:categories,slug",
            "attributes_ids" => "required",
            "isFilterAttributes" => "required",
            "variationAttribute" => "required",
            "category_image" => "nullable",

        ]);

        try {
            DB::beginTransaction();

            $categoryImageName = getGeneralName($request->category_image->getClientOriginalName());
            $request->category_image->move( public_path(env("CATEGORY_PATH_IMAGES")) , $categoryImageName );

            $category = Category::create([
                "name" => $request->name ,
                "slug" => $request->slug ,
                "parent_id" => $request->parent_id ,
                "is_active" => $request->is_active ,
                "icon" => $request->icon ,
                "description" => $request->description,
                "image" => $categoryImageName == null ? null : $categoryImageName,
            ]);
    
            foreach ($request->attributes_ids as $attributeId) {
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id , [
                    "is_filter" => in_array($attributeId , $request->isFilterAttributes) ? 1 : 0,
                    "is_variation" => $request->variationAttribute == $attributeId ? 1 : 0  
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد دسته بندی', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق','دسته بندی با موفقیت اضافه شد');

        return redirect()->route("admin.categories.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view("admin.categories.show" , compact("category"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        $parentCategories = Category::where("parent_id" , 0)->get();

        $attributes = Attribute::all();

        return view("admin.categories.edit" , compact("category" , "parentCategories" , "attributes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $request->validate([
            "image" => "nullable",
            "name" => "required",
            "slug" => "required|unique:categories,slug,".$category->id,
            "attributes_ids" => "required",
            "isFilterAttributes" => "required",
            "variationAttribute" => "required",

        ]);

        try {
            DB::beginTransaction();

            $categoryImageName = getGeneralName($request->category_image->getClientOriginalName());
            $request->category_image->move( public_path(env("CATEGORY_PATH_IMAGES")) , $categoryImageName );


            $category->update([
                "image" => $categoryImageName,
                "name" => $request->name ,
                "slug" => $request->slug ,
                "parent_id" => $request->parent_id ,
                "is_active" => $request->is_active ,
                "icon" => $request->icon ,
                "description" => $request-> description,
            ]);
    
            $category->attributes()->detach();

            foreach ($request->attributes_ids as $attributeId) {
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id , [
                    "is_filter" => in_array($attributeId , $request->isFilterAttributes) ? 1 : 0,
                    "is_variation" => $request->variationAttribute == $attributeId ? 1 : 0  
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش دسته بندی', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }



        alert()->success('موفق','دسته بندی با موفقیت ویرایش شد');

        return redirect()->route("admin.categories.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        alert()->success('موفق','دسته بندی با موفقیت حذف شد');

        return redirect()->route("admin.categories.index");
    }

    public function getCategoryAttributes(Category $category){
        $attributes = $category->attributes()->wherePivot("is_variation" , 0)->get();
        $variation = $category->attributes()->wherePivot("is_variation" , 1)->first();
        return ["attributes" => $attributes , "variation" => $variation];
    }
}
