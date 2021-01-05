@extends('master')
@section('content')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
	.mySlides {
		display:none;
		width:100%;
		height: 500px;
		background-repeat: none;
		background-size: cover;
		background-position: center;
	}
	.w3-section{
		max-width:100%
	}
</style>

<div class="fullwidthbanner-container">
	<div class="fullwidthbanner">
		<div class="w3-content w3-section">
			@foreach($slide as $sl)
		  		<img class="mySlides" src="source/image/slide/{{$sl->image}}">
		 	@endforeach
		</div>
		<div class="tp-bannertimer"></div>
	</div>
</div>
	<!--slider-->
</div>
<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<h1>Sản phẩm mới</h1>
							<div class="beta-products-details">
								<p class="pull-left"><h4>Tìm thấy {{count($new_product)}} sản phẩm</h4></p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
								@foreach($new_product as $new)
								<div class="col-sm-3" style="margin-bottom: 10px">
									<div class="single-item">
										@if($new->promotion_price !=0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
										@endif
										<div class="single-item-header">
											<a href="{{route('chitietsanpham', $new->id)}}"><img src="source/image/product/{{$new->image}}" alt="" height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$new->name}}</p>
											<p class="single-item-price" style="font-size: 16px">
												@if($new->promotion_price == 0)
													<span class="flash-sale">{{number_format($new->unit_price)}} đồng</span>
												@else
													<span class="flash-del">{{number_format($new->unit_price)}} đồng</span>
													<span class="flash-sale">{{number_format($new->promotion_price)}} đồng</span>
												@endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('themgiohang', $new->id)}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('chitietsanpham', $new->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endforeach
							</div>	
							<div class="row">{{$new_product->links()}}</div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h1>Sản phẩm khuyến mãi</h1>
							<div class="beta-products-details">
								<p class="pull-left"><h4>Tìm thấy {{count($sanpham_khuyenmai)}} sản phẩm</h4></p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
								@foreach($sanpham_khuyenmai as $spkm)
								<div class="col-sm-3" style="margin-bottom: 10px">
									<div class="single-item">
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>

										<div class="single-item-header">
											<a href="{{route('chitietsanpham', $spkm->id)}}"><img src="source/image/product/{{$spkm->image}}" alt="" height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$spkm->name}}</p>
											<p class="single-item-price" style="font-size: 16px">
												<span class="flash-del">{{number_format($spkm->unit_price)}} đồng</span>
												<span class="flash-sale">{{number_format($spkm->promotion_price)}} đồng</span>
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('themgiohang', $new->id)}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('chitietsanpham', $spkm->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="row">{{$sanpham_khuyenmai->links()}}</div>
							
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
<script>
	var myIndex = 0;
	carousel();

	function carousel() {
	  var i;
	  var x = document.getElementsByClassName("mySlides");
	  for (i = 0; i < x.length; i++) {
	    x[i].style.display = "none";  
	  }
	  myIndex++;
	  if (myIndex > x.length) {myIndex = 1}    
	  x[myIndex-1].style.display = "block";  
	  setTimeout(carousel, 4000); // Change image every 2 seconds
	}
</script>
@endsection