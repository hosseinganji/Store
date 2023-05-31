<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\AuthController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\Profile\IndexProfileController;
use App\Http\Controllers\Home\WishlistController;
use App\Http\Controllers\ProductImageController;
use App\Models\User;
use App\Notifications\OTPSms;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
});

Route::get('/admin-panel/dashboard' , [DashboardController::class , 'index'])->name('admin.dashboard');

Route::prefix('admin-panel')->name('admin.')->group(function(){
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('comments', CommentController::class);
    
    Route::get("/category-attributes-get/{category}" , [CategoryController::class , "getCategoryAttributes"]);
    Route::delete("/images/{imageId}/destroy" , [ProductImageController::class , "destroy"])->name("products.delete_images");
    Route::put("/images/{imageId}/edit" , [ProductImageController::class , "edit"])->name("products.main_image");
    
    
    
});
Route::get('/comment/{comment}/change-status', [CommentController::class , 'changeStatus'])->name('admin.comments.changeStatus');

Route::get('/', [HomeController::class , 'index'])->name('home.homepage');


Route::get('/categories/{category:slug}' , [HomeCategoryController::class , 'show'])->name('home.category.show');
Route::post('/comment/{product}' , [HomeCommentController::class , 'store'])->name('home.comment.store');

Route::get('/wishlist/{product}/add' , [WishlistController::class , 'add'])->name('profile.wishlist.add');
Route::get('/wishlist/{product}/remove' , [WishlistController::class , 'remove'])->name('profile.wishlist.remove');

Route::get('/compare/{product}/add' , [CompareController::class , 'add'])->name('profile.compare.add');
Route::delete('/compare/{product}/remove' , [CompareController::class , 'remove'])->name('profile.compare.remove');

Route::post('/cart/add' , [CartController::class , 'add'])->name('cart.add');
Route::get('/cart' , [CartController::class , 'show'])->name('cart.show');
Route::put('/cart' , [CartController::class , 'update'])->name('cart.update');
Route::get('/cart-remove/{rowId}' , [CartController::class , 'remove'])->name('cart.remove');
Route::get('/clear-cart' , [CartController::class , 'clear'])->name('cart.clear');


Route::any('/login' , [AuthController::class , 'login'])->name('home.OTPlogin');
Route::post('/check-otp' , [AuthController::class , 'checkOtp']);
Route::post('/resend-otp' , [AuthController::class , 'resendOtp']);



Route::prefix('profile')->name('home.profile.')->group(function(){
    Route::get('/', [IndexProfileController::class , "index"])->name('index');
    Route::post('/profile/{id}', [IndexProfileController::class , "store"])->name('store');
    Route::get('/comments', [HomeCommentController::class , 'profileUserComments'])->name('comments');
    Route::get('/wishlist', [WishlistController::class , 'showInProfile'])->name('wishlist');
    Route::get('/compare', [CompareController::class , 'showInProfile'])->name('compare');
    Route::get('/address', [AddressController::class , 'index'])->name('address');
    Route::post('/address', [AddressController::class , 'create'])->name('address.add');
    Route::put('/address/{address}', [AddressController::class , 'update'])->name('address.edit');
});

Route::get('/checkout', [CartController::class , 'checkout'])->name('home.checkout');

Route::post('/payment', [PaymentController::class , 'payment'])->name('home.payment');
Route::get('/payment-callback', [PaymentController::class , 'paymentCallback'])->name('home.payment.callback');

Route::get('/get-city-from-province/{province_id}', [AddressController::class , 'getCityFromProvince']);


Route::get('/logout', [AuthController::class , 'logout'])->name("logout");

Route::get('/test', function(){
    // dd(session()->get("compareProduct"));
    // session()->remove("compareProduct");
    dd(\Cart::getContent());
    // \Cart::remove("14-24");
});

Route::get('/{product:slug}' , [HomeProductController::class , 'show'])->name('home.product.show');