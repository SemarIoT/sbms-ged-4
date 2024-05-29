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
                                                                background-size: 100% 100%;"> 
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
                                <div id="boxs" class="ui-widget-content draggable">
                                    <img class="img-fluid" src="{{asset('img/icon/target.png')}}">
                                    <span class="d-flex justify-content-center text-primary">Reference</span>
                                </div>
                            </div> 
                        </div>
                        <div class="d-flex justify-content-center">Reference Coordinate (<span id="results"></span>)</div>
                        
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-success" href="createpinpoint">Tambah</a>
                            </div>
                            @foreach ($light as $lights)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$lights->nama}}</h5>
                                <input type="hidden" name="id" value="{{$lights->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$lights->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$lights->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        
                                        <a href="deletepinpoint/{{$lights->id}}" class="btn btn-danger">Delete</a>
                                    
                                    </div>
                                </div>
                            </form>
                            @endforeach 
                            @foreach ($lightdimmer as $lightdimmers)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$lightdimmers->nama}}</h5>
                                <input type="hidden" name="id" value="{{$lightdimmers->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$lightdimmers->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$lightdimmers->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        <a href="deletepinpoint/{{$lightdimmers->id}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                            @foreach ($energypanelmaster as $energypanelmasters)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$energypanelmasters->nama}}</h5>
                                <input type="hidden" name="id" value="{{$energypanelmasters->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$energypanelmasters->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$energypanelmasters->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        <a href="deletepinpoint/{{$energypanelmasters->id}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </form>
                            @endforeach  
                            @foreach ($firealarm as $firealarms)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$firealarms->nama}}</h5>
                                <input type="hidden" name="id" value="{{$firealarms->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$firealarms->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$firealarms->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        <a href="deletepinpoint/{{$firealarms->id}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                            @foreach ($camera as $cameras)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$cameras->nama}}</h5>
                                <input type="hidden" name="id" value="{{$cameras->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$cameras->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$cameras->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        <a href="deletepinpoint/{{$cameras->id}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                            @foreach ($dht as $dhts)
                            <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ url('editpinpoint') }}">
                                {{ csrf_field() }} 
                                <h5 class="h5 mb-0">{{$dhts->nama}}</h5>
                                <input type="hidden" name="id" value="{{$dhts->id}}">
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">X Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="x-edit" name="x-edit"  value="{{$dhts->xpos}}" placeholder="200px"   class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="name-edit" class="col-dm-6 control-label">Y Coordinate</label>
                                            <div class="col-center">
                                                <input type="text" id="y-edit" name="y-edit"  value="{{$dhts->ypos}}" placeholder="200px" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-primary" name="action" onclick="myFunction()">
                                            Update 
                                        </button>
                                        <a href="deletepinpoint/{{$dhts->id}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </form>
                            @endforeach
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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




@stop
</html>
