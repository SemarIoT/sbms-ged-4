@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
    
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Control</h2>
      </div>
    </div>
    <div class="container-fluid">
        {{-- Section Master Panel --}}
        <section class="mt-3">
            <div class="container-fluid">
                <div class="row gy-4">
                    {{-- <div class="col-md-6 col-sm-6">  pilih ini atau bawah --}}
                    <div class="col-md-12 col-sm-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-end justify-content-between mb-2">
                                    @foreach ($energy_panel_master as $energy_panel_masters)
                                        
                                    <div class="me-2">
                                        <p class="text-lg text-uppercase text-success lh-1 mb-0">Panel Master</p>
                                    </div>
                                    <!-- <p class="text-xxl lh-1 mb-0 text-success">25 kWh</p> -->
                                    @if($energy_panel_masters->status==1)
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                        <a href="{{ url('control-change-status-panel-master/'.$energy_panel_masters->id) }}" class="slider round" ></a>
                                    </label>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                        <a href="{{ url('control-change-status-panel-master/'.$energy_panel_masters->id) }}" class="slider round" ></a>
                                    </label>
                                    @endif                                        
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Node --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-12">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3 text-">Panel Node</h3>
                                @foreach ($energy_panel as $energy_panels)
                                <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                    <div class="me-2">
                                        <h3 class="text-sm d-block text-dash-color-2 text-uppercase">{{$energy_panels->nama}}</h3>
                                    </div>
                                    @if($energy_panels->status==1)
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                        <a href="{{ url('control-change-status-panel/'.$energy_panels->id) }}" class="slider round" ></a>
                                    </label>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                        <a href="{{ url('control-change-status-panel/'.$energy_panels->id) }}" class="slider round" ></a>
                                    </label>
                                    @endif 
                                </div>
                                @endforeach
                                @foreach ($lights as $light)
                                <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                    <div class="me-2">
                                        <h3 class="text-sm d-block text-dash-color-2 text-uppercase">{{$light->nama}}</h3>
                                    </div>
                                    @if($light->status==1)
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                        <a href="{{ url('change-light-status/'.$light->id) }}" class="slider round" ></a>
                                    </label>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                        <a href="{{ url('change-light-status/'.$light->id) }}" class="slider round" ></a>
                                    </label>
                                    @endif 
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
    
@else
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
        <div class="container-fluid">
        <h2 class="h5 mb-0">Akses Ditolak</h2>
        </div>
    </div>
    <div class="container-fluid">
        <section class="pt-3 mt-3">
                    <div class="container-fluid">
                        <div class="row d-flex align-items-stretch">
                            <div class="col-lg">
                                <!-- Sales bar chart-->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                            <h3 class="h4 mb-3 text-">Akses Menuju Laman Ditolak</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
    </div>
</div>
@endif
    
   
@stop

