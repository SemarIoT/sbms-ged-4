@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
        @php
        $energy_system = App\Models\DhtSensor::latest()->first();
        if($energy_system){
            $energy_created_at = Carbon\Carbon::parse($energy_system->created_at);
            $now = Carbon\Carbon::now();
        }else{
            $energy_created_at = null;
            $now = null;
        }
    @endphp
    
    @if($energy_created_at && $now)
        @if ($now->diffInHours($energy_created_at) > 3)
            <div class="container-fluid">
                <h2 class="h5 mb-0">Light Intensity <span class="dot-offline mb-0"></span> </h2>
                <p class="text-sm lh-1 mb-0">Terakhir Online {{$energy_created_at}}</p>
            </div>
        @else
            <div class="container-fluid">
                <h2 class="h5 mb-0">Light Intensity <span class="dot-online mb-0"></span> </h2>
                <p class="text-sm lh-1 mb-0">Online</p>
            </div>
        @endif
    @endif
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
                                        <h3 class="h4 mb-3 text">Light Intensity</h3>
                                        <div class="row align-items-end">
                                            <div class="col-lg-5">
                                                <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $data->lux }}</p><span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="pt-0 mt-0">
                <div class="container-fluid">
                    <div class="row d-flex align-items-stretch gy-4">
                        <div class="col-lg">
                            <!-- Sales bar chart-->
                            <div class="card">
                                <div class="card-body">
                                  
                                    <div id="stockChartContainer" style="height: 400px; width: 100%;"></div>
                                    <div class="mt-3">
                                        <a class="btn btn-success " href="dhtsensorexporthumidxlxs">Export xlxs</a>
                                        <a class="btn btn-info " href="dhtsensorexporthumidcsv">Export csv</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <script type="text/javascript" src="{{asset('js/linechartcanvas.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/linechartcanvasjquery.js')}}"></script>
        <script type="text/javascript">
        window.onload = function () {
          var dataPoints = [];
          var stockChart = new CanvasJS.StockChart("stockChartContainer",{
            theme: "dark2", //"light1", "dark1", "dark2" "light2",
            exportEnabled: true,
            title:{
              text:"Light Intensity"
            },
            charts: [{
              axisX: {
                crosshair: {
                  enabled: true,
                  //snapToDataPoint: true
                  valueFormatString: "MMM DD, YYYY HH:mm:ss"
                }
              },
              axisY: {
                prefix: "",
                crosshair: {
                  enabled: true,
                  snapToDataPoint: true,
                  valueFormatString: "##"
                }
              },
              toolTip: {
                shared: true
              },
              data: [{
                type: "area",
                name: "Kelembaban",
                yValueFormatString: "## ",
                xValueFormatString: "MMM DD, YYYY HH:mm:ss",
                xValueType: "dateTime",
                dataPoints : dataPoints
              }]
            }],
            navigator: {
              slider: {
              
              }
            }
          });
               $.getJSON("api/luxlogger", function(data) {
                 for(var i = 0; i < data.length; i++){
                   dataPoints.push({x: new Date(data[i].date), y: Number(data[i].sale)});
                 }
                 stockChart.render();
               });
             }
             </script>
            <script type="text/javascript">
                function autoRefreshPage()
                {
                    window.location = window.location.href;
                }
                setInterval('autoRefreshPage()', 300000);
            </script>
@stop