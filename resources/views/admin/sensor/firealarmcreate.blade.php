@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Tambah Fire Alarm</h2>
      </div>
    </div>
  <div class="container-fluid">

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{url('daftar-sensor')}}">
                                <button class="btn btn-info" >
                                    Kembali
                                </button>
                            </a>
                          </div>
                      <div class="card-body pt-0">
                        <form class="form-horizontal" id="formNewUser" name="formNewUser" method="POST" action="{{ route('storeFireAlarmList') }}">
                            {{ csrf_field() }}
                            
                            <div class="form-group mb-3">
                                <label for="name" class="col-dm-6 control-label">Nama</label>
                                <div class="col-center">
                                    <input type="text" id="nama" name="nama" class="form-control">
                                </div>
                                <input type="hidden" id="status" name="status" value="0" class="form-control">
                            </div>
                                                        
                           <div class="form-group mb-3">
                                <div class="col text-right ">
                                    <button type="submit" class="btn btn-success" name="action">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                </div>
           
            
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







  