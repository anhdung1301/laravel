@extends('master')
@section('content')
    <div class="container">
        <div id="content" class="space-top-none">
            <div class="main-content">
                <div class="space60">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="beta-products-list">
                            <h4>Tim kiem</h4>
                            <div class="beta-products-details">
                                <p class="pull-left">Tìm thấy {{count($product)}}</p>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                @foreach($product as $ps)
                                    <div class="col-sm-3">
                                        <div class="single-item">
                                            @if($ps->promotion_price != 0)
                                                <div class="ribbon-wrapper">
                                                    <div class="ribbon sale">Sale</div>
                                                </div>
                                            @endif
                                            <div class="single-item-header">
                                                <a href="{{route('chitietsanpham',$ps->id)}}"><img src="source/image/product/{{$ps->image}}"
                                                                                                    alt="" height="250px"></a>
                                            </div>
                                            <div class="single-item-body">
                                                <p class="single-item-title">{{$ps->name}}</p>
                                                <p class="single-item-price">
                                                    @if($ps->promotion_price == 0)
                                                        <span class="lash-sale">{{$ps->unit_price}}</span>
                                                    @else
                                                        <span class="flash-del">{{$ps->unit_price}}</span>
                                                        <span class="flash-sale">{{$ps->promotion_price}}</span>
                                                    @endif

                                                </p>
                                            </div>
                                            <div class="single-item-caption">
                                                <a class="add-to-cart pull-left" href="{{route('themgiohang',$ps->id)}}"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="beta-btn primary" href="product.html">Details <i
                                                        class="fa fa-chevron-right"></i></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div> <!-- .beta-products-list -->

                        <div class="space50">&nbsp;</div>

                    </div> <!-- end section with sidebar and main content -->


                </div> <!-- .main-content -->
            </div> <!-- #content -->
        </div>
@endsection
