@extends('frontend.frontend-page-master')
@section('site-title')
    {{ __('Order Success') }}
@endsection

@section('page-title')
    <?php 
    $page_info = request()->url();
    $str = explode("/",request()->url());
    $page_info = $str[count($str)-2];
    ?>  
    {{ ucfirst($page_info) }}
@endsection 

@section('inner-title')
    {{ __('Order') }}
@endsection 

@section('content')
   <!-- Location Overview area starts -->
 <section class="location-overview-area padding-top-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="msform" class="msform">
                    <!-- Successful Complete -->
                    <fieldset class="padding-top-80 padding-bottom-100">
                        <div class="form-card successful-card">
                            <h2 class="title-step"> {{ get_static_option('success_title') ?? __('SUCCESSFULL') }}</h2>
                            <a href="{{ route('homepage') }}" class="succcess-icon">
                                <i class="las la-check"></i>
                            </a>
                            <h5 class="purple-text text-center">{{ get_static_option('success_subtitle') ?? __('Your Order Successfully Completed') }}</h5>
                            <div class="btn-wrapper margin-top-35">
                                <h4 class="mb-3">{{ get_static_option('success_details_title') ?? __('Your Order Details') }}</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Date & Schedule') }}</th>
                                            <th>{{ __('Amount Details') }}</th>
                                            <th>{{ __('Order Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label><strong>{{ __('Date:') }} </strong>{{ $order_details->date }}</label> <br>
                                                <label><strong>{{ __('Schedule:') }} </strong>{{ $order_details->schedule }}</label>
                                            </td>
                                            <td>
                                                <label><strong>{{ __('Package Fee:') }} </strong>{{ float_amount_with_currency_symbol($order_details->package_fee) }}</label> <br>
                                                @if($order_details->extra_service >=1)
                                                <label><strong>{{ __('Extra Service:') }} </strong>{{ float_amount_with_currency_symbol($order_details->extra_service) }}</label> <br>
                                                @endif
                                                <label><strong>{{ __('Sub Total: ') }}</strong>{{ float_amount_with_currency_symbol($order_details->sub_total) }}</label> <br>
                                                <label><strong>{{ __('Tax:') }} </strong>{{ float_amount_with_currency_symbol($order_details->tax) }}</label> <br>
                                                @if(!empty($order_details->coupon_amount))
                                                    <label><strong>{{ __('Coupon Amount:') }} </strong>{{ float_amount_with_currency_symbol($order_details->coupon_amount) }}</label> <br>
                                                @endif
                                                <label><strong>{{ __('Total:') }} </strong>{{ float_amount_with_currency_symbol($order_details->total) }}</label> <br>
                                                <label><strong>{{ __('Payment Gateway:') }} </strong>{{ ucwords(str_replace("_", " ", $order_details->payment_gateway)) }}</label> <br>
                                                <label><strong>{{ __('Payment Status:') }} </strong>{{ ucfirst($order_details->payment_status) }}</label> <br>
                                            </td>
                                            <td>
                                                <label><strong>{{ __('Order Status: ') }}</strong>
                                                    @if ($order_details->status == 0) <span>{{ __('Pending') }}</span>@endif
                                                    @if ($order_details->status == 1) <span>{{ __('Active') }}</span>@endif
                                                    @if ($order_details->status == 2) <span>{{ __('Completed') }}</span>@endif
                                                    @if ($order_details->status == 3) <span>{{ __('Delivered') }}</span>@endif
                                                    @if ($order_details->status == 4) <span>{{ __('Cancelled') }}</span>@endif
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="btn-wrapper text-center margin-top-35">
                                <a href="{{ get_static_option('button_url') ?? route('homepage') }}" class="cmn-btn btn-bg-1">{{ get_static_option('button_title') ?? __('Back To Home') }}</a>
                                @if(auth('web')->check())
                                    @php
                                    $user_details = auth('web')->user();
                                    $route_prefix = $user_details->user_type === 0 ? 'seller' : 'buyer';
                                    @endphp
                                    <a href="{{ route($route_prefix.'.dashboard') }}" class="cmn-btn btn-bg-1">{{__('Go To Dashboard') }}</a>
                                    <a href="{{ route($route_prefix.'.orders') }}" class="cmn-btn btn-bg-1">{{__('All Orders') }}</a>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Location Overview area end -->
@endsection





