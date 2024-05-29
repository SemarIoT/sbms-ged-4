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
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @foreach ($light as $cont)
                                <div id="draggable" class="ui-widget-content draggable">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/light.png')}}" alt="...">
                                    </a>
                                </div>
                                @endforeach

                                @foreach ($lightdimmer as $lightdimmers)
                                <div id="draggable" class="ui-widget-content draggable">
                                    <a  href="{{url('light')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/dimmer.png')}}" alt="...">
                                    {{$lightdimmers->nama}}</a>
                                </div>
                                @endforeach
                                @foreach ($energypanelmaster as $energypanelmasters)
                                <div id="draggable" class="ui-widget-content draggable">
                                    <a  href="{{url('monitor')}}"> 
                                    <img class="img-fluid" src="{{asset('img/icon/panel.png')}}" alt="...">
                                    {{$energypanelmasters->nama}}</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var positions = JSON.parse(localStorage.positions || "{}");
        $(function() {
            var d = $("[id=draggable]").attr("id", function(i) {
                return "draggable_" + i
            })


            $.each(positions, function(id, pos) {
                $("#" + id).css(pos)
            })

            d.draggable({
                containment: "#containment-wrapper",
                scroll: false,
                stop: function(event, ui) {
                    positions[this.id] = ui.position
                    localStorage.positions = JSON.stringify(positions)
                    var pos_xy = ui.position
                    }
            });
            
        });
                
    });
</script>
<script>
// $.ajax({
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type: 'POST',
//         url: {{url('api/Pinpointposisi')}},
//         data: {
//             posisi: pos_xy,
            
//         },
//         success: function(data) {
//             console.log(data);
//         }
// });

$(document).ready(function(){
  $("#save").click(function(){
    $.ajax({        
        type: 'POST',
        url: {{url('api/Pinpointposisi')}},
        data: {
            posisi: pos_xy,            
        },
        success: function(data) {
            console.log(data);
        }
});

  });
});
</script>




@stop
</html>
