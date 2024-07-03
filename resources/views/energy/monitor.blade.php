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

        {{-- Chart --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4 mt-0">Arus Fasa</h5>
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
                                <h3 class="h4 mb-3">Tegangan Fasa R</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->v_A }} V</p>
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
                                <h3 class="h4 mb-3">Tegangan Fasa S</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->v_B }} V</p>
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
                                <h3 class="h4 mb-3">Tegangan Fasa T</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->v_C }} V</p>
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
                                <h3 class="h4 mb-3">Arus Fasa R</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-success">{{ $energiesCollection[$i]->i_A}} A
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
                                <h3 class="h4 mb-3">Arus Fasa S</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-success">{{ $energiesCollection[$i]->i_B}} A
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
                                <h3 class="h4 mb-3">Arus Fasa T</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-success">{{ $energiesCollection[$i]->i_C}} A
                                        </p>
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
                                <h3 class="h4 mb-3">Daya Aktif Fasa R</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-blue">{{
                                            $energiesCollection[$i]->p_A }} W</p>
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
                                <h3 class="h4 mb-3">Daya Aktif Fasa S</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-blue">{{
                                            $energiesCollection[$i]->p_B }} W</p>
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
                                <h3 class="h4 mb-3">Daya Aktif Fasa T</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-blue">{{
                                            $energiesCollection[$i]->p_C }} W</p>
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
                                <h3 class="h4 mb-3">Faktor Daya Fasa R</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-4">{{
                                            ($energiesCollection[$i]->pf_A / 10)}}</p>
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
                                <h3 class="h4 mb-3">Faktor Daya Fasa S</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-4">{{
                                            ($energiesCollection[$i]->pf_B)/10}}</p>
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
                                <h3 class="h4 mb-3">Faktor Daya Fasa T</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-4">{{
                                            ($energiesCollection[$i]->pf_C)/10}}</p>
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
                <div class="row d-flex justify-content-center align-items-stretch gy-4">
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
                                <h3 class="h4 mb-3">Frekuensi</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-info">{{
                                            $energiesCollection[$i]->frekuensi}} Hz</p>
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
        var a1s = [];
        var a2s = [];
        var a3s = [];
        var a4s = [];
        var a1t = [];
        var a2t = [];
        var a3t = [];
        var a4t = [];

        var p1 = [];
        var p2 = [];
        var p3 = [];
        var p4 = [];
        var p1s = [];
        var p2s = [];
        var p3s = [];
        var p4s = [];
        var p1t = [];
        var p2t = [];
        var p3t = [];
        var p4t = [];

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
                data: [
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa R",
                        yValueFormatString: "#0.## A",
                        dataPoints: a1
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa R",
                        yValueFormatString: "#0.## A",
                        dataPoints: a2
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa R",
                        yValueFormatString: "#0.## A",
                        dataPoints: a3
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa R",
                        yValueFormatString: "#0.## A",
                        dataPoints: a4
                    },
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa S",
                        yValueFormatString: "#0.## A",
                        dataPoints: a1s
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa S",
                        yValueFormatString: "#0.## A",
                        dataPoints: a2s
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa S",
                        yValueFormatString: "#0.## A",
                        dataPoints: a3s
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa S",
                        yValueFormatString: "#0.## A",
                        dataPoints: a4s
                    },
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa T",
                        yValueFormatString: "#0.## A",
                        dataPoints: a1t
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa T",
                        yValueFormatString: "#0.## A",
                        dataPoints: a2t
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa T",
                        yValueFormatString: "#0.## A",
                        dataPoints: a3t
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa T",
                        yValueFormatString: "#0.## A",
                        dataPoints: a4t
                    },
                ]
            }],
            navigator: {
                slider: {}
            }
        });
        $.getJSON("api/arus-stat-r/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                a1.push({ x: new Date(data[i].created_at), y: Number(data[i].i_A) });
            }
            arusChart.render();
            console.log(a1);
        });
        $.getJSON("api/arus-stat-r/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                a2.push({ x: new Date(data[i].created_at), y: Number(data[i].i_A) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-r/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                a3.push({ x: new Date(data[i].created_at), y: Number(data[i].i_A) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-r/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                a4.push({ x: new Date(data[i].created_at), y: Number(data[i].i_A) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-s/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                a1s.push({ x: new Date(data[i].created_at), y: Number(data[i].i_B) });
            }
            arusChart.render();
            console.log(a1);
        });
        $.getJSON("api/arus-stat-s/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                a2s.push({ x: new Date(data[i].created_at), y: Number(data[i].i_B) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-s/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                a3s.push({ x: new Date(data[i].created_at), y: Number(data[i].i_B) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-s/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                a4s.push({ x: new Date(data[i].created_at), y: Number(data[i].i_B) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-t/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                a1t.push({ x: new Date(data[i].created_at), y: Number(data[i].i_C) });
            }
            arusChart.render();
            console.log(a1);
        });
        $.getJSON("api/arus-stat-t/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                a2t.push({ x: new Date(data[i].created_at), y: Number(data[i].i_C) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-t/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                a3t.push({ x: new Date(data[i].created_at), y: Number(data[i].i_C) });
            }
            arusChart.render();
        });
        $.getJSON("api/arus-stat-t/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                a4t.push({ x: new Date(data[i].created_at), y: Number(data[i].i_C) });
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
                data: [
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa R",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p1
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa R",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p2
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa R",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p3
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa R",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p4
                    },
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa S",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p1s
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa S",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p2s
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa S",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p3s
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa S",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p4s
                    },
                    {
                        type: "line",
                        name: "AC Lt.1 Fasa T",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p1t
                    }, {
                        type: "line",
                        name: "Utilitas Lt.1 Fasa T",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p2t
                    }, {
                        type: "line",
                        name: "AC Lt.2 Fasa T",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p3t
                    }, {
                        type: "line",
                        name: "Utilitas Lt.2 Fasa T",
                        yValueFormatString: "#0.## kW",
                        dataPoints: p4t
                    },
                ]
            }],
            navigator: {
                slider: {}
            }
        });
        $.getJSON("api/active-stat-r/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                p1.push({ x: new Date(data[i].created_at), y: Number(data[i].p_A) });
            }
            activeChart.render();
            console.log(a1);
        });
        $.getJSON("api/active-stat-r/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                p2.push({ x: new Date(data[i].created_at), y: Number(data[i].p_A) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-r/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                p3.push({ x: new Date(data[i].created_at), y: Number(data[i].p_A) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-r/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                p4.push({ x: new Date(data[i].created_at), y: Number(data[i].p_A) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-s/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                p1s.push({ x: new Date(data[i].created_at), y: Number(data[i].p_B) });
            }
            activeChart.render();
            console.log(a1);
        });
        $.getJSON("api/active-stat-s/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                p2s.push({ x: new Date(data[i].created_at), y: Number(data[i].p_B) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-s/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                p3s.push({ x: new Date(data[i].created_at), y: Number(data[i].p_B) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-s/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                p4s.push({ x: new Date(data[i].created_at), y: Number(data[i].p_B) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-t/1", function (data) {
            for (var i = 0; i < data.length; i++) {
                p1t.push({ x: new Date(data[i].created_at), y: Number(data[i].p_C) });
            }
            activeChart.render();
            console.log(a1);
        });
        $.getJSON("api/active-stat-t/2", function (data) {
            for (var i = 0; i < data.length; i++) {
                p2t.push({ x: new Date(data[i].created_at), y: Number(data[i].p_C) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-t/3", function (data) {
            for (var i = 0; i < data.length; i++) {
                p3t.push({ x: new Date(data[i].created_at), y: Number(data[i].p_C) });
            }
            activeChart.render();
        });
        $.getJSON("api/active-stat-t/4", function (data) {
            for (var i = 0; i < data.length; i++) {
                p4t.push({ x: new Date(data[i].created_at), y: Number(data[i].p_C) });
            }
            activeChart.render();
        });
    }
</script>

@stop