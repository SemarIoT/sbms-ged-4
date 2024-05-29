@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Tambah Ruang</h2>
      </div>
    </div>
  <div class="container-fluid">

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{url('doorlock_list_room')}}">
                                <button class="btn btn-info" >
                                    Kembali
                                </button>
                            </a>
                          </div>
                      <div class="card-body pt-0">
                        <form class="form-horizontal" id="formNewUser" name="formNewUser" method="POST" action="{{ route('store_doorlockRoom') }}">
                            {{ csrf_field() }}
                            
                            <div class="form-group mb-3">
                                <label for="ruang" class="col-dm-6 control-label">Nama Ruang</label>
                                <div class="col-center">
                                    <input type="text" id="ruang" name="ruang" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="id_ruang" class="col-dm-6 control-label">ID Ruang</label>
                                <div class="col-center">
                                  <input type="number" id="id_ruang" name="id_ruang" class="form-control" value="<?php echo rand(1000, 9999); ?>">
                                </div>
                            </div>
                             
                           <div class="form-group mb-3">
                                <div class="col text-right ">
                                    <button type="submit" class="btn btn-success" name="action">
                                        Add 
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







  