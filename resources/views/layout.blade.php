<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/favicon.png" type="image/x-icon"/>
  <link rel="shortcut icon" href="/favicon.png" type="image/x-icon"/>

  <title>@yield('title_description', 'Lucor Service')</title>
  <meta name="description" content="@yield('meta_description', 'Lucor Service')">

  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/responsive.css">
</head>
<body>
  <div class="page-wrapper">
    <header class="main-header header-style-two">
      <div class="top-header">
        <div class="container">
          <div class="left-info d-none d-sm-block">
            <p><i class="cameron-icon-email"></i><a href="mailto:lucor.service@gmail.com">lucor.service@gmail.com</a></p>
          </div>
          <div class="right-info">
            <ul class="info-block">
              <li><a href="tel:+77012422111" class="btn btn-link btn-lg" target="_top" data-attr="phone"><i class="cameron-icon-support"></i> +7 (701) 242 2111</a></li>
              <li><a href="whatsapp://send?phone=+77012422111" class="btn btn-link btn-lg" target="_top" data-attr="phone"><i class="fa fa-whatsapp"></i> +7 (701) 242 2111</a></li>
            </ul>
          </div>
        </div>
      </div>
      <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
        <div class="container clearfix">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="logo-box clearfix">
            <a class="navbar-brand" href="/">
              <img src="/assets/img/logo/logo-2-200.png" class="main-logo" alt="Lucor Service">
              <img src="/assets/img/logo/logo-2-200.png" class="stricky-logo" alt="Lucor Service">
            </a>
            <button class="menu-toggler" data-target=".header-style-two .main-navigation">
              <span class="fa fa-bars"></span>
            </button>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="main-navigation">
            <ul class="navigation-box">
              <li class="current">
                <a href="#">Каталог</a>
                <ul class="sub-menu">
                  <?php $traverse = function ($categories) use (&$traverse) { ?>
                    <?php foreach ($categories as $category) : ?>
                      <li>
                        <?php if (count($category->descendants()->get()) > 0) : ?>
                          <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                        <?php else : ?>
                          <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                        <?php endif; ?>

                        <?php if ($category->children && count($category->children) > 0) : ?>
                          <ul class="sub-menu">
                            <?php $traverse($category->children); ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                </ul>
              </li>
              @yield('menu')
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- CONTENT -->
    @yield('content')

    <!-- Modal -->
    <div class="modal fade" id="appModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Форма заявки</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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
                  <button type="submit" class="btn-custom btn-block mb-2"><i class="fa fa-send"></i> Оставить заявку</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- CONTACT BUTTONS -->
    <div class="fixed-button">
      <a onclick="fbq('track', 'Contact');" href="whatsapp://send?phone=+77012422111" target="_top" data-attr="whatsapp_call">
        <img src="/img/whatsapp-logo.png">
      </a>
    </div>
    <div class="fixed-button2">
      <a onclick="fbq('track', 'Contact');" href="tel:+77012422111" target="_top" data-attr="phone">
        <img src="/img/phone-receiver.png">
      </a>
    </div>

    <!-- MODAL MESSAGE -->
    <div class="modal fade" id="message-status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center text-uppercase">Статус заявки</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p class="alert {{ session('status') }}">{{ session('message') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- MAP -->
    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa37cb4e35b200b60c50eb4461de043f50c92521e04f75bd0e100942887b3f0a4&amp;width=100%25&amp;height=380&amp;lang=ru_UA&amp;scroll=false"></script>

    <footer class="site-footer" id="contacts">
      <div class="main-footer">
        <div class="container">
          <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
              <div class="footer-widget about-widget">
                <a href="index.html" class="footer-logo">
                  <img src="/assets/img/logo/logo-2-200.png" alt="awesome image">
                </a>
                <p>Причин, по которым вам стоит обратиться на наш сайт, множество. Мы реализуем только качественную, сертифицированную продукцию от проверенных годами производителей. Высокое качество товаров уже оценили многие наши клиенты, и вы также можете убедиться в этом лично.</p>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="footer-widget links-widget">
                <div class="footer-widget-title">
                  <h3>Каталог</h3>
                </div>
                <ul class="links-lists">
                  <?php $traverse = function ($categories) use (&$traverse) { ?>
                    <?php foreach ($categories as $category) : ?>
                      <li>
                        <?php if (count($category->descendants()->get()) > 0) : ?>
                          <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                        <?php else : ?>
                          <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                        <?php endif; ?>

                        <?php if ($category->children && count($category->children) > 0) : ?>
                          <ul class="sub-menu">
                            <?php $traverse($category->children); ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="footer-widget links-widget">
                <div class="footer-widget-title">
                  <h3>Соц. сети</h3>
                </div>
                <ul class="links-lists">
                  <li><a href="#"><i class="fa fa-facebook-f"></i> Facebook</a></li>
                  <li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
                  <li><a href="#"><i class="fa fa-vimeo"></i> Vimeo</a></li>
                  <li><a href="#"><i class="fa fa-linkedin"></i> Linkedin</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="footer-widget links-widget">
                <div class="footer-widget-title">
                  <h3>Контакты</h3>
                </div>
                <ul class="links-lists">

                  <li><a href="tel:+77012422111"><i class="cameron-icon-support"></i> +77012422111</a></li>
                  <li><a href="whatsapp://send?phone=+77012422111"><i class="fa fa-whatsapp"></i> +77012422111</a></li>
                  <li><a href="mailto:lucor.service@gmail.com"><i class="cameron-icon-email"></i> lucor.service@gmail.com</a></li>
                  <li><i class="cameron-icon-placeholder"></i> г. Алматы, Толе би 189А, уг. Розабакиева</li>
                </ul>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-footer text-center">
        <div class="container">
          <p><a href="#">Lucor Service</a> &copy; <?php echo date("Y"); ?> Все права защищены</p>
        </div>
      </div>
    </footer>
  </div>

  <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
  
  <script src="/assets/js/jquery.js"></script>
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/owl.carousel.min.js"></script>
  <script src="/assets/js/waypoints.min.js"></script>
  <script src="/assets/js/jquery.counterup.min.js"></script>
  <!-- <script src="/assets/js/wow.js"></script> -->
  <script src="/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="/assets/js/theme.js"></script>
  <script>
    $(document).ready(function() {
      $('.more-link').magnificPopup({type:'image'});
    });

    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });
  </script>

  <!-- Message Status -->
  @if (session('status'))
    <script type="text/javascript">
      $('#message-status').modal('show');
    </script>
  @endif
</body>

</html>