<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Smart Building Management System</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Choices.js-->
    <link rel="stylesheet" href="{{asset('vendor/choices.js/public/assets/styles/choices.min.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Muli:300,400,700')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.light.css')}}" id="theme-stylesheet">
    <!-- Untuk Switch Button-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    <link rel="icon" href="{{asset('img/icon.ico')}}">
    <!-- DataTable Styles -->
    <link rel="stylesheet" href="{{asset('table/dist/style.css')}}">

</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg py-2 bg-blue">
            <div class="container-fluid d-flex justify-content-between py-1">
                <div class="navbar-header d-flex align-items-center">
                    <a class="navbar-brand text-uppercase text-light">
                        <div class="brand-text brand-big"><strong class="text-dark fw-bold"
                                style="font-size:15px; ">Smart</strong>
                            <span class="fw-bolder" style="font-size:15px;"> Building Management System</span>
                        </div>
                        <div class="brand-text brand-sm"><strong class="text-light">S</strong><strong>BMS</strong></div>
                    </a>
                </div>
                {{-- <div class="mx-auto"><strong class="text-dark">Smart Room - Internet of Things Laboratory</strong>
                </div> --}}

                <ul class="list-inline mb-0">
                    </li>
                    <li class="list-inline-item login px-lg-2">
                        <a class="nav-link text-sm text-light px-1 px-lg-0" id="login" href="{{url('login')}}">
                            <span class="d-none d-sm-inline-block">Login </span>
                            <svg class="svg-icon svg-icon-xs svg-icon-heavy">
                                <use xlink:href="#disable-1"> </use>
                            </svg></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="d-flex align-items-stretch">
        <div class="page-content">
            <div class="pt-3">
                <div class="container-fluid">
                    <p>Dashboard</p>
                </div>
            </div>
            <div class="container-fluid">
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
                                                <div class="text-lg fw-light mb-0 text-info">{{ $panel->nama }}</div>
                                            </div>
                                            @if($panel->status==1)
                                            <div class="col-md">
                                                <div class="text-lg fw-light mb-0 text-end text-success">Online</div>
                                            </div>
                                            @else
                                            <div class="col-md">
                                                <div class="text-lg fw-light mb-0 text-end text-dash-color-3">Offline
                                                </div>
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
                                            <div class="col-lg-6">
                                                <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                    $energies[$i]->v_A }}</p>
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
                                                <div class="col-lg-6">
                                                    <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                        $energies[$i]->i_A }}</p>
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
                                                <div class="col-lg-6">
                                                    <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                        $energies[$i]->frekuensi}}</p>
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
                                                <div class="col-lg-6">
                                                    <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                        $energies[$i]->p_A }}</p>
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
                                                <div class="col-lg-6">
                                                    <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                        $energies[$i]->reactive_power }}</p>
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
                                                <div class="col-lg-6">
                                                    <p class="text-md fw-light mb-0 text-dash-color-1">{{
                                                        ($energies[$i]->pf_A) / 10 }}</p>
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
    </div>

</body>

<!-- JavaScript files-->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/just-validate/js/just-validate.min.js')}}"></script>
<!-- Main File-->
<script src="{{asset('js/front.js')}}"></script>

<script type="text/javascript">
    function autoRefreshPage() {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 120000);
</script>
</body>

</html>