<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Choices.js-->
    <link rel="stylesheet" href="{{asset('vendor/choices.js/public/assets/styles/choices.min.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Muli:300,400,700')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
    
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    {{-- <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">  --}}
    <!-- DataTable Styles -->
    <link rel="stylesheet" href="{{asset('table/dist/style.css')}}">
                      
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Data Logger</h2>
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
                                    
                                  </div>
                                    <div id="stockChartContainer" style="height: 500px; width: 100%;"></div>
                                    
                                    <div class="mt-3">
                                      <a class="btn btn-success " href="export_plc_sipil">Download Data as xlxs</a>
                                      <a class="btn btn-info " id="refreshButton" href="">Refresh Data</a>
                                      <a class="btn btn-danger justify-content-end" href="truncateDataSipil" onclick="return confirm('Data yang sudah dihapuskan tidak bisa dikembalikan lagi. Pastikan Anda sudah mendownload data yang anda perlukan. Apakah anda yakin akan menghapus data?')">Delete All Data</a>
                                      {{-- <a class="btn btn-info " href="energyexportcsv">Export csv</a>  --}}
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
        </div>
    </div>

    <script type="text/javascript">
      document.getElementById("refreshButton").addEventListener("click", function(){
          location.reload();
      });
      </script>
    
    
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
<script type="text/javascript" src="{{asset('js/linechartcanvas.js')}}"></script>
<script type="text/javascript" src="{{asset('js/linechartcanvasjquery.js')}}"></script>

<script type="text/javascript">

window.onload = function () {
  var dataPoints = [];
  var dataPoints2 = [];
  var dataPoints3 = [];
  var dataPoints4 = [];
  var stockChart = new CanvasJS.StockChart("stockChartContainer",{
    theme: "dark2", //"light1", "dark1", "dark2" "light2",
    exportEnabled: true,
    title:{
      text:"Data Logger"
    },
    charts: [{
      axisX: {
        crosshair: {
          enabled: true,
          snapToDataPoint: true
          
        }
      },
      axisY: {
        prefix: "",
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "##,###.##"
        }
      },
      toolTip: {
        shared: true
      },
      data: [{
        type: "line",
        name: "Distance",
        yValueFormatString: "##,###.#mm",
        dataPoints : dataPoints
      },{
        type: "line",
        name: "Force",
        yValueFormatString: "##,###.#KN",
        dataPoints : dataPoints2
      },{
        type: "line",
        name: "Gaya Tarik",
        yValueFormatString: "##,###.#",
        dataPoints : dataPoints3
      },{
        type: "line",
        name: "Gaya Tekan",
        yValueFormatString: "##,###.#",
        dataPoints : dataPoints4
      }]
    }],
    navigator: {
      slider: {
      
      }
    }
  });
  
       $.getJSON("api/plc_sipil_statistik", function(data) {
         for(var i = 0; i < data.length; i++){
           dataPoints.push({x: new Date(data[i].date), y: Number(data[i].distance)});
           dataPoints2.push({x: new Date(data[i].date), y: Number(data[i].forces)});
           dataPoints3.push({x: new Date(data[i].date), y: Number(data[i].gayatarik)});
           dataPoints4.push({x: new Date(data[i].date), y: Number(data[i].gayatekan)});
         }
         stockChart.render();
       });
      }

     </script>


    </body>
</html>
