<!DOCTYPE html>
<html>
@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
  
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">List of Room</h2>
      </div>
    </div>
  <div class="container-fluid">
    
    <section class="pt-3 mt-3">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                              <h3>List of Room</h3>
                              <div class="d-flex justify-content-end">
                                  <a class="btn btn-success" href="create_doorlockRoom">Tambah</a>
                              </div>
                                <div class="d-flex align-items-end justify-content-between pt-2 pb-2">
                                    
                                    </div>
                            
                                @if ($message = Session::get('succes'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                            
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Ruang</th>
                                        <th class="text-center">ID Ruang</th>
                                        <th class="text-center" width="140px">Action</th>
                                    </tr>
                                    @foreach ($doorlockroom as $doorlockrooms)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $doorlockrooms->ruang }}</td>
                                        <td class="text-center">{{ $doorlockrooms->id_ruang }}</td>
                                        <td class="text-center">
                                                <a class="btn btn-primary btn-sm" href="edit_doorlockRoom/{{$doorlockrooms->id}}">Edit</a>
                                                <a href="delete_doorlockRoom/{{$doorlockrooms->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">Delete</a>
                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            
                                

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
                        <div class="row d-flex align-items-stretch">
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
</html>
