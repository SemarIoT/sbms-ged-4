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
    <div class="container-fluid px-0 py-0 mt-0">
        {{-- Section Each Energy --}}
        <section class="mt-2">
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
        <section class="mt-0 pt-0">
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
        </section>

        {{-- Overal Monitoring (Master) --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <h3 class="h4 mb-4 mt-0">Overall Monitoring (Master)</h3>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-dash-color-1">Voltage</p>
                                            <p class="text-lg text-dash-color-1">{{ $avgVolt }} V</p>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-success">Current</p>
                                            <p class="text-lg text-success">{{ $avgCurrent }} A</p>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-danger">Frequency</p>
                                            <p class="text-lg text-danger">{{ $avgFreq }} Hz</p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-blue">Active Power</p>
                                            <p class="text-lg text-blue">{{ $avgP }} W</p>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-gold">Reactive Power</p>
                                            <p class="text-lg text-gold">{{ $avgQ }} VAR</p>
                                        </div>
                                        <div class="col-sm d-flex justify-content-between px-4">
                                            <p class="text-lg text-dash-color-4">Apparent Power</p>
                                            <p class="text-lg text-dash-color-4">{{ $avgS }} VA</p>
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
                                <h3 class="h4 mb-3">Apparent Power (kVA)</h3>
                                <div class="row mb-0">
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($devicesPanel as $energy_panel)
                                    <div class="col-sm-6 text-center">
                                        <p class="text-xl mb-0 text-dash-color-4">{{
                                            $energiesCollection[$i]->apparent_power}} kVA</p>
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

@stop