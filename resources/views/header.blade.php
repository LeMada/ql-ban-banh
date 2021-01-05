<style type="text/css">
	label#lbeltongtien {
    float: left;
}
</style>
<div id="header">
		<div class="header-top">
			<div class="container">
				<div class="pull-left auto-width-left">
					<ul class="top-menu menu-beta l-inline">
						<li><a href=""><i class="fa fa-home"></i> Le Mada</a></li>
						<li><a href=""><i class="fa fa-phone"></i> 092 26 38 731</a></li>
					</ul>
				</div>
				<div class="pull-right auto-width-right">
					<ul class="top-details menu-beta l-inline">
						<li><a href="{{route('admin')}}"><i class="fa fa-user"></i>Tài khoản</a></li>
						@if(Auth::check())						
							<li><a href="">Chào bạn {{Auth::user()->full_name}}</a></li>
							<li><a href="{{route('logout')}}">Đăng xuất</a></li>
						@else
							<li><a href="{{route('signin')}}">Đăng ký</a></li>
							<li><a href="{{route('login')}}">Đăng nhập</a></li>
						@endif
					</ul>
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-top -->
		<div class="header-body">
			<div class="container beta-relative">
				<div class="pull-left">
					<a href="index.html" id="logo"><img src="source/assets/dest/images/logo-cake.png" width="200px" alt=""></a>
				</div>
				<div class="pull-right beta-components space-left ov">
					<div class="space10">&nbsp;</div>
					<div class="beta-comp">
						<form role="search" method="get" id="searchform" action="{{route('search')}}">
					        <input type="text" value="" name="key" id="s" placeholder="Nhập từ khóa..." />
					        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
						</form>
					</div>

					<div class="beta-comp">
						@if(Session::has('cart'))
						<div class="cart">
							<div class="beta-select"><i class="fa fa-shopping-cart"></i> Giỏ hàng 
								(<span id="tongsl">@if(Session::has('cart')){{Session('cart')->totalQty}} @else Trống @endif</span>) <i class="fa fa-chevron-down"></i></div>
							<div class="beta-dropdown cart-body">
								
								@foreach($product_cart as $product)
								<div class="cart-item" id="cart-item{{$product['item']['id']}}">
									<!-- href="{{route('xoagiohang',$product['item']['id'])}}" --> 
									<a class="cart-item-delete" value="{{$product['item']['id']}}"soluong="{{$product['qty']}}"><i class="fa fa-times"></i></a>
									<div class="media">
										<a class="pull-left" href="#"><img src="source/image/product/{{$product['item']['image']}}" alt=""></a>
										<div class="media-body">
											<span class="cart-item-title">{{$product['item']['name']}}</span>			
											<span class="cart-item-amount">{{$product['qty']}}*<span id="dongia" value="@if ($product['item']['promotion_price']==0){{($product['item']['unit_price'])}}  @else {{($product['item']['promotion_price'])}} @endif"> @if ($product['item']['promotion_price']==0){{number_format($product['item']['unit_price'])}}  @else {{number_format($product['item']['promotion_price'])}} @endif </span></span>
										</div>
									</div>
								</div>
								@endforeach
								
								<div class="cart-caption">
									<!-- <div class="cart-total text-right">Tổng tiền: <span class="cart-total-value">@if($product['item']['promotion_price']==0){{number_format($product['item']['unit_price'])}} @else {{number_format($product['item']['promotion_price'])}} @endif</span></div>
									<div class="clearfix"></div> -->
									<div class="cart-total text-right">
										<label id="lbeltongtien">Tổng tiền: </label>
										<input type="text" disabled="" value="{{($totalPrice)}}" class="cart-total-value" id="cart-total-value">
										<!-- <span class="cart-total-value" value="
										@if(Session::has('cart')){{($totalPrice)}} @else 0 @endif">
										@if(Session::has('cart')){{number_format($totalPrice)}} 
										@else 0 @endif đồng
										</span> -->
									
									</div> <br>
									<div class="clearfix"></div>
									<div class="center">
										<div class="space10">&nbsp;</div>
										<a href="{{route('dathang')}}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>
						</div> <!-- .cart -->
						@endif
					</div>
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-body -->
		<div class="header-bottom" style="background-color: #0277b8;">
			<div class="container">
				<a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
				<div class="visible-xs clearfix"></div>
				<nav class="main-menu">
					<ul class="l-inline ov">
						<li><a href="{{route('trang-chu')}}">Trang chủ</a></li>
						<li><a href="#">Loại sản phẩm</a>
							<ul class="sub-menu">
								@foreach($loai_sp as $loai)
								<li><a href="{{route('loaisanpham', $loai->id)}}">{{$loai->name}}</a></li>
								@endforeach
							</ul>
						</li>
						<li><a href="{{route('gioithieu')}}">Giới thiệu</a></li>
						<li><a href="{{route('lienhe')}}">Liên hệ</a></li>
					</ul>
					<div class="clearfix"></div>
				</nav>
			</div> <!-- .container -->
		</div> <!-- .header-bottom -->
	</div> <!-- #header -->
<script src="source/assets/dest/js/jquery.js"></script>
<script>
	$(document).ready(function($) {  
		$('.cart-item-delete').click(function(){
			var id = $(this).attr('value');
			var route ="{{ route('xoagiohang',':id_sp') }}";
			var soluong = $(this).attr('soluong');
			var dongia = $('#dongia'+id).attr('value');
			var tongdongia = $('.cart-total-value').attr('value');
			route = route.replace(':id_sp',id);
			$.ajax({
				url: route,
				type:'get',
				data:{id:id},
				success:function(data){
					
					var tongsl = $('#tongsl').html();
					$('#tongsl').html(parseInt(tongsl) - parseInt(soluong));

					$('.cart-total-value').html(parseInt(tongdongia) - (parseInt(soluong)*parseInt(dongia)) + ' đồng');
					$('.cart-total-value').attr('value', data);
					$('#cart-item'+id).hide();
				},
				error:function(data){
					console.log(data)
				}
			})
		})
	})
</script>