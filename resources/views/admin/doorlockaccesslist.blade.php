<!DOCTYPE html>
<html>
@extends('layout.topbar')
@section('content')
@if (Auth::user()->level == 'Admin' || Auth::user()->level == 'Developer')
  
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">List of Door Access </h2>
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
                          <h3>List of Permission to Door Access</h3>
                          
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
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Token</th>
                                    <th class="text-center">Level</th>
                                    <th class="text-center" width="140px">Action</th>
                                </tr>
                                @foreach ($doorlockaccessvalidate as $doorlockaccessvalidates)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $doorlockaccessvalidates->nama }}</td>
                                    <td class="text-center">{{ $doorlockaccessvalidates->token }}</td>
                                    <td class="text-center">{{ $doorlockaccessvalidates->level_akses }}</td>
                                    <td class="text-center">
                                            <a class="btn btn-success btn-sm" href="validate_doorlockAccess/{{$doorlockaccessvalidates->id}}">Setujui</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        
                            {{ $doorlockaccess->links() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                              <h3>List of Door Access</h3>
                              <div class="d-flex justify-content-end">
                                  <a class="btn btn-success" href="create_doorlockAccess">Tambah</a>
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
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Token</th>
                                        <th class="text-center">Level</th>
                                        <th class="text-center" width="140px">Action</th>
                                    </tr>
                                    @foreach ($doorlockaccess as $doorlockaccesses)
                                    <tr>
                                        <td class="text-center">{{ ++$j }}</td>
                                        <td>{{ $doorlockaccesses->nama }}</td>
                                        <td class="text-center">{{ $doorlockaccesses->token }}</td>
                                        <td class="text-center">{{ $doorlockaccesses->level_akses }}</td>
                                        <td class="text-center">
                                          
                                                <a class="btn btn-primary btn-sm" href="edit_doorlockAccess/{{$doorlockaccesses->id}}">Edit</a>
                                                <a href="delete_doorlockAccess/{{$doorlockaccesses->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">Delete</a>
                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            
                                {{ $doorlockaccess->links() }}

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
