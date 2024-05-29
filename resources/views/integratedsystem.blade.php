@extends('layout.topbar')
@section('content')

 

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Integrated System</h2>
      </div>
    </div>
<div class="container-fluid">
 
  <section class="pt-3 mt-3">
    @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
    <div class="container-fluid">
        <div class="row d-flex align-items-stretch gy-4">
            <div class="col-lg">
                <!-- Sales bar chart-->
                <div class="card">
                    <div class="card-body">
                       
                        <a class="btn btn-success" href="daftar-integratedsystem-create">Tambah</a>
                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

  @foreach ($integrated_system as $integrated_systems)
  <section class="pt-0 mt-0">
    <div class="container-fluid">
        <div class="row d-flex align-items-stretch gy-4">
            <div class="col-lg">
                <!-- Sales bar chart-->
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-2 text-primary"><a href="{{$integrated_systems->link}}">{{$integrated_systems->nama}}</a></h2>
                        <div class="row d-flex justify-content-center pt-0">
                            
                              <p class="text text-break text-start fw-light mb-2 ">{{$integrated_systems->deskripsi}}</p><span>
                            
                        </div>
                        <a class="btn btn-info btn-sm" href="{{$integrated_systems->link}}">Go</a>
                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
                        <a class="btn btn-primary btn-sm" href="daftar-integratedsystem-edit/{{$integrated_systems->id}}">Edit</a>
                        <a href="deleteintegratedsystemList/{{$integrated_systems->id}}" class="btn btn-danger btn-sm">Delete</a>
                        @endif                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach
            
</div>
</div>

@stop







  