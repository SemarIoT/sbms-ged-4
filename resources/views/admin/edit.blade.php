@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Edit Data Admin</h2>
      </div>
    </div>
  <div class="container-fluid">

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <a href="{{url('daftar-admin')}}">
                            <button class="btn btn-info" >
                                Kembali
                            </button>
                        </a>
                      </div>
                      <div class="card-body pt-0">
                        @foreach($edituser as $eu)
                        <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ route('updateUser') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$eu->id}}">
                            <div class="form-group mb-3">
                                <label for="name-edit" class="col-dm-6 control-label">Name</label>
                                <div class="col-center">
                                    <input type="text" id="name-edit" name="name-edit"  value="{{$eu->name}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                              <label for="username" class="col-dm-6 control-label">Username</label>
                              <div class="col-center">
                                  <input type="text" id="username-edit" name="username-edit" value="{{$eu->username}}" class="form-control">
                              </div>
                          </div>
                          <div class="form-group mb-3">
                            <label for="level" class="col-dm-6 control-label">Level</label>
                            <div class="col-center">
                                <select id="level-edit" name="level-edit" class="btn btn-outline-secondary dropdown-toggle" value="{{$eu->level}}" type="button" data-bs-toggle="dropdown" aria-expanded="false" form="formEditUser">Level
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                    @if (Auth::user()->level == 'Developer')
                                    <option value="Developer">Developer</option>
                                    @endif
                                </select>
                            </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email-edit" class="col-dm-6 control-label">Email</label>
                                <div class="col-center">
                                    <input type="email" id="email-edit" name="email-edit" value="{{$eu->email}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary" name="action">
                                        Update User
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







  