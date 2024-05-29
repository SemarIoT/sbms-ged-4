@extends('layout.topbar')
@section('content')

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
        <div class="container-fluid">
            <h5 class="mb-0">About</h5>
        </div>
    </div>
    <div class="container-fluid">
        @foreach ($integrated_system as $integrated_systems)
        <section class="pt-3 mt-3">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-2 d-flex justify-content-center"><a
                                        href="{{$integrated_systems->link}}">{{$integrated_systems->nama}}</a></h4>
                                <div class="row d-flex justify-content-center pt-0">
                                    <p class="text text-break text-start fw-light mb-2 ">
                                        {{$integrated_systems->deskripsi}}</p><span>
                                </div>
                                @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
                                <a class="btn btn-primary btn-sm" href="aboutedit/{{$integrated_systems->id}}">Edit</a>
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