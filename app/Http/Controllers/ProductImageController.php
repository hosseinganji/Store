<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function upload($primaryImage , $images){
        $primaryImageName = getGeneralName($primaryImage->getClientOriginalName());
        $primaryImage->move( public_path(env("PRODUCT_PATH_IMAGES")) , $primaryImageName );
        
        $imagesName = [];
        foreach ($images as $image) {
            $imageName = getGeneralName($image->getClientOriginalName());
            $image->move( public_path(env("PRODUCT_PATH_IMAGES")) , $imageName );
            array_push($imagesName , $imageName);
        }
        
        
        return ["primaryImageName" => $primaryImageName , "imagesName" => $imagesName];

    }


    public function destroy(Request $request , $image){

        ProductImage::destroy($image);

        alert()->success('موفق','عکس با موفقیت حذف شد');
        return redirect()->back();
    }
    
    
    public function edit(Request $request , $imageId){
        

        $image = ProductImage::find($imageId);

        $product = Product::find($request->product_id);

        $product->update([
            "primary_image" => $image->image,
        ]);

        alert()->success('موفق','عکس با موفقیت جایگزین شد');
        return redirect()->back();

    }
}
