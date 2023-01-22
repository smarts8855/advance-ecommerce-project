@extends('frontend.main_master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@section('title')
Paystack Payment Page
@endsection


<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="home.html">Home</a></li>
				<li class='active'>Paystack</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="checkout-box ">
			<div class="row">
	
				

	
<div class="col-md-6">
					<!-- checkout-progress-sidebar -->
<div class="checkout-progress-sidebar ">
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h4 class="unicase-checkout-title">Your Shopping Amount</h4>
		    </div>
		    <div class="">
				<ul class="nav nav-checkout-progress list-unstyled">
                    
                    
					<li>
                        @if(Session::has('coupon'))

                        <strong>SubTotal: </strong> ${{ $cartTotal }} <hr>

                        <strong>Coupon Name: </strong> {{ session()->get('coupon')['coupon_name'] }}
                        ( {{ session()->get('coupon')['coupon_discount'] }} % )
                         <hr>

                        <strong>Coupon Discount: </strong> ${{ session()->get('coupon')['discount_amount'] }}                        
                         <hr>

                        <strong>Grant Total: </strong> ${{ session()->get('coupon')['total_amount'] }}                        
                         <hr>

                        @else
                       
                        

                        <strong>SubTotal: </strong> ${{ $cartTotal }} <hr>

                        <strong>Grand Total: </strong> ${{ $cartTotal }} <hr>

                        @endif
                        
                       
                    </li>
					
                    
				</ul>		
			</div>
		</div>
	</div>
</div> 
<!-- checkout-progress-sidebar -->
</div><!-- // end col md 6 -->


<div class="col-md-6">
					<!-- checkout-progress-sidebar -->
<div class="checkout-progress-sidebar ">
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h4 class="unicase-checkout-title">Make Your Payment </h4>
		    </div>
			
			<form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
			{{ csrf_field() }}

			<input type="hidden" name="name" value="{{ $data['shipping_name'] }}">
			<input type="hidden" name="email" value="{{ $data['shipping_email'] }}">
			<input type="hidden" name="phone" value="{{ $data['shipping_phone'] }}">
			<input type="hidden" name="post_code" value="{{ $data['post_code'] }}">
			<input type="hidden" name="division_id" value="{{ $data['division_id'] }}">
			<input type="hidden" name="district_id" value="{{ $data['district_id'] }}">
			<input type="hidden" name="state_id" value="{{ $data['state_id'] }}">
			<input type="hidden" name="note" value="{{ $data['notes'] }}">
			<button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!"> <i class="fa fa-plus-circle fa-lg"></i> Pay Now! </button>
			</form>

			

		

		</div>
	</div>
</div> 
<!-- checkout-progress-sidebar -->
</div><!-- // end col md 6 -->


			</div><!-- /.row -->
		</div><!-- /.checkout-box -->
		<!-- ======== BRANDS CAROUSEL ======== -->

<!-- =========== BRANDS CAROUSEL : END ======== -->	
</div><!-- /.container -->
</div><!-- /.body-content -->

<!-- place below the html form -->



@endsection