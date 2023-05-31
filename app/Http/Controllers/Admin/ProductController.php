<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\ProductImageController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Tag;
use App\Models\Attribute;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $product_informations = Product::all();

        $products = Product::latest()->paginate(20);

        $product_attribute = ProductAttribute::all();
        
        $product_variation = ProductVariation::all();

        $attribute = Attribute::all();
        
        $product_object = [];
        foreach ($product_informations as $product) {

            if ($product->is_active == 1){
                $activation = "فعال";
            }else{
                $activation = "غیر فعال";
            }

            
            $tags = "";
            foreach ($product->tags as $key => $tag) {
                if(count($product->tags)-1 == $key){ $comma = ""; }
                else{ $comma = "، "; }
                $tags .= $tag->name . $comma;
            }
            
            
            $productAttributes = "";
            foreach ($product_attribute->where("product_id" , $product->id)->all() as $productAttribute) {
                foreach ($product->attributes->where("id" , $productAttribute->attribute_id) as $key => $attribute) {
                    if(count($product->attributes)-1 == $key){ $comma = ""; }
                    else{ $comma = " | "; }
                    $productAttributes .= ($attribute->name . ": " . $productAttribute->value) . $comma;
                }
            }

            $variationAttributeName = $attribute->find($product_variation->where("product_id" , $product->id)->first()->attribute_id)->name;    
            $productVariationsValue = $productVariationsQuantity = $productVariationsPrice = $productVariationsSku = "";
            $i = 0;
            foreach ($product_variation->where("product_id" , $product->id)->all() as $key => $productVariation){

                if(count($product_variation->where("product_id" , $product->id)->all())-1 == $i++){ $comma = ""; }
                else{ $comma = " | "; }

                $productVariationsValue .= $productVariation->value . $comma;
                $productVariationsPrice .= $productVariation->price . $comma;
                $productVariationsQuantity .= $productVariation->quantity . $comma;
                $productVariationsSku .= $productVariation->sku . $comma;

            }

            
            

            array_push($product_object , [
                "id" => $product->id,
                "name" => $product->name,
                "sku" => $product->slug,
                "category_name" => $product->category->name,
                "brand" => $product->brand->name,
                "tags" => $tags,
                "variations" => $productAttributes,
                "variation_attribute" => $variationAttributeName,
                "variation_name" => $productVariationsValue,
                "variation_price" => $productVariationsPrice,
                "variation_quantity" => $productVariationsQuantity,
                "variation_sku" => $productVariationsSku,
                "status" => $activation,
                "send_price" => $product->delivery_amount,
                "send_price_per_extra_product" => $product->delivery_amount_per_product == null ? "رایگان" : $product->delivery_amount_per_product ,
            ]);
        }

        $product_json = json_encode($product_object);
        // dd($product_json);
        
        return view('admin.products.index' , compact("product_json" , "products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::where("parent_id" , "!=" , "0")->get();

        return view("admin.products.create" , compact("brands" , "tags" , "categories"));
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
            "brand_id" => "required",
            "is_active" => "required",
            "tag_ids" => "required",
            "sku" => "required|unique:products,slug",
            "category_id" => "required|not_in:select",
            "primary_image" => "required|mimes:jpg,jpeg,svp,png",
            "images" => "required",
            "images.*" => "mimes:jpg,jpeg,svp,png",
            "attribute_ids.*" => "required",
            "variation_value" => "required",
            "variation_value.*.*" => "required",
            "sendPrice" => "required",
        ]);

        try {
            DB::beginTransaction();

        $uploadProductImage = new ProductImageController();
        $allIimagesProduct = $uploadProductImage->upload($request->primary_image , $request->images);
        
        $product = Product::create([
            "name" => $request->name,
            "brand_id" => $request->brand_id,
            "category_id" => $request->category_id,
            "slug" => $request->sku,
            "primary_image" => $allIimagesProduct["primaryImageName"],
            "description" => $request->description,
            "is_active" => $request->is_active,
            "delivery_amount" => $request->sendPrice,
            "delivery_amount_per_product" => $request->sendPricePerExtraProduct,
        ]);

        foreach ($allIimagesProduct["imagesName"] as $imageName) {
            ProductImage::create([
                "product_id" => $product->id,
                "image" => $imageName,
            ]);
        }

        $ProductAttributeController = new ProductAttributeController();
        $ProductAttributeController->store($product , $request->attribute_ids);
                    
        $category = Category::find($request->category_id);
        $ProductVariationController = new ProductVariationController();
        $ProductVariationController->store($request->variation_value , $product , $category);
        
        $product->tags()->attach($request->tag_ids);


        DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد محصول', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق','محصول با موفقیت اضافه شد');

        return redirect()->route("admin.products.index");
    
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view("admin.products.show" , compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::where("parent_id" , "!=" , "0")->get();

        return view("admin.products.edits" , compact("product" , "brands" , "tags" , "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
        
        if($product->category->id == $request->category_id){
            // Don't Change Category
            $request->validate([
                "attribute_values.*" => "required",
                "variation_values.*.value" => "required",
                "variation_values.*.price" => "required|integer",
                "variation_values.*.quantity" => "required|integer",
                "variation_values.*.sku" => "required",
                "variation_values.*.sale_price" => "nullable",
                "variation_values.*.date_on_sale_from" => "nullable|date",
                "variation_values.*.date_on_sale_to" => "nullable|date",

            ]);
            // Upadate Attributes Of Product
            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->update($request->attribute_values);
            
            // Upadate Variation Of Product
            $ProductVariationController = new ProductVariationController();
            $ProductVariationController->update($request->variation_values);

        }else{
            // Change Category
            $request->validate([
                "attribute_ids.*" => "required",
                "variation_value" => "required",
                "variation_value.value.*" => "required",
                "variation_value.price.*" => "required",
                "variation_value.quantity.*" => "required",
                "variation_value.sku.*" => "required",
                "variation_value.sale_price.*" => "nullable",
                "variation_value.date_on_sale_from.*" => "nullable",
                "variation_value.date_on_sale_to.*" => "nullable",
            ]);
            // Upadate Attributes Of Product
            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->change($request->attribute_ids , $product->id);
            
            // Upadate Variation Of Product
            $category = Category::find($request->category_id);
            $ProductVariationController = new ProductVariationController();
            $ProductVariationController->change($request->variation_value , $product->id , $category);
            
        }
        

        $request->validate([
            "name" => "required",
            "brand_id" => "required|exists:brands,id",
            "is_active" => "required",
            "tag_ids" => "required",
            "tag_ids.*" => "exists:tags,id",
            "category_id" => "required",
            "primary_image" => "nullable|mimes:jpg,jpeg,svp,png",
            "images" => "nullable",
            "images.*" => "mimes:jpg,jpeg,svp,png",
            "sku" => "required|unique:categories,slug,".$product->id,
            "sendPrice" => "required",
            "sendPricePerExtraProduct" => "nullable",
        ]);




        // Update Primary Image
        if($request->primary_image != null){
            $primaryImageName = getGeneralName($request->primary_image->getClientOriginalName());
            $request->primary_image->move( public_path(env("PRODUCT_PATH_IMAGES")) , $primaryImageName );
            $product->update([
                "primary_image" => $primaryImageName
            ]);
        }

        // Add Images
        if($request->images != null){
            foreach ($request->images as $image) {
                    $imageName = getGeneralName($image->getClientOriginalName());
                    $image->move( public_path(env("PRODUCT_PATH_IMAGES")) , $imageName );
                    ProductImage::create([
                        "product_id" => $product->id,
                        "image" => $imageName,
                    ]);
            }
        }

        // Upadate Another Parametr Of Product
        $product->update([
            "name" => $request->name,
            "brand_id" => $request->brand_id,
            "slug" => $request->sku,
            "description" => $request->description,
            "category_id" => $request->category_id,
            "is_active" => $request->is_active,
            "delivery_amount" => $request->sendPrice,
            "delivery_amount_per_product" => $request->sendPricePerExtraProduct,
        ]);

        
        // Upadate Tags Of Product
        $product->tags()->sync($request->tag_ids);


        DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش محصول', $ex->getMessage())->persistent("بستن");
            return redirect()->back();
        }

        alert()->success('موفق','محصول با موفقیت ویرایش شد');
        return redirect()->route("admin.products.index");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
