<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Smart Building Management System</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <!-- Choices.js-->
  <link rel="stylesheet" href="{{asset('vendor/choices.js/public/assets/styles/choices.min.css')}}">
  <!-- Google fonts - Muli-->
  <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Muli:300,400,700')}}">
  <!-- Css untuk semuanya-->
  <link rel="stylesheet" href="{{asset('css/style.light.css')}}" id="theme-stylesheet">
  <!-- CSS untuk Switch Button-->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <!-- Favicon-->
  <link rel="icon" href="{{asset('img/icon.ico')}}">
  <!-- DataTable Styles -->
  <link rel="stylesheet" href="{{asset('table/dist/style.css')}}">
</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-lg py-2 my-0 bg-topbar">
      <div class="container-fluid d-flex align-items-center justify-content-between py-1">
        <div class="navbar-header d-flex align-items-center"><a class="navbar-brand text-uppercase text-gold"
            href="{{url('dashboard')}}">
            <div class="brand-text brand-big"><small class="text-color5 text-md fw-bold">S</small><small
                class="text-gold text-md fw-bold">BMS</small></div>
            <div class="brand-text brand-sm"><strong class="text-color5">S</strong><strong>BMS</strong></div>
          </a>
          <button class="sidebar-toggle text-white">
            <svg class="svg-icon svg-icon-sm svg-icon-heavy transform-none">
              <use xlink:href="#arrow-left-1"> </use>
            </svg>
          </button>
        </div>

        @php
        $name_about = App\Models\About::oldest()->get();
        @endphp
        @foreach ($name_about as $name_abouts)
        <div class="mx-auto my-0 pt-2">
          <h6 class="text-light">{{$name_abouts->nama}}</h6>
        </div>
        @endforeach

        <ul class="list-inline mb-0">
          <li class="list-inline-item logout px-lg-2">
            <a class="nav-link text-md text-light fw-bold px-1 px-lg-0" id="logout" href="{{url('logout')}}">
              <span class="d-none d-sm-inline-block">Logout </span>
              <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                <use xlink:href="#disable-1"> </use>
              </svg></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
      <!-- Sidebar Header-->
      <div class="sidebar-header d-flex align-items-center p-2">
        <a href="{{url('profile')}}">
          <div class="ms-3 title">
            <h6 class="mb-1 text-white">{{ Auth::user()->name }}</h6>
            <p class="text-sm text-white-50 mb-0 lh-1">{{ Auth::user()->level }}</p>
        </a>
      </div>
  </div>

  <hr class="sidebar-divider my-0">
  <ul class="list-unstyled">
    <li class="sidebar-item"><a class="sidebar-link" href="{{url('dashboard')}}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#real-estate-1"> </use>
        </svg><span>Dashboard </span></a></li>
    <li class="sidebar-item"><a class="sidebar-link" href="{{url('monitor')}}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#browser-window-1"> </use>
        </svg><span>Monitor </span></a></li>
    @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
    <li class="sidebar-item"><a class="sidebar-link" href="{{url('control')}}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#security-shield-1"> </use>
        </svg><span>Control </span></a></li>
    @endif
    <li class="sidebar-item"><a class="sidebar-link" href="{{url('statistic')}}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#stack-1"> </use>
        </svg><span>Statistic</span></a></li>
    <li class="sidebar-item"><a class="sidebar-link" href="{{url('exports')}}">
        <svg class="svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#browser-window-1"> </use>
        </svg><span>Export Data </span></a></li>
    <hr class="sidebar-divider my-0">
    </nav>

    @yield('content')

    </div>


    <!-- JavaScript files-->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/just-validate/js/just-validate.min.js')}}"></script>
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('vendor/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    <script src="{{asset('js/charts-home.js')}}"></script>
    <!-- Main File-->
    <script src="{{asset('js/front.js')}}"></script>
    <script>
      // ------------------------------------------------------- //
      //   Inject SVG Sprite - 
      //   see more here 
      //   https://css-tricks.com/ajaxing-svg-sprite/
      // ------------------------------------------------------ //
      function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
          var div = document.createElement("div");
          div.className = 'd-none';
          div.innerHTML = ajax.responseText;
          document.body.insertBefore(div, document.body.childNodes[0]);
        }
      }
      // this is set to BootstrapTemple website as you cannot 
      // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
      // while using file:// protocol
      // pls don't forget to change to your domain :)
      injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');


    </script>
    <script>
      document.querySelector('#colour').addEventListener('change', function () {
        const theme = this.value;
        document.querySelector('#theme-stylesheet').setAttribute('href', '/css/style.' + theme + '.css');
      });
    </script>

    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>