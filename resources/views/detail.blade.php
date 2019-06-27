@extends('layout')

@section('title_description', $product->title_description)

@section('meta_description', $product->meta_description)

@section('menu')
  <li><a href="/#about">О компании</a></li>
  <li><a href="/#products">Продукция</a></li>
  <li><a href="/#advantages">Преимущества</a></li>
  <li><a href="/#contacts">Контакты</a></li>
@endsection

@section('content')
    <section class="single-shop-page">
      <div class="container">
        <div class="single-shop-item  single-shop-page-content">
          <div class="row">
            <div class="col-lg-7">
              <?php $images = unserialize($product->images); ?>
              <div id="carouselControls" class="carousel slide" data-interval="false" data-ride="carousel">
                <div class="carousel-inner">
                  @if ($product->images != '')
                    @foreach ($images as $k => $image)
                      <div class="carousel-item @if($k == 0) active @endif">
                        <div class="img-box">
                          <a href="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" class="product-zoomer img-popup"><i class="fa fa-search-plus"></i></a>
                          <img src="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" class="img-fluid" alt="{{ $product->title }}" />
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="carousel-item">
                      <a href="/img/shop/shop_707x954.jpg" class="mfp-image gallery-item"><img src="/img/shop/shop_707x954.jpg" alt="" /></a>
                    </div>
                  @endif
                </div>
                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="col-lg-5 d-flex">
              <div class="text-box my-auto">
                <div class="content-box">
                  <h3>{{ $product->title }}</h3>
                  <p class="price"><span>{{ $product->price }} 〒</span></p>
                  <hr />
                  {!! $product->characteristic !!}
                  <hr />
                  {!! $product->description !!}
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="shop-style-one product-related-block">
      <div class="container">
        <div class="upper-block">
          <div class="title-block">
            <span class="tag-line">Похожие продукты</span>
          </div>
          <div class="carousel-btn-block related-carousel-btn">
            <span class="carousel-btn left-btn"><i class="cameron-icon-left-arrow"></i></span>
            <span class="carousel-btn right-btn"><i class="cameron-icon-right-arrow"></i></span>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="owl-carousel owl-theme related-product-carousel-one">
            @foreach($category->products as $product)
              <div class="item">
                <div class="single-service-one">
                  <div class="image-block">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                    <div class="overlay-block">
                      <a class="more-link" href="/img/products/{{ $product->path.'/'.$product->image }}"><i class="fa fa-arrows-alt"></i></a>
                    </div>
                  </div>
                  <div class="text-block">
                    <h3><a href="/product/{{ $product->slug }}">{{ $product->title }}</a></h3>
                    {!! $product->characteristic !!}
                    <a href="/product/{{ $product->slug }}" class="more-btn">Подробнее</a>
                  </div>
                </div>
              </div>
            @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection