  <section class="page-title-bar page-title-bar-02">
    <div class="page-title-bar-overlay"></div>
    <div class="page-title-bar-inner">
      <div class="container">
        <div class="row row-xs-center">
          <div class="col-md-6">
            <div class="page-title-bar-heading">
              <h1 class="heading">{{ $data->title_extra }}</h1>
            </div>
          </div>
          <div class="col-md-6">
            <div id="page-breadcrumb" class="page-breadcrumb">
              <ul class="breadcrumb">
                <li><a href="#">Главная</a></li>
                @foreach ($category->ancestors as $ancestor)
                  @unless($ancestor->parent_id != NULL && $ancestor->children->count() > 0)
                    <li><a href="/catalog/{{ $ancestor->slug . '/' . $ancestor->id }}">{{ $ancestor->title }}</a></li>
                  @endunless
                  <li><a href="/catalog/{{ $ancestor->slug  .'/'.$category->slug . '/' . $category->id }}">{{ $category->title }}</a></li>
                @endforeach
                <li class="sub tail current">{{ $data->title }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>