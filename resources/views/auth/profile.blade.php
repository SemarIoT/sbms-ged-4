@extends('layout.topbar')
@section('content')

 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Profile</h2>
      </div>
    </div>
  <div class="container-fluid">
    

            <section class="pt-3 mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        
                      <div class="card-header">
                            <h3 class="h4 mb-3 ">{{ Auth::user()->name }}</h3>                            
                            <p class="text-sm text-gray-600 mb-0 lh-1">{{ Auth::user()->level }}</p>
                      </div>
                      <div class="card-body pt-0">
                        <a href="{{url('dashboard')}}">
                            <button class="btn btn-info" >
                                Kembali
                            </button>
                        </a>
                        @if (Auth::user()->username == 'guest')
                        @else
                        <a href="showprofile/{{Auth::user()->id}}">
                            <button class="btn btn-success" >
                                Lihat Profil
                            </button>
                        </a>
                        
                        <a href="{{url('changePassword')}}">
                            <button class="btn btn-warning" >
                                Ubah Password
                            </button>
                        </a>
                        @endif
                        </div>
                    </div>
                </div>
           
            
        </div>
    </div>

@stop







  