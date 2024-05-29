@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Edit Data</h2>
      </div>
    </div>
  <div class="container-fluid">

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <a href="{{url('doorlock_list')}}">
                            <button class="btn btn-info" >
                                Kembali
                            </button>
                        </a>
                      </div>
                      <div class="card-body pt-0">
                        @foreach($editdoorlockAccess as $eu)
                        <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ route('update_doorlockAccess') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$eu->id}}">
                            <div class="form-group mb-3">
                                <label for="nama-edit" class="col-dm-6 control-label">Name</label>
                                <div class="col-center">
                                    <input type="text" id="nama-edit" name="nama-edit"  value="{{$eu->nama}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                              <label for="token-edit" class="col-dm-6 control-label">Token</label>
                              <div class="col-center">
                                  <input type="text" id="token-edit" name="token-edit" value="{{$eu->token}}" class="form-control">
                              </div>
                          </div>
                          <div class="form-group mb-3">
                            <label for="level" class="col-dm-6 control-label">Level</label>
                            <div class="col-center">
                                <select id="level-edit" name="level-edit" class="btn btn-outline-secondary dropdown-toggle" value="{{$eu->level}}" type="button" data-bs-toggle="dropdown" aria-expanded="false" form="formEditUser">Level
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary" name="action">
                                        Update 
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endforeach
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
            <h2 class="h5 mb-0">Akses DItolak</h2>
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







  