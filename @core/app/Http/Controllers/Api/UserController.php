<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Order;
use App\ServiceArea;
use App\ServiceCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::select('id', 'email', 'password')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->error([
                'message' => 'Invalid Email or Password'
            ]);
        } else {
            $token = $user->createToken(Str::slug(get_static_option('site_title', 'qixer')) . 'api_keys')->plainTextToken;
            return response()->success([
                'users' => $user,
                'token' => $token,
            ]);
        }
    }

    // get country api
    public function country()
    {

        $countries = Country::select('id', 'country')->get();
        if ($countries) {
            return response()->success([
                'countries' => $countries,
            ]);
        } else {
            return response()->error([
                'message' => "No Country Found",
            ]);
        }

    }

    // get city under country api
    public function serviceCity($id)
    {
        $service_cities = ServiceCity::select('id', 'service_city')
            ->where('country_id', $id)
            ->get();
        if ($service_cities->count() >= 1) {
            return response()->json([
                'service_cities' => $service_cities,
            ]);
        } else {
            return response()->error([
                'message' => __('No Cities Available On The Selected Country'),
            ]);
        }

    }

    // get area under city and country api
    public function serviceArea($country_id, $city_id)
    {
        $service_areas = ServiceArea::select('id', 'service_area')
            ->where('country_id', $country_id)
            ->where('service_city_id', $city_id)
            ->get();
        if ($service_areas->count() >= 1) {
            return response()->json([
                'service_areas' => $service_areas,
            ]);
        } else {
            return response()->error([
                'message' => __('No Areas Available On The Selected City'),
            ]);
        }

    }

    //register api
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users|max:191',
            'username' => 'required|unique:users|max:191',
            'phone' => 'required|unique:users|max:191',
            'password' => 'required|min:6|max:191',
            'service_city' => 'required',
            'service_area' => 'required',
            'country_id' => 'required',
            'terms_conditions' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'service_city' => $request->service_city,
            'service_area' => $request->service_area,
            'country_id' => $request->country_id,
            'user_type' => 1,
            'terms_condition' => 1,
        ]);
        if ($user) {
            $token = $user->createToken(Str::slug(get_static_option('site_title', 'qixer')) . 'api_keys')->plainTextToken;
            return response()->success([
                'users' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->error([
                'message' => 'Something Went Wrong',
            ]);
        }
    }

    // send otp
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $otp_code = sprintf("%d", mt_rand(1, 9999));
        $user_email = User::where('email', $request->email)->first();

        if ($user_email) {
            try {
                $message_body = __('Here is your otp code') . ' <span class="verify-code">' . $otp_code . '</span>';
                Mail::to($request->email)->send(new BasicMail([
                    'subject' => __('Your OTP Code'),
                    'message' => $message_body
                ]));
            } catch (\Exception $e) {
                return redirect()->back()->with(FlashMsg::item_new($e->getMessage()));
            }
            return response()->success([
                'email' => $request->email,
                'otp' => $otp_code,
            ]);
        } else {
            return response()->error([
                'message' => __('Email Does not Exists'),
            ]);
        }

    }

    //reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $user = User::select('email')->where('email', $email)->first();
        if ($user) {
            User::where('email', $user->email)->update([
                'password' => Hash::make($request->password),
            ]);
            return response()->success([
                'message' => 'success',
            ]);
        } else {
            return response()->error([
                'message' => 'Email Not Found',
            ]);
        }
    }

    //logout
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->success([
            'message' => 'Logout Success',
        ]);
    }

    //User Profile
    public function profile(){
        $user = User::with('country','city','area')->select('id','name','email','phone','address','about','country_id','service_city','service_area','post_code','image')
        ->where('id',auth()->user()->id)->first();

        $pending_orders = Order::where('status',0)
            ->where('buyer_id',auth()->user()->id)
            ->count();
        $active_orders = Order::where('status',1)
            ->where('buyer_id',auth()->user()->id)
            ->count();
        $complete_orders = Order::where('status',2)
            ->where('buyer_id',auth()->user()->id)
            ->count();
        $total_orders = Order::where('buyer_id',auth()->user()->id)
            ->count();

        $profile_image =  get_attachment_image_by_id($user->image);

        return response()->success([
            'user_details' => $user,
            'pending_order' => $pending_orders,
            'active_order' => $active_orders,
            'complete_order' => $complete_orders,
            'total_order' => $total_orders,
            'profile_image' => $profile_image,
        ]);
    }

//    change password after login
    public function changePassword(Request $request){
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6',
        ]);

        $user = User::select('id','password')->where('id', auth()->user()->id)->first();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->error([
                'message' => 'Current Password is Wrong',
            ]);
        }
        User::where('id',auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        return response()->success([
            'current_password' => $request->current_password,
            'new_password' => $request->new_password,
        ]);
    }

    public function updateProfile(Request $request){
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|max:191|email|unique:users,email,'.$user_id,
            'phone' => 'required|max:191',
            'service_area' => 'required|max:191',
            'post_code' => 'required|max:191',
            'address' => 'required|max:191',
            'about' => 'required|max:5000'
        ]);

        $old_image = User::select('image')->where('id',auth()->user()->id)->first();
        $user_update = User::where('id', auth()->user()->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $request->image ?? $old_image->image,
                'profile_background' => $request->profile_background ?? $old_image->profile_background,
                'service_city' => $request->service_city ?? $user->service_city,
                'service_area' => $request->service_area ?? $user->service_area,
                'country_id' => $request->country ?? $user->country,
                'post_code' => $request->post_code,
                'address' => $request->address,
                'about' => $request->about,
            ]);



        if($user_update){
            return response()->success([
                'message' =>__('Profile Updated Success'),
            ]);
        }
    }
}
