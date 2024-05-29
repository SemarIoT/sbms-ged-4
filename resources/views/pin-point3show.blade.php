@extends('layout.topbar')
@section('content')

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Pin Point</h2>
      </div>
    </div>
  <div class="container-fluid">

    <section class="pt-3 mt-3">
        <div class="container-fluid">
            <div class="row d-flex align-items-stretch gy-4">
                <div class="col-lg">
                    <!-- Sales bar chart-->
                    <div class="card">
                        <div class="card-body justify-content-center">
                            @foreach ($map as $maps)                            
                            <div id="containment-wrapper" style="width: 800px;
                                                                height: 800px;
                                                                position: relative;
                                                                background-image:url('{{asset('/data_file/'.$maps->map)}}');
                                                                background-repeat: no-repeat;     
                                                                background-size: 100% 100%;
                                                                "> 
                            @endforeach
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @foreach ($light as $lights)
                                <div id="draggable" class="ui-widget-content draggable" style="position: absolute; left: {{$lights->xpos}}; top: {{$lights->ypos}};">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/light.png')}}" alt="...">
                                    <span class="d-flex justify-content-center">{{$lights->nama}}</span></a>
                                </div>
                                @endforeach

                                @foreach ($lightdimmer as $lightdimmers)
                                <div id="draggable" class="ui-widget-content draggable" style="position: absolute; left: {{$lightdimmers->xpos}}; top: {{$lightdimmers->ypos}};">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/dimmer.png')}}" alt="...">
                                    {{$lightdimmers->nama}}</a>
                                </div>
                                @endforeach
                                @foreach ($energypanelmaster as $energypanelmasters)
                                <div id="draggable" class=" ui-widget-content draggable" style="position: absolute; left: {{$energypanelmasters->xpos}}; top: {{$energypanelmasters->ypos}};">
                                    <a href="{{url('monitor')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/panel.png')}}" alt="...">
                                    <span class="d-flex justify-content-center">{{$energypanelmasters->nama}}</span></a>
                                </div>
                                @endforeach
                                @foreach ($firealarm as $firealarms)
                                <div id="draggable" class=" ui-widget-content draggable" style="position: absolute; left: {{$firealarms->xpos}}; top: {{$firealarms->ypos}};">
                                    <a href="{{url('fire-alarm')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/fire.png')}}" alt="...">
                                    <span class="d-flex justify-content-center">{{$firealarms->nama}}</span></a>
                                </div>
                                @endforeach
                                @foreach ($camera as $cameras)
                                <div id="draggable" class=" ui-widget-content draggable" style="position: absolute; left: {{$cameras->xpos}}; top: {{$cameras->ypos}};">
                                    <a href="{{url('camera')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/cctv.png')}}" alt="...">
                                    <span class="d-flex justify-content-center">{{$cameras->nama}}</span></a>
                                </div>
                                @endforeach
                                @foreach ($dht as $dhts)
                                <div id="draggable" class=" ui-widget-content draggable" style="position: absolute; left: {{$dhts->xpos}}; top: {{$dhts->ypos}};">
                                    <a href="{{url('temperature')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/dht.png')}}" alt="...">
                                    <span class="d-flex justify-content-center">{{$dhts->nama}}</span></a>
                                </div>
                                @endforeach 
                            </div>
                            
                        </div>
                        @if (Auth::user()->level == 'Developer')
                        <div class="d-flex justify-content-center mb-3">
                                <a class="btn btn-primary" href="pinpointset">Setting</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@if (Auth::user()->level == 'Developer')
<script type="text/javascript">
function myFunction() {
    var x = document.getElementById("btn1").value;
    var y = document.getElementById("btn2").value;
  document.getElementById("boxs").style.left = x;
  document.getElementById("boxs").style.top = y;
}      
</script>
<script type="text/javascript">
var coordinates = function(element) {
                    element = $(element);
                    var top = element.position().top;
                    var left = element.position().left;
                    $('#results').text(''+'X: ' + left + ' ' + 'Y: ' + top);
                    }

                    
                $('#boxs').draggable({
                   
                    containment: "#containment-wrapper",
                    stop: function() {
                        coordinates('#boxs');
                    }
                });
</script>
@endif

@stop
</html>
