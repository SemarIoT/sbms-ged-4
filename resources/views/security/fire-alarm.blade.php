@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Fire Alarm</h2>
      </div>
    </div>
  <div class="container-fluid">

    @foreach ($posts as $item)
            <section class="pt-3 mt-3">
                <div class="container-fluid">
                    <div class="row d-flex align-items-stretch gy-4">
                        <div class="col-lg">
                            <!-- Sales bar chart-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pt-3">
                                        <h3 class="h4 mb-3 text">Status {{$item->nama}}</h3>
                                    </div>
                                    
                                        <div class="row align-items-end">
                                            <div class="col-lg-12">
                                                @if($item->status==1) 
                                                <p class="text-xl fw-light mb-0 text-danger">DANGER</p><span>
                                                <p class="text-xl fw-light mb-0 text-dash-color-3">Perlu Tindakan!!!</p><span>
                                                <br>
                                                @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
                                                <p class="text-small fw-light mb-0 text-warning">Klik Switch jika masalah sudah teratasi</p><span>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                                    <a href="{{ url('change-fire-alarm-status/'.$item->id)}}" class="slider round" ></a>
                                                </label>
                                                @endif
                                                @else
                                                <p class="text-xl fw-light mb-0 text-success">OK</p><span>
                                                @endif
                                            
                                            </div> 
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            @endforeach
            <!-- Hidden section for chart canvas -->
            <section hidden>
                <div class="container-fluid">
                    <canvas id="salesBarChart1"></canvas>
                    <canvas id="salesBarChart2"></canvas>
                    <canvas id="pieChartHome1"></canvas>
                    <canvas id="pieChartHome2"></canvas>
                    <canvas id="pieChartHome3"></canvas>
                    <canvas id="barChartExample1"></canvas>
                    <canvas id="barChartExample2"></canvas>
                    <canvas id="lineChart"></canvas>
                    <canvas id="lineChart1"></canvas>
                </div>
            </section>
        </div>
    </div>
    
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
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>
@stop
</html>
