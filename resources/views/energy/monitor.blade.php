@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
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

    <div class="container-fluid">
        {{-- Section Each Energy --}}
        <section class="mt-3">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4>Today's Energy</h4>
                        <div class="row d-flex justify-content-between">
                            @php
                            $i=0
                            @endphp
                            @foreach ($eachTodayEnergy as $value)
                            <div class="col-md text-center">
                                <p class="text-lg fw-light mb-0 text-success">{{ $value }} <sup
                                        class="text-danger text-md">Wh</sup></p>
                                <p>{{ $devicesPanel[$i] }}</p>
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
        <section class="mt-0 pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Total Energy Usage (kWh)</h3>
                                <!-- <p class="text-sm fw-light">Lorem ipsum dolor sit</p> -->
                                <div class="row align-items-center mb-0">
                                    <div class="col-sm-6">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">
                                            @php
                                            /* Rumus mencar Wh, power / (3600detik/90detik delay kirim data) lalu
                                            dijumlah jadilah Wh */
                                            // echo
                                            number_format((float)($energy_todays/(3600/$energy_cost_delays)),2,'.','');
                                            echo number_format ($energy_month, 2,',','.')
                                            @endphp
                                        </p>
                                        <p>This Month</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">
                                            @php
                                            // echo
                                            number_format((float)($energy_months/(3600/$energy_cost_delays)),2,'.','');
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
                        <!-- Sales bar chart-->
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
                        <!-- Sales bar chart-->
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
        </section>

        {{-- Device Status --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <h3 class="h4 mb-3">Status</h3>
                                    <div class="row align-items-end">
                                        @foreach($energy_panels as $energy_panel)
                                        <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-info">{{$energy_panel->nama}}</p><span>
                                        </div>
                                        @if($energy_panel->status==1)
                                        <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-end text-success">Online</p><span>
                                        </div>
                                        @else
                                        <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-end text-dash-color-3">Offline</p>
                                            <span>
                                        </div>
                                        @endif
                                        @endforeach
                                        {{-- <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-info">Lampu</p><span>
                                        </div>
                                        @if($energy_lampu->status==1)
                                        <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-end text-success">Online</p><span>
                                        </div>
                                        @else
                                        <div class="col-sm-6">
                                            <p class="text-xl fw-light mb-0 text-end text-dash-color-3">Offline</p>
                                            <span>
                                        </div>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Overal Monitoring (Master) --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <h3 class="h4 mb-3 mt-0">Overall Monitoring (Master)</h3>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-dash-color-1">Voltage</p><span>
                                                <p class="text-md text-dash-color-1">{{ $avgVolt }} V</p><span>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-success">Current</p><span>
                                                <p class="text-md text-success">{{ $avgCurrent }} A</p><span>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-danger">Frequency</p><span>
                                                <p class="text-md text-danger">{{ $avgFreq }} Hz</p><span>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-blue">Active Power</p><span>
                                                <p class="text-md text-blue">{{ $avgP }} W</p><span>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-gold">Reactive Power</p><span>
                                                <p class="text-md text-gold">{{ $avgQ }} VAR</p><span>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-md text-dash-color-4">Apparent Power</p><span>
                                                <p class="text-md text-dash-color-4">{{ $avgS }} VA</p><span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Detail Monitoring --}}
        <section class="mt-3 pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Voltage (V)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->tegangan }}</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-dash-color-1">{{
                                            $energiesCollection[$i]->tegangan }}</p>
                                        <p>{{ $light }}</p>
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
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-success">{{ $energiesCollection[$i]->arus}}
                                        </p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-success">{{ $energiesCollection[$i]->arus
                                            }}</p>
                                        <p>{{ $light }}</p>
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
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-danger">{{
                                            $energiesCollection[$i]->frekuensi }}</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-danger">{{
                                            $energiesCollection[$i]->frekuensi }}</p>
                                        <p>{{ $light }}</p>
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
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-blue">{{
                                            $energiesCollection[$i]->active_power }}</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-blue">{{
                                            $energiesCollection[$i]->active_power }}</p>
                                        <p>{{ $light }}</p>
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
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-gold">{{
                                            $energiesCollection[$i]->reactive_power}}</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-gold">{{
                                            $energiesCollection[$i]->reactive_power }}</p>
                                        <p>{{ $light }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Apparent Power (kVA)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    $array = ['energies1', 'energies2', 'energies3', 'energies4']
                                    @endphp
                                    @foreach ($energy_panels as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-dash-color-4">{{
                                            $energiesCollection[$i]->apparent_power}}</p>
                                        <p>{{$energy_panel->nama}}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @foreach ($namaLampu as $light)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl fw-light mb-0 text-dash-color-4">{{
                                            $energiesCollection[$i]->apparent_power }}</p>
                                        <p>{{ $light }}</p>
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

    <script type="text/javascript">
        function autoRefreshPage() {
            window.location = window.location.href;
        }
        setInterval('autoRefreshPage()', 120000);
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </body>
    @stop

    </html>