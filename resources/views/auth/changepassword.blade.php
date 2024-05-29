@extends('layout.topbar')
@section('content')

 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Ubah Password</h2>
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
                      <div class="card-body pt-0">
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-6 control-label">Current
                                    Password</label>

                                <div class="col-center">
                                    <input id="current-password" type="password" class="form-control"
                                        name="current-password" required>

                                    @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-6 control-label">New Password</label>

                                <div class="col-center">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                        required>

                                    @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="new-password-confirm" class="col-md-6 control-label">Confirm New
                                    Password</label>

                                <div class="col-center">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                        name="new-password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>                            
                        </form>
                        </div>
                    </div>
                </div>
           
            
        </div>
    </div>

@stop







  