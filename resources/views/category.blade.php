@extends('layout')

@section('title_description', $category->title_description)

@section('meta_description', $category->meta_description)

@section('menu')
  <li><a href="/#about">О компании</a></li>
  <li><a href="/#products">Продукция</a></li>
  <li><a href="/#advantages">Преимущества</a></li>
  <li><a href="/#contacts">Контакты</a></li>
@endsection

@section('content')

    <!-- <section class="page-title-block text-center"style="background-image: url(/img/slide/{{ $category->image }});  background-size: cover; background-position: top center; background-repeat: no-repeat; background-attachment: fixed;">
      <div class="container text-white">
        <h2>{{ $category->title_extra }}</h2>
      </div>
    </section> -->
    <section class="blog-style-three">
      <div class="container">

          <?php $company = \App\Company::where('slug', $category->slug)->first(); ?>

          <div class="d-flex justify-content-center">
            @if(isset($company->logo))
              <img src="/img/companies/{{ $company->logo }}">
            @endif
          </div><br>
        <!-- <h2>{{ $category->title }}</h2> -->
        {!! $category->content !!}

        <br>

          <div class="upper-block">
            <div class="title-block">
              <span class="tag-line">Каталог</span>
            </div>
          </div>
        <div class="row">
          @foreach($category->products as $product)
            <?php $images = unserialize($product->images); ?>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="single-blog-style-three">
                <div class="image-block">
                  <img src="/img/products/{{ $product->path.'/'.$product->image }}" class="img-fluid" alt="{{ $product->title }}">
                  <div class="overlay-block">
                    <a class="more-link" href="/img/products/{{ $product->path.'/'.$images[0]['image'] }}"><i class="fa fa-arrows-alt"></i></a>
                  </div>
                </div>
                <div class="text-block">
                  <h3><a href="/product/{{ $product->slug }}">{{ $product->title }}</a></h3>
                  <div class="meta-info">
                    {!! $product->characteristic !!}<br>
                    <a href="/product/{{ $product->slug }}" class="more-btn">Подробнее</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection