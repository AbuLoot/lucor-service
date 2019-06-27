@extends('layout')

@section('title_description', '')

@section('meta_description', '')

@section('menu')
  <li><a href="#about">О компании</a></li>
  <li><a href="#products">Продукция</a></li>
  <li><a href="#advantages">Преимущества</a></li>
  <li><a href="#contacts">Контакты</a></li>
@endsection

@section('content')
    <!-- SLIDE -->
    <div class="bd-example">
      <div id="carouselCaptions" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/assets/img/bg/bg-potolki-1.jpg" class="d-block w-100 w-xs-200" alt="...">
            <div class="carousel-caption">
              <h2>Мир подвесных потолков и осветительных приборов!</h2>

              <ul class="questions-pain">
                <li>Трудность в выборе потолков?</li>
                <li>Малый ассортимент материала?</li>
                <li>Сомнения в оригинальности товара?</li>
              </ul>

              <p class="solution-pain">Если вы столкнулись с проблемой выбора, приглашаем в Lucor Service. Наши менеджеры помогут вам разрешить самые серъезные вопросы!</p>
              <p class="solution-pain-xs">Наши менеджеры помогут вам разрешить самые серъезные вопросы!</p>

              <!-- Button trigger modal -->
              <button type="button" class="btn-custom d-block d-sm-none" data-toggle="modal" data-target="#appModal"><i class="fa fa-pen-fancy"></i> Оставить заявку</button>

              <div class="d-none d-sm-block">
                <!-- <p>Проконсультируйтесь с нашими специалистами для выбора подходящего подвесного потолка и для расчета расхода материалов.</p> -->
                <form class="offer-form" action="/send-app" method="POST">
                  {{ csrf_field() }}
                  <div class="form-row">
                    <div class="col-md-4">
                      <input type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" placeholder="Введите имя" minlength="2" maxlength="40" value="" required>
                    </div>
                    <div class="col-md-4">
                      <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" id="phone" name="phone" placeholder="Введите номер телефона" placeholder="Введите номер телефона" minlength="5" maxlength="20" value="" required>
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn-custom mb-2"><i class="fa fa-send"></i> Оставить заявку</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ABOUT 2 -->
    <section class="offer-style-one" id="about">
      <div class="container">
        <div class="row">
          <div class="offset-sm-2 col-lg-8 d-flex">
            <div class="content-block my-auto text-center right-line">
              <div class="title-block">
                <span class="tag-line">О компаний</span>
                <h2>Lucor Service</h2>
              </div>
              <p>Компания «Lucor Service» предлагает широкий ассортимент подвесных потолков, которые подойдут для обустройства жилых домов, а также общественных, коммерческих и производственных объектов. Для любого проекта специалисты способны подобрать наиболее подходящее по характеристикам и бюджету решение.</p>
              <p>В ассортименте компании «Lucor Service» присутствуют разные варианты для всех клиентов. Мы предлагаем реечные, гигиенические, ячеистые, акустические системы. Мы используем лучшие товары от таких известных производителей  как «Armstrong», «Rockfon», «Албес», а также качественную продукцию китайских брендов. Наши специалисты подберут подходящие потолки в зависимости от типа помещения и бюджета. Каждый вариант имеет определенные особенности монтажа, разную функциональность и декоративные особенности.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    @foreach($categories as $category)
      <!-- BG OF CATEGORY -->
      <section class="page-title-block" id="products" style="background-image: url(img/slide/{{ $category->image }});  background-size: cover; background-position: top center; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="container">
          <h2>{{ $category->title_extra }}</h2><br>
          <a href="/catalog/{{ $category->slug }}" class="btn-custom">Подробнее</a>
        </div>
      </section>

      <!-- PRODUCTS -->
      <section class="service-style-one">
        <div class="container">
          <!-- <p class="d-none d-sm-block">Знаменитые потолки армстронг из минерального волокна заслужили всенародную любовь клиентов. Эти изделия настолько популярны, что само название Armstrong стало нарицательным. </p> -->
          <!-- <br> -->

          <?php $company = \App\Company::where('slug', $category->slug)->first(); ?>

          <div class="d-flex justify-content-center">
            @if(isset($company->logo))
              <img src="/img/companies/{{ $company->logo }}">
            @endif
          </div>
          <div class="upper-block">
            <div class="title-block">
              <span class="tag-line">Каталог</span>
            </div>
            <div class="carousel-btn-block service-carousel-btn">
              <span class="carousel-btn left-btn"><i class="cameron-icon-left-arrow"></i></span>
              <span class="carousel-btn right-btn"><i class="cameron-icon-right-arrow"></i></span>
            </div>
          </div>

          <div class="services-carousel-one">
            @foreach($category->products->take(4) as $product)
            <?php $images = unserialize($product->images); ?>
              <div class="item">
                <div class="single-service-one">
                  <div class="image-block">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                    <div class="overlay-block">
                      <a class="more-link" href="/img/products/{{ $product->path.'/'.$images[0]['image'] }}"><i class="fa fa-arrows-alt"></i></a>
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
      </section>
    @endforeach

    <!-- ADVANTAGES -->
    <section class="offer-style-one" id="advantages">
      <div class="container">
        <div class="title-block">
          <span class="tag-line">Преимущества</span>
          <h2>В чем преимущества подвесных потолков?</h2>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="single-offer-style-one">
              <div class="icon-block">
                <i class="cameron-icon-star"></i>
              </div>
              <h3>Дизайн</h3>
              <p>Подвесные потолки позволяют скрыть бросающиеся в глаза неровности бетонных перекрытий, а также спрятать кабели, вентиляционные отверстия и другие коммуникации.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="single-offer-style-one">
              <div class="icon-block">
                <i class="cameron-icon-coffee-cup"></i>
              </div>
              <h3>Комфорт</h3>
              <p>Панели подвесных потолков дополнительно выполняют теплоизоляционную функцию и заметно снижают уровень шума, создавая более комфортные условия для жизни.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="single-offer-style-one">
              <div class="icon-block">
                <i class="cameron-icon-smile"></i>
              </div>
              <h3>Экологичность</h3>
              <p>Подвесные потолки производятся из безопасных и экологически чистых материалов. Некоторые виды панелей обладают эффектом светоотражения и помогают создавать мягкое рассеянное освещение в комнате, экономя при этом электроэнергию.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="single-offer-style-one">
              <div class="icon-block">
                <i class="cameron-icon-briefcase"></i>
              </div>
              <h3>Практичность</h3>
              <p>Важное преимущество – быстрый и несложный монтаж потолочных конструкций. Пришедшие в негодность панели модульных подвесных потолков легко заменяются на новые, не требуя при этом полного демонтажа конструкции.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BG OF CATEGORY 2
    <section class="cta-style-one">
      <div class="container">
        <div class="title-block">
          <span class="tag-line">Предложение</span>
          <h2 class="text-white">Консультация опытного специалиста поможет вам выбрать подходящую модель потолка, произвести расчет расхода материалов.</h2>
        </div>
        <form class="offer-form" action="/send-app" method="POST">
          <div class="form-row">
            <div class="col-md-4">
              <input type="text" class="form-control mb-2 mr-sm-2" id="name" placeholder="Введите имя" minlength="2" maxlength="40" value="" required>
            </div>
            <div class="col-md-4">
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" id="phone" placeholder="Введите номер телефона" placeholder="Введите номер телефона" minlength="5" maxlength="20" value="" required>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn-custom mb-2"><i class="fa fa-send"></i> Отправить</button>
            </div>
          </div>
        </form>
      </div>
    </section> -->

    <!-- OFFER & FORM APP -->
    <section class="offer-section">
      <div class="container">
        <div class="title-block">
          <span class="tag-line">Предложение</span>
          <h2>Консультация опытного специалиста поможет вам выбрать подходящую модель потолка, произвести расчет расхода материалов.</h2>
        </div>

        <form class="offer-form" action="/send-app" method="POST">
          {{ csrf_field() }}
          <div class="form-row">
            <div class="col-md-4">
              <input type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" placeholder="Введите имя" minlength="2" maxlength="40" value="" required>
            </div>
            <div class="col-md-4">
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" id="phone" name="phone" placeholder="Введите номер телефона" placeholder="Введите номер телефона" minlength="5" maxlength="20" value="" required>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn-custom mb-2"><i class="fa fa-send"></i> Отправить</button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <!-- PROCESS -->
    <section class="working-process-one">
      <div class="container">
        <div class="title-block">
          <span class="tag-line">Сотрудничество</span>
          <h2>При сотрудничестве с нами вы получите ряд преимуществ.</h2>
        </div>
        <div class="working-process-wrap row">
          <div class="single-working-process-one col-lg-3">
            <div class="count-block">01</div>
            <h3>Индивидуальные скидки от обьема</h3>
            <p>Мы поставляем все востребованные разновидности подвесных потолков от ведущих мировых производителей в необходимых объемах. Если вы оптовый покупатель, вам полагаются дополнительные скидки на товар в зависимости от кол-ва купленной продукции и суммы заказа.</p>
          </div>
          <div class="single-working-process-one col-lg-3">
            <div class="count-block">02</div>
            <h3>Большой ассортимент</h3>
            <p>В нашем каталоге вся продукция логично распределена по разделам. Если вы захотите купить потолки, то здесь вы легко сможете найти любой вариант а также ознакомиться с характеристиками продукции.</p>
          </div>
          <div class="single-working-process-one col-lg-3">
            <div class="count-block">03</div>
            <h3>Удобное расположение офиса</h3>
            <p>Наш офис находится в центре строительного сегмента г. Алматы. А так же имеет большую парковку.</p>
          </div>
          <div class="single-working-process-one col-lg-3">
            <div class="count-block">04</div>
            <h3>Быстрая и бережная доставка</h3>
            <p>Доставка осуществляется любыми транспортными компаниями по выбору клиента. Со своей стороны постоянным покупателям и  оптовикам  мы готовы посодействовать в выборе автотранспорта и расчете стоимости доставки наиболее удобной компании-грузоперевозчика.</p>
          </div>
        </div>
      </div>
    </section>

@endsection