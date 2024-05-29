@extends('layout.topbar')
@section('content')

 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Edit Profile</h2>
      </div>
    </div>
  <div class="container-fluid">

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <a href="{{url('profile')}}">
                            <button class="btn btn-info" >
                                Kembali
                            </button>
                        </a>
                      </div>
                      @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                      <div class="card-body pt-0">
                        @foreach($edituser as $eu)
                        <form class="form-horizontal" id="formEditUser" name="formEditUser" method="POST" action="{{ route('updateprofile') }}">
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
                                <label for="email-edit" class="col-dm-6 control-label">Email</label>
                                <div class="col-center">
                                    <input type="email" id="email-edit" name="email-edit" value="{{$eu->email}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary" name="action">
                                        Update Profile
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
@stop







  