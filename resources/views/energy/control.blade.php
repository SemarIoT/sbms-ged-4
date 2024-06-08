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
        {{-- Section Node --}}
        <section class="pt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg-12">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3 text-">Panel Node</h3>
                                @foreach ($energy_panel as $item)
                                <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                    <div class="me-2">
                                        <h3 class="text-sm d-block text-dash-color-2 text-uppercase">{{$item->nama}}
                                        </h3>
                                    </div>
                                    @if($item->status==1)
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                                        <a href="{{ url('control-change-status-panel/'.$item->id) }}"
                                            class="slider round"></a>
                                    </label>
                                    @else
                                    <label class="switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                                        <a href="{{ url('control-change-status-panel/'.$item->id) }}"
                                            class="slider round"></a>
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