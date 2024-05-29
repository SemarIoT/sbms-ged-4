<!DOCTYPE html>
<html>
@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
        <style>
            /* The switch - the box around the slider */
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }
    
            /* Hide default HTML checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
    
            /* The slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }
    
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }
    
            input:checked+.slider {
                background-color: #28a745;
            }
    
            input:focus+.slider {
                box-shadow: 0 0 1px #28a745;
            }
    
            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }
    
            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }
    
            .slider.round:before {
                border-radius: 50%;
            }
    
        </style>

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Control</h2>
      </div>
    </div>
  <div class="container-fluid">

                <section class="pt-3 mt-3">
                    <div class="container-fluid">
                        <div class="row d-flex align-items-stretch gy-4">
                            <div class="col-lg">
                                <!-- Sales bar chart-->
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="h4 mb-3 text-white">Sensor Suhu dan Kelembaban</h3>
                                        <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                            <div class="me-2">
                                                <h3 class="text-sm d-block text-white text-uppercase">DHT Sensor</h3>
                                            </div>
                                        @foreach ($posts as $item)
                                        @if($item->status==1)
                                        <label class="switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                            <a href="{{ url('change-status/'.$item->id) }}" class="slider round" ></a>
                                        </label>
                                        @else
                                        <label class="switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                            <a href="{{ url('change-status/'.$item->id) }}" class="slider round" ></a>
                                        </label>
                                        @endif
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
           



            <!-- Hidden section for chart canvas -->
            <section hidden>
              
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

    <script>
        function ubahstatus(value){
            if(value==true) value="";
            else value= "";
            document.getElementById('status').innerHTML = value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    document.getElementById('status').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "esp/kontroldht.php?stat=" + value, true );
            xmlhttp.send();
        }
    </script>
@else
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Kontrol</h2>
      </div>
    </div>
  <div class="container-fluid">

<section class="pt-3 mt-3">
    <div class="container-fluid">
        <div class="row d-flex align-items-stretch gy-4">
            <div class="col-lg">
                <!-- Sales bar chart-->
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pt-3">
                            <h3 class="h4 mb-3 text-white">Akses Menuju Laman Ditolak</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif



@stop
</html>
