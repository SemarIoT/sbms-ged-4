@extends('layout.topbar')
@section('content')

<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
        <div class="container-fluid">
            <h5 class="mb-0">Export Data</h5>
        </div>
    </div>
    <div class="container-fluid">
        <section class="mt-2 mb-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md p-0 d-flex align-items-center">
                                    <h6>Export All Total Energy (kWh) Data : </h6>
                                </div>
                                <div class="col-md p-0 text-end"><a class="btn btn-success" href="kwh-xlsx">Export
                                        Excel</a></div>
                                <!-- <div class="col-md p-0 text-end"><a class="btn btn-success" href="energies-xlsx">Export Excel</a></div> -->
                            </div>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md p-0 d-flex align-items-center">
                                    <h6>Export Energies (Voltage, Current, etc) Data : </h6>
                                </div>
                                <div class="col-md p-0 text-end"><a class="btn btn-success" href="energies-xlsx">Export
                                        Excel</a></div>
                                <!-- <div class="col-md p-0 text-end"><a class="btn btn-success" href="energies-xlsx">Export Excel</a></div> -->
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>

@stop