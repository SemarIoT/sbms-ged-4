@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 mt-4 mb-0">
        @php
        $energy_system = App\Models\Energy::latest()->first();
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
            <h2 class="h5 mb-0">Monitor <span class="dot-offline mb-0"></span> </h2>
            <p class="text-sm lh-1 mb-0">Terakhir Online {{$energy_created_at}}</p>
        </div>
        @else
        <div class="container-fluid">
            <h2 class="h5 mb-0">Monitor <span class="dot-online mb-0"></span> </h2>
            <p class="text-sm lh-1 mb-0">Online</p>
        </div>
        @endif
        @endif
    </div>
    <div class="container-fluid px-0 py-0 mt-3">
        {{-- Section Each Energy --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5>Today's Energy</h5>
                        <div class="row d-flex justify-content-between">
                            @php
                            $i=0
                            @endphp
                            @foreach ($eachTodayEnergy as $value)
                            <div class="col-md text-center">
                                <p class="text-lg fw-light mb-0 text-success">{{ $value }} <sup
                                        class="text-danger text-md">Wh</sup></p>
                                <p>{{ $devicesPanel[$i]->nama }}</p>
                            </div>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Energy Usage and Cost --}}
        <!-- <section class="mt-0 pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Total Energy Usage (kWh)</h3>
                                <div class="row align-items-center mb-0">
                                    <div class="col-sm-6">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format ($energy_month, 2,',','.')
                                            @endphp
                                        </p>
                                        <p>This Month</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format ($energyLastMonth, 2,',','.')
                                            @endphp
                                        </p>
                                        <p>Last Month</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">This Month Cost</h3>
                                <div class="row align-items-end">
                                    <div class="col-lg-12">
                                        <p class="text-xl fw-light mb-0 text-info">
                                            @php
                                            echo number_format($energy_cost*$energy_month, 0,',','.');
                                            @endphp
                                        </p>
                                        <p>IDR</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Previous Month Cost</h3>
                                <div class="row align-items-end">
                                    <div class="col-lg-12">
                                        <p class="text-xl fw-light mb-0 text-info">
                                            @php
                                            echo number_format($energy_cost*$energyLastMonth);
                                            @endphp
                                        </p>
                                        <p>IDR</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        {{-- Overal Monitoring (Master) --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4 mt-0">Arus</h5>
                        <div class="row d-flex justify-content-between">
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($devicesPanel as $energy_panel)
                            <div class="col-md d-flex justify-content-around">
                                <p class="text-md text-start">{{$energy_panel->nama}} :</p>
                                <p class="text-md mb-0 text-danger text-end">{{
                                    $energiesCollection[$i]->arus
                                    }} <span class="text-success mb-0">A</span></p>
                            </div>
                            @endforeach
                        </div>
                        <div id="arusChart" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4 mt-0">Daya Aktif</h5>
                        <div class="row d-flex justify-content-between">
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($devicesPanel as $energy_panel)
                            <div class="col-md d-flex justify-content-around">
                                <p class="text-md text-start">{{$energy_panel->nama}} :</p>
                                <p class="text-md mb-0 text-danger text-end">{{
                                    $energiesCollection[$i]->active_power
                                    }} <span class="text-success mb-0">kW</span></p>
                            </div>
                            @endforeach
                        </div>
                        <div id="activeChart" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </section>


        {{-- Detail Monitoring --}}
        <section class="mt-0 pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Voltage (V)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->tegangan }} V</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Current (Amp)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-success">{{ $energiesCollection[$i]->arus}} A
                                        </p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Frequency (Hz)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-danger">{{
                                            $energiesCollection[$i]->frekuensi }} Hz</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Active Power (kW)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-blue">{{
                                            $energiesCollection[$i]->active_power }} kW</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Reactive Power (kVAR)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-gold">{{
                                            $energiesCollection[$i]->reactive_power}} kVAR</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Power Factor</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-4">{{
                                            $energiesCollection[$i]->power_factor}}</p>
                                        <p>{{$energy_panel->nama}}</p>
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

<script type="text/javascript" src="{{asset('js/linechartcanvas.js')}}"></script>
<script type="text/javascript" src="{{asset('js/linechartcanvasjquery.js')}}"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
    window.onload = function () {
        var a1 = [];
        var a2 = [];
        var a3 = [];
        var a4 = [];

        var p1 = [];
        var p2 = [];
        var p3 = [];
        var p4 = [];

        var arusChart = new CanvasJS.StockChart("arusChart", {
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
                    type: "line",
                    name: "Lantai 1",
                    yValueFormatString: "#0.## A",
                    dataPoints: a1
                }, {
                    type: "line",
                    name: "Lantai 2",
                    yValueFormatString: "#0.## A",
                    dataPoints: a2
                }, {
                    type: "line",
                    name: "Lantai 3",
                    yValueFormatString: "#0.## A",
                    dataPoints: a3
                }, {
                    type: "line",
                    name: "Master",
                    yValueFormatString: "#0.## A",
                    dataPoints: a4
                }]
            }],
            navigator: {
                slider: {}
            }
        });
        $.getJSON("api/arus-stat/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                a1.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            arusChart.render();
            console.log(a1);
        });
        $.getJSON("api/arus-stat/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                a2.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                a3.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                a4.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            arusChart.render();
        });
        var activeChart = new CanvasJS.StockChart("activeChart", {
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
                    type: "line",
                    name: "Lantai 1",
                    yValueFormatString: "#0.## kW",
                    dataPoints: a1
                }, {
                    type: "line",
                    name: "Lantai 2",
                    yValueFormatString: "#0.## kW",
                    dataPoints: a2
                }, {
                    type: "line",
                    name: "Lantai 3",
                    yValueFormatString: "#0.## kW",
                    dataPoints: a3
                }, {
                    type: "line",
                    name: "Master",
                    yValueFormatString: "#0.## kW",
                    dataPoints: a4
                }]
            }],
            navigator: {
                slider: {}
            }
        });
        $.getJSON("api/active-stat/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                a1.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            activeChart.render();
            console.log(a1);
        });
        $.getJSON("api/active-stat/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                a2.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                a3.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                a4.push({ x: new Date(data[i].created_at), y: Number(data[i].arus) });
            }
            activeChart.render();
        });
    }
</script>

@stop