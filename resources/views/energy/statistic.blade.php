@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Statistic</h2>
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
                                    <div id="stockChartContainer" style="height: 400px; width: 100%;"></div>
                                    <div class="mt-3">
                                      <a class="btn btn-success " href="energyexportxlxs">Export xlxs</a>
                                      <a class="btn btn-info " href="energyexportcsv">Export csv</a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pt-3 mt-3">
                <div class="container-fluid">
                    <div class="row d-flex align-items-stretch gy-4">
                        <div class="col-lg">
                            <!-- Sales bar chart-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center pt-3">
                                        <h3 class="h4 mb-3 ">Usage Data</h3>
                                    </div>
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th class="text-center" width="80px">No</th>
                                            <th class="text-center" width="160px">Bulan</th>
                                            <th class="text-center" width="160px">Tahun</th>
                                            <th class="text-center" >Energi (KWH)</th>
                                            <th class="text-center" width="40px"></th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                        @foreach ($price as $prices)
                                        <tr>
                                            <td class="text-center">{{++$i}}</td>
                                            <td class="text-center">{{$prices->month}}</td>
                                            <td class="text-center">{{$prices->tahun}}</td>
                                            <td class="text-center">@php echo number_format((float)$prices->result,2,'.',''); @endphp</td>
                                            <td class="text-end">Rp.</td>
                                            <td class="text-end">@php echo number_format($prices->harga); @endphp</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
     <!-- Script chart form highchart--> 
{{-- <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.stock.min.js"></script> --}}
<script type="text/javascript" src="{{asset('js/linechartcanvas.js')}}"></script>
<script type="text/javascript" src="{{asset('js/linechartcanvasjquery.js')}}"></script>

<script type="text/javascript">
window.onload = function () {
  var dataPoints = [];
  var dataPoints2 = [];
  var dataPoints3 = [];
  var dataPoints4 = [];
  
  var stockChart = new CanvasJS.StockChart("stockChartContainer",{
    theme: "dark2", 
    exportEnabled: true,
    title:{
      text:"Statistic"
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
          valueFormatString: "#,##0.##"
        }
      },
      toolTip: {
        shared: true
      },
      data: [{
        type: "area",
        name: "Energi AC1",
        yValueFormatString: "#,##0.## KWH",
        dataPoints : dataPoints
      }, {
        type: "area",
        name: "Energi AC2",
        yValueFormatString: "#,##0.## KWH",
        dataPoints : dataPoints2
      }, {
        type: "area",
        name: "Energi Outlet",
        yValueFormatString: "#,##0.## KWH",
        dataPoints : dataPoints3
      }, {
        type: "area",
        name: "Energi Lampu",
        yValueFormatString: "#,##0.## KWH",
        dataPoints : dataPoints4
      }]
    }],
    navigator: {
      slider: {}
    }
  });
  
  $.getJSON("api/dailyEnergy/1", function(data) {
    for(var i = 0; i < data.length; i++){
      dataPoints.push({x: new Date(data[i].date), y: Number(data[i].energy)});
    }
    stockChart.render();
  });
  
  $.getJSON("api/dailyEnergy/2", function(data) {
    for(var i = 0; i < data.length; i++){
      dataPoints2.push({x: new Date(data[i].date), y: Number(data[i].energy)});
    }
    stockChart.render();
  });

  $.getJSON("api/dailyEnergy/3", function(data) {
    for(var i = 0; i < data.length; i++){
      dataPoints3.push({x: new Date(data[i].date), y: Number(data[i].energy)});
    }
    stockChart.render();
  });

  $.getJSON("api/dailyEnergy/4", function(data) {
    for(var i = 0; i < data.length; i++){
      dataPoints4.push({x: new Date(data[i].date), y: Number(data[i].energy)});
    }
    stockChart.render();
  });
  
  // Repeat similar code for dataPoints3 and dataPoints4
}

</script>


</body>
@stop
</html>
