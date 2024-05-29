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
                <h2 class="h5 mb-0">Temperature <span class="dot-offline mb-0"></span> </h2>
                <p class="text-sm lh-1 mb-0">Terakhir Online {{$energy_created_at}}</p>
            </div>
        @else
            <div class="container-fluid">
                <h2 class="h5 mb-0">Temperature <span class="dot-online mb-0"></span> </h2>
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
                                        <h3 class="h4 mb-3 ">Temperature</h3>
                                        @forelse ($temperature as $item)
                                        <div class="row align-items-end">
                                            <div class="col-lg-5">
                                                <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $item->temperature }}</p><span>
                                            </div>
                                        </div>
                                        @empty                                            
                                        @endforelse
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
                                    <a class="btn btn-success " href="dhtsensorexportxlxs">Export xlxs</a>
                                    <a class="btn btn-info " href="dhtsensorexportcsv">Export csv</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @foreach ($dhtx1 as $dhtx1s)
            @if ($dhtx1s->status == 1)
            <section class="pt-0 mt-0">
              <div class="container-fluid">
                  <div class="row d-flex align-items-stretch gy-4">
                      <div class="col-lg">
                          <!-- Sales bar chart-->
                          <div class="card">
                              <div class="card-body">
                                  <div class="row d-flex justify-content-center pt-3">
                                      <h3 class="h4 mb-3 ">Temperature {{$dhtx1s->nama}}</h3>
                                      @forelse ($tempx1 as $tempx1s)
                                      <div class="row align-items-end">
                                          <div class="col-lg-5">
                                              <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $tempx1s->temperature }}</p><span>
                                          </div>
                                      </div>
                                      @empty                                            
                                      @endforelse
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          @endif
          @endforeach

          @foreach ($dhtx2 as $dhtx2s)
            @if ($dhtx2s->status == 1)
            <section class="pt-0 mt-0">
              <div class="container-fluid">
                  <div class="row d-flex align-items-stretch gy-4">
                      <div class="col-lg">
                          <!-- Sales bar chart-->
                          <div class="card">
                              <div class="card-body">
                                  <div class="row d-flex justify-content-center pt-3">
                                      <h3 class="h4 mb-3 ">Temperature {{$dhtx2s->nama}}</h3>
                                      @forelse ($tempx2 as $tempx2s)
                                      <div class="row align-items-end">
                                          <div class="col-lg-5">
                                              <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $tempx2s->temperature }}</p><span>
                                          </div>
                                      </div>
                                      @empty                                            
                                      @endforelse
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          @endif
          @endforeach

          @foreach ($dhtx3 as $dhtx3s)
            @if ($dhtx3s->status == 1)
            <section class="pt-0 mt-0">
              <div class="container-fluid">
                  <div class="row d-flex align-items-stretch gy-4">
                      <div class="col-lg">
                          <!-- Sales bar chart-->
                          <div class="card">
                              <div class="card-body">
                                  <div class="row d-flex justify-content-center pt-3">
                                      <h3 class="h4 mb-3 ">Temperature {{$dhtx3s->nama}}</h3>
                                      @forelse ($tempx3 as $tempx3s)
                                      <div class="row align-items-end">
                                          <div class="col-lg-5">
                                              <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $tempx3s->temperature }}</p><span>
                                          </div>
                                      </div>
                                      @empty                                            
                                      @endforelse
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          @endif
          @endforeach

          @foreach ($dhtx4 as $dhtx4s)
            @if ($dhtx4s->status == 1)
            <section class="pt-0 mt-0">
              <div class="container-fluid">
                  <div class="row d-flex align-items-stretch gy-4">
                      <div class="col-lg">
                          <!-- Sales bar chart-->
                          <div class="card">
                              <div class="card-body">
                                  <div class="row d-flex justify-content-center pt-3">
                                      <h3 class="h4 mb-3 ">Temperature {{$dhtx4s->nama}}</h3>
                                      @forelse ($tempx4 as $tempx4s)
                                      <div class="row align-items-end">
                                          <div class="col-lg-5">
                                              <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $tempx4s->temperature }}</p><span>
                                          </div>
                                      </div>
                                      @empty                                            
                                      @endforelse
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          @endif
          @endforeach

          @foreach ($dhtx5 as $dhtx5s)
            @if ($dhtx5s->status == 1)
            <section class="pt-0 mt-0">
              <div class="container-fluid">
                  <div class="row d-flex align-items-stretch gy-4">
                      <div class="col-lg">
                          <!-- Sales bar chart-->
                          <div class="card">
                              <div class="card-body">
                                  <div class="row d-flex justify-content-center pt-3">
                                      <h3 class="h4 mb-3 ">Temperature {{$dhtx5s->nama}}</h3>
                                      @forelse ($tempx5 as $tempx5s)
                                      <div class="row align-items-end">
                                          <div class="col-lg-5">
                                              <p class="text-xl fw-light mb-0 text-dash-color-3">{{ $tempx5s->temperature }}</p><span>
                                          </div>
                                      </div>
                                      @empty                                            
                                      @endforelse
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          @endif
          @endforeach




        </div>
    </div>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
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
              text:"Temperature"
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
                  valueFormatString: "#,###.##"
                }
              },
              toolTip: {
                shared: true
              },
              data: [{
                type: "area",
                name: "Suhu",
                yValueFormatString: "##.##C",
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

            
            
               $.getJSON("api/suhulogger", function(data) {
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