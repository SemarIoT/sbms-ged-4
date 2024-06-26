@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-3">
      <div class="container-fluid">
        <h2 class="h5 mb-0">API Panel</h2>
      </div>
    </div>
  <div class="container-fluid">
            <section class="pt-0 mt-3">
                <div class="container-fluid">
                    <div class="row d-flex align-items-stretch gy-4">
                        <div class="col-lg">
                            <div class="card">
                                <div class="card-body">
                                    @foreach($panelshow as $panelshows)
                                    @foreach($about as $abouts)
                                        <h3 >API untuk '{{$panelshows->nama}}'</h3>
                                        <div class="row d-flex justify-content-center pt-0">
                                            <div class="col-lg-12">
                                                <p class="text-xl fw-light mb-0 text-center text-info">{{$abouts->link}}api/energyControl</p><span>
                                                <p class="text text-start fw-light mb-0 ">Cara Penggunaan:</p><span>
                                                <p class="text text-start mb-0 ">Method -> GET</p><span>
                                                <p class="text text-start mb-0 ">Content-type -> application/JSON</p><span>
                                                <p class="text text-start mb-0 ">Key  -> "{{ $panelshows->nama  }}"</p><span>
                                            </div>        
                                        </div>
                                    @endforeach                                           
                                    @endforeach
                                    <a href="{{url('daftar-sensor')}}">
                                        <button class="btn btn-info" >
                                            Kembali
                                        </button>
                                    </a>
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
                            <div class="row d-flex align-items-stretch gy-4">
                                <div class="col-lg">
                                    <!-- Sales bar chart-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                                <h3 class="h4 mb-3 text-white">Akses Menuju Laman Ditolak</h3>
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







  