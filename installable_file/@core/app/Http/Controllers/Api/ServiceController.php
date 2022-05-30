<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\Review;
use App\Service;
use App\Servicebenifit;
use App\Serviceinclude;
use App\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //top selling services
    public function topService(){
        $top_services = Service::select('id','title','image','price','seller_id')
            ->with('reviews_for_mobile')
            ->whereHas('reviews_for_mobile')
            ->where('status','1')
            ->where('is_service_on','1')
            ->orderBy('sold_count','Desc')
            ->take(10)
            ->get();
        $service_image=[];
        $service_seller_name=[];
        $reviewer_image=[];
        foreach($top_services as $service){
            $service_image[]= get_attachment_image_by_id($service->image);
            $service_seller_name[]= optional($service->seller_for_mobile)->name;
            foreach($service->reviews_for_mobile as $review){
                $reviewer_image[]=get_attachment_image_by_id(optional($review->buyer_for_mobile)->image);
            }
        }

        if($top_services){
            return response()->success([
                'top_services'=>$top_services,
                'service_image'=>$service_image,
                'service_seller_name'=>$service_seller_name,
                'reviewer_image'=>$reviewer_image,
            ]);
        }
        return response()->error([
            'message'=>'Service Not Available',
        ]);
    }

    //latest services
    public function latestService()
    {
        $latest_services = Service::select('id','title','image','price','seller_id')
            ->with('reviews_for_mobile')
            ->where('status','1')
            ->where('is_service_on','1')
            ->latest()
            ->take(10)
            ->get();
        $service_image=[];
        $service_seller_name=[];
        $reviewer_image=[];
        foreach($latest_services as $service){
            $service_image[]= get_attachment_image_by_id($service->image);
            $service_seller_name[]= optional($service->seller_for_mobile)->name;
            foreach($service->reviews_for_mobile as $review){
                $reviewer_image[]=get_attachment_image_by_id(optional($review->buyer_for_mobile)->image);
            }
        }

        if($latest_services){
            return response()->success([
                'latest_services'=>$latest_services,
                'service_image'=>$service_image,
                'service_seller_name'=>$service_seller_name,
                'reviewer_image'=>$reviewer_image,
            ]);
        }
        return response()->error([
            'message'=>'Service Not Available',
        ]);
    }

    // service details
    public function serviceDetails($id=null){
        $service_details = Service::where('status',1)->where('is_service_on',1)->where('id',$id)->first();
        $service_image = get_attachment_image_by_id($service_details->image);
        $service_seller_name = optional($service_details->seller_for_mobile)->name;
        $service_seller_image_Id = optional($service_details->seller_for_mobile)->image;
        $service_seller_image = get_attachment_image_by_id($service_seller_image_Id);
        $seller_complete_order = Order::where('seller_id',$service_details->seller_id)->where('status',2)->count();
        $seller_cancelled_order = Order::where('seller_id', $service_details->seller_id)->where('status', 4)->count();
        $seller_rating = Review::where('seller_id', $service_details->seller_id)->avg('rating');
        $seller_rating_percentage_value = round($seller_rating * 20);
        $seller_from = optional(optional($service_details->seller_for_mobile)->country)->country;
        $seller_since = User::select('created_at')->where('id', $service_details->seller_id)->where('user_status', 1)->first();
        $service_includes = Serviceinclude::select('id','service_id','include_service_title')->where('service_id', $service_details->id)->get();
        $service_benifits = Servicebenifit::select('id','service_id','benifits')->where('service_id', $service_details->id)->get();

        $order_completion_rate = 0;
        if ($seller_complete_order > 0 || $seller_cancelled_order > 0) {
            $order_completion_rate = $seller_complete_order / ($seller_complete_order + $seller_cancelled_order) * 100;
        }

        $service_reviews = $service_details->reviews_for_mobile;
        $reviewer_image=[];
        foreach($service_details->reviews_for_mobile as $review){
            $reviewer_image[]=get_attachment_image_by_id(optional($review->buyer_for_mobile)->image);
        }

        if($service_details){
            return response()->success([
                'service_details'=>$service_details,
                'service_image'=>$service_image,
                'service_seller_name'=>$service_seller_name,
                'service_seller_image'=>$service_seller_image,
                'seller_complete_order'=>$seller_complete_order,
                'seller_rating'=>$seller_rating_percentage_value,
                'order_completion_rate'=>round($order_completion_rate),
                'seller_from'=>$seller_from,
                'seller_since'=>$seller_since,
                'service_includes'=>$service_includes,
                'service_benifits'=>$service_benifits,
                'service_reviews'=>$service_reviews,
                'reviewer_image'=>$reviewer_image,
            ]);
        }
        return response()->error([
            'message'=>'Service Not Available',
        ]);
    }

    //service rating
    public function serviceRating(Request $request,$id=null){
        $request->validate([
            'rating' => 'required|integer',
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'message' => 'required',
        ]);

        $service_details = Service::select('id','seller_id')->where('id',$id)->first();
        $add_rating = Review::create([
            'service_id' => $service_details->id,
            'seller_id' => $service_details->seller_id,
            'buyer_id' => auth()->user()->id,
            'rating' => $request->rating,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        if($add_rating){
            return response()->success([
                'message'=>'Review Added Success',
            ]);
        }
    }
}
