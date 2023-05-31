<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cities;
use App\Models\Provinces;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::where("user_id" , auth()->id())->get();
        $provinces = Provinces::get();
        $cities = Cities::get();
        return view("home.profile.addresses" , compact("provinces" , "addresses" , "cities"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            "addtitle" => "required",
            "addpostal_code" => "required",
            "addcity_id" => "required",
            "addprovince_id" => "required|not_in:select",
            "addcellphone" => "required|digits:11|regex:/[0]{1}[0-9]{10}/",
            "addaddress" => "required",
        ]);

        Address::create([
            "title" => $request->addtitle,
            "postal_code" => $request->addpostal_code,
            "city_id" => $request->addcity_id,
            "province_id" => $request->addprovince_id,
            "cellphone" => $request->addcellphone,
            "address" => $request->addaddress,
            "user_id" => auth()->id(),
        ]);

        alert()->success('موفق' , 'آدرس شما با موفقیت ایجاد شد')->persistent("بستن");
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $request->validate([
            "edittitle" => "required",
            "editpostal_code" => "required",
            "editcity_id" => "required",
            "editprovince_id" => "required|not_in:select",
            "editcellphone" => "required|digits:11|regex:/[0]{1}[0-9]{10}/",
            "editaddress" => "required",
        ]);

        $address->update([
            "title" => $request->edittitle,
            "postal_code" => $request->editpostal_code,
            "city_id" => $request->editcity_id,
            "province_id" => $request->editprovince_id,
            "cellphone" => $request->editcellphone,
            "address" => $request->editaddress,
            "user_id" => auth()->id(),
        ]);

        alert()->success('موفق' , 'آدرس شما با موفقیت ویرایش شد')->persistent("بستن");
        return redirect()->back();
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

    public function getCityFromProvince(Request $request , $province_id)
    {
        $cities = Cities::where('province_id', $province_id)->get();
        return $cities;
    }
}
