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
                        <div class="card-body d-flex justify-content-center">                            
                            <div id="containment-wrapper" class="d-flex justify-content-center"> 
                                
                                @foreach ($light as $cont)
                                <div id={{$cont->nama}} class="draggable ui-widget-content" style="cursor: move;">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/light.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach
                                @foreach ($lightdimmer as $lightdimmers)
                                <div id={{$lightdimmers->nama}} class="draggable ui-widget-content" style="cursor: move;">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/dimmer.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach
                                @foreach ($energypanelmaster as $energypanelmasters)
                                <div id={{$energypanelmasters->nama}} class="draggable ui-widget-content" style="cursor: move;">
                                    <a  href="{{url('monitor')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/panel.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach
                                @foreach ($firealarm as $firealarms)
                                <div id={{$firealarms->nama}} class="draggable ui-widget-content" style="cursor: move;">
                                    <a  href="{{url('fire-alarm')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/fire.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach
                                @foreach ($camera as $cameras)
                                <div id={{$cameras->nama}} class="draggable ui-widget-content" style="cursor: move;">
                                    <a  href="{{url('camera')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/cctv.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach
                            </div> 
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
            var sPositions = localStorage.positions || "{}",
            positions = JSON.parse(sPositions);
</script>
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
@foreach ($light as $cont)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$cont->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                //revert: true,
                stop: function (event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                }
            })
            ;
</script>
@endforeach
@foreach ($lightdimmer as $lightdimmers)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$lightdimmers->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                //revert: true,
                stop: function (event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                }
            })
            ;
</script>
@endforeach
@foreach ($energypanelmaster as $energypanelmasters)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$energypanelmasters->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                //revert: true,
                stop: function (event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                }
            })
            ;
</script>
@endforeach
@foreach ($firealarm as $firealarms)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$firealarms->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                //revert: true,
                stop: function (event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                }
            })
            ;
</script>
@endforeach
@foreach ($camera as $cameras)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$cameras->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                //revert: true,
                stop: function (event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                }
            })
            ;
</script>
@endforeach



@else
@foreach ($light as $cont)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$cont->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                revert: true,
                
            })
            ;
</script>
@endforeach
@foreach ($lightdimmer as $lightdimmers)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$lightdimmers->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                revert: true,
                
            })
            ;
</script>
@endforeach
@foreach ($energypanelmaster as $energypanelmasters)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$energypanelmasters->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                revert: true,
                
            })
            ;
</script>
@endforeach
@foreach ($firealarm as $firealarms)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$firealarms->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                revert: true,
                
            })
            ;
</script>
@endforeach
@foreach ($camera as $cameras)
<script>
            $.each(positions, function (id, pos) {
                $("#" + id).css(pos)
            })
            $("#{{$cameras->nama}}").draggable({
                containment: "#containment-wrapper",
                scroll: false,
                revert: true,
                
            })
            ;
</script>
@endforeach
@endif 



@stop
</html>
