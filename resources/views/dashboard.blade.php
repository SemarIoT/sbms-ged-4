@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="py-4">
        <div class="container-fluid">
            <h5 class="mb-0">Dashboard</h5>
        </div>
    </div>
    <div class="container-fluid px-0">
        {{-- Section Energy Usage --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Today Energy</h3>
                                <div class="row align-items-end">
                                    <p class="text-lg fw-light mb-0 text-info">
                                        @php
                                        echo number_format($energy_today,1,',','');
                                        @endphp
                                    </p>
                                    <p>kWh</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h5 mb-3">This Month</h3>
                                <div class="row align-items-end">
                                    <div class="col-lg">
                                        <p class="text-lg fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format($energy_month,1,',','');
                                            @endphp
                                        </p>
                                        <p>kWh</p>
                                    </div>
                                    <div class="col-lg">
                                        <p class="text-lg fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format($energy_cost*$energy_month,0,',','.');
                                            @endphp
                                        </p>
                                        <p>Rp </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Tariff</h3>
                                <div class="row align-items-end">
                                    <p class="text-lg fw-light mb-0 text-info">
                                        @php
                                        echo number_format($energy_cost,0,',','.');
                                        @endphp
                                        <sub>/kWh</sub>
                                    </p>
                                    <p>Rp</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Previous Month</h3>
                                <div class="row align-items-end">
                                    <div class="col-lg">
                                        <p class="text-lg fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format($energyLastMonth,1,',','');
                                            @endphp
                                        </p>
                                        <p>kWh</p>
                                    </div>
                                    <div class="col-lg">
                                        <p class="text-lg fw-light mb-0 text-dash-color-1">
                                            @php
                                            echo number_format($energy_cost*$energyLastMonth,0,',','.');
                                            @endphp
                                        </p>
                                        <p>Rp</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Device Status --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="h4 mb-3 text-center">Panel Status</h4>
                                @foreach($panels as $panel)
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md">
                                        <div class="text-lg mb-0 text-info">{{ $panel->nama }}</div>
                                    </div>
                                    @if($panel->status==1)
                                    <div class="col-md">
                                        <div class="text-lg fw-bold mb-0 text-end text-success">ON</div>
                                    </div>
                                    @else
                                    <div class="col-md">
                                        <div class="text-lg fw-bold mb-0 text-end text-dash-color-3">OFF</div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Overal Monitoring (Master) --}}
        <section class="pt-0 mt-0">
            <div class="container-fluid">
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
                                    <p class="text-lg text-dash-color-4">Power Factor</p>
                                    <p class="text-lg text-dash-color-4">{{ $avgS }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Details --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch ">
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Voltage (V)</h3>
                                <div class="row align-items-center mb-0">
                                    @php
                                    $energies = [$energy1, $energy2, $energy3, $energy4];
                                    $i=0;
                                    @endphp
                                    @foreach ($panels as $panel)
                                    <div class="col-lg-6 text-center">
                                        <p class="text-lg mb-0 text-dash-color-1">{{
                                            $energies[$i]->v_A }} V</p>
                                        <p>{{ $panel->nama }}</p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Current (Amp)</h3>
                                <div class="row align-items-end">
                                    <div class="row align-items-center mb-0">
                                        @php
                                        $energies = [$energy1, $energy2, $energy3, $energy4];
                                        $i=0;
                                        @endphp
                                        @foreach ($panels as $panel)
                                        <div class="col-lg-6 text-center">
                                            <p class="text-lg mb-0 text-dash-color-1">{{
                                                $energies[$i]->i_A }} A</p>
                                            <p>{{ $panel->nama }}</p>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Frekuensi (Hz)</h3>
                                <div class="row align-items-end">
                                    <div class="row align-items-center mb-0">
                                        @php
                                        $energies = [$energy1, $energy2, $energy3, $energy4];
                                        $i=0;
                                        @endphp
                                        @foreach ($panels as $panel)
                                        <div class="col-lg-6 text-center">
                                            <p class="text-lg mb-0 text-dash-color-1">{{
                                                $energies[$i]->frekuensi}} Hz</p>
                                            <p>{{ $panel->nama }}</p>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex align-items-stretch">
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Active Power (W)</h3>
                                <!-- <p class="text-sm fw-light">Lorem ipsum dolor sit</p> -->
                                <div class="row align-items-center mb-0">
                                    <div class="row align-items-center mb-0">
                                        @php
                                        $energies = [$energy1, $energy2, $energy3, $energy4];
                                        $i=0;
                                        @endphp
                                        @foreach ($panels as $panel)
                                        <div class="col-lg-6 text-center">
                                            <p class="text-lg mb-0 text-dash-color-1">{{
                                                $energies[$i]->p_A }} W</p>
                                            <p>{{ $panel->nama }}</p>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Reactive Power (VAR)</h3>
                                <div class="row align-items-end">
                                    <div class="row align-items-center mb-0">
                                        @php
                                        $energies = [$energy1, $energy2, $energy3, $energy4];
                                        $i=0;
                                        @endphp
                                        @foreach ($panels as $panel)
                                        <div class="col-lg-6 text-center">
                                            <p class="text-lg mb-0 text-dash-color-1">{{
                                                $energies[$i]->reactive_power }} VAR</p>
                                            <p>{{ $panel->nama }}</p>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3">Power Factor</h3>
                                <div class="row align-items-end">
                                    <div class="row align-items-center mb-0">
                                        @php
                                        $energies = [$energy1, $energy2, $energy3, $energy4];
                                        $i=0;
                                        @endphp
                                        @foreach ($panels as $panel)
                                        <div class="col-lg-6 text-center">
                                            <p class="text-lg mb-0 text-dash-color-1">{{
                                                $energies[$i]->pf_A }}</p>
                                            <p>{{ $panel->nama }}</p>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Footer --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <a href="{{url('login')}}">Login&nbsp;</a> to see more information
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
    function autoRefreshPage() {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 120000);
</script>
<!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
@stop