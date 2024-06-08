@extends('layout.topbar')
@section('content')
<div class="page-content">
  <!-- Page Header-->
  <div class="bg-dash-dark-1 mt-4">
    <div class="container-fluid">
      <h2 class="h5 mb-0">Statistic</h2>
    </div>
  </div>
  <div class="container-fluid">
    <section>
      <div class="container-fluid">
        <div class="row d-flex align-items-stretch">
          <div class="card">
            <div class="card-body">
              <div class="row pb-2">
                <h4 class="text-center">Grafik Konsumsi Energi Harian</h4>
              </div>
              <div id="stockChartContainer" style="height: 400px; width: 100%;"></div>
              <div class="mt-3">
                <a class="btn btn-success " href="energyexportxlxs">Export xlxs</a>
                <!-- <a class="btn btn-info " href="energyexportcsv">Export csv</a> -->
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row pb-2">
                <h4 class="text-center">Grafik Konsumsi Energi Bulanan</h4>
              </div>
              <div id="monthlyChartContainer" style="height: 400px; width: 100%;"></div>
              <div class="mt-3">
                <a class="btn btn-success " href="energyexportxlxs">Export xlxs</a>
                <!-- <a class="btn btn-info " href="energyexportcsv">Export csv</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="pt-2 mt-0">
      <div class="container-fluid">
        <div class="row d-flex align-items-stretch">
          <div class="col-lg">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <h3 class="h4 mb-3 ">Usage Data</h3>
                </div>
                <table class="table table-striped table-hover">
                  <tr>
                    <th class="text-center" width="160px">Bulan</th>
                    <th class="text-center" width="160px">Tahun</th>
                    <th class="text-center">Energi (KWH)</th>
                    <th class="text-center" width="40px"></th>
                    <th class="text-center">Total</th>
                  </tr>
                  @foreach ($monthlyKwh as $item)
                  <tr>
                    <td class="text-center">{{$item->month}}</td>
                    <td class="text-center">{{$item->tahun}}</td>
                    <td class="text-center">@php echo number_format((float)$item->monthly_kwh,2,'.',''); @endphp</td>
                    <td class="text-end">Rp.</td>
                    <td class="text-end">@php echo number_format($item->bill); @endphp</td>
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

<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.stock.min.js"></script>
<script type="text/javascript" src="{{asset('js/linechartcanvas.js')}}"></script>
<script type="text/javascript" src="{{asset('js/linechartcanvasjquery.js')}}"></script>

<script type="text/javascript">
  window.onload = function () {
    var dataPoints = [];
    var dataPoints2 = [];
    var dataPoints3 = [];
    var dataPoints4 = [];
    var monthlyData = [];

    var stockChart = new CanvasJS.StockChart("stockChartContainer", {
      theme: "light2",
      exportEnabled: true,
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
            valueFormatString: "#0.##"
          }
        },
        toolTip: {
          shared: true
        },
        data: [{
          type: "area",
          name: "Lantai 1",
          yValueFormatString: "#0.## kWh",
          dataPoints: dataPoints
        }, {
          type: "area",
          name: "Lantai 2",
          yValueFormatString: "#0.## kWh",
          dataPoints: dataPoints2
        }, {
          type: "area",
          name: "Lantai 3",
          yValueFormatString: "#0.## kWh",
          dataPoints: dataPoints3
        }, {
          type: "area",
          name: "Master",
          yValueFormatString: "#0.## kWh",
          dataPoints: dataPoints4
        }]
      }],
      navigator: {
        slider: {}
      }
    });

    $.getJSON("api/daily-stat/1", function (data) {
      for (var i = 0; i < data.length; i++) {
        dataPoints.push({ x: new Date(data[i].date), y: Number(data[i].energy) });
      }
      stockChart.render();
    });

    $.getJSON("api/daily-stat/2", function (data) {
      for (var i = 0; i < data.length; i++) {
        dataPoints2.push({ x: new Date(data[i].date), y: Number(data[i].energy) });
      }
      stockChart.render();
    });

    $.getJSON("api/daily-stat/3", function (data) {
      for (var i = 0; i < data.length; i++) {
        dataPoints3.push({ x: new Date(data[i].date), y: Number(data[i].energy) });
      }
      stockChart.render();
    });

    $.getJSON("api/daily-stat/4", function (data) {
      for (var i = 0; i < data.length; i++) {
        dataPoints4.push({ x: new Date(data[i].date), y: Number(data[i].energy) });
      }
      stockChart.render();
    });

    var monthlyChart = new CanvasJS.Chart("monthlyChartContainer", {
      theme: "light2",
      exportFileName: "monthly-energy",
      exportEnabled: true,
      axisX: {
        valueFormatString: "MMM YYYY",
        interval: 1, // Format for the x-axis labels
        intervalType: "month"
      },
      axisY: {
        title: "Total Energi (kWh)",
        prefix: "",
        valueFormatString: "#0.##"
      },
      data: [
        {
          type: "column",
          dataPoints: monthlyData,
          yValueFormatString: "#0.## KWH",
        }
      ]
    });

    $.getJSON("api/monthly-energy/4", function (data) {
      for (var i = 0; i < data.length; i++) {
        var formattedDate = new Date(data[i].tahun, data[i].month - 1, 1).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short'
        });
        monthlyData.push({
          x: new Date(data[i].tahun, data[i].month - 1, 1),
          y: Number(data[i].monthly_kwh),
          label: formattedDate,
          indexLabel: data[i].ike,
          indexLabelFontColor: data[i].color,
          indexLabelFontSize: 14,
          indexLabelFontWeight: "bolder",
          indexLabelMaxWidth: 50,
          color: data[i].color
        });
      }
      monthlyChart.render();
    });


  }

</script>


</body>
@stop

</html>