@extends('layout.topbar')
@section('content')
<div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-1 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Camera</h2>
      </div>
    </div>
<div class="container-fluid">
    <section class="pt-3 mt-3">
        <div class="container-fluid">
            <div class="row d-flex align-items-stretch gy-4">
                <div class="col-lg">
                    <!-- Sales bar chart-->
                    <div class="card">
                        <div class="card-body justify-content-center">
                            <h3 class="h4 mb-3 ">CCTV Utama</h3>
                            <div class="row d-flex justify-content-center pt-3">
                                    <a href="http://admin:LabIoT123@203.6.149.118:89/ISAPI/Streaming/channels/102/httpPreview">
                                        <img src="img/stock/stock_cam.jpeg" alt="cam" width="100%" height="400px">
                                    </a>
                                <div class="mt-3">
                                    <a class="btn btn-success " href="http://admin:LabIoT123@203.6.149.118:89/ISAPI/Streaming/channels/102/httpPreview">Open CCTV</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        @foreach ($camera as $cameras)
        <section class="pt-0 mt-0">
            <div class="container-fluid">
                <div class="row d-flex align-items-stretch gy-4">
                    <div class="col-lg">
                        <!-- Sales bar chart-->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="h4 mb-3 ">{{$cameras->nama}}</h3>
                                <div class="row d-flex justify-content-center pt-3">
                                    <div class="col-lg"></div>
                                    <div class="col-lg">
                                            <iframe width="640" height="360" src="{{$cameras->link}}" frameborder="0" ></iframe>
                                    </div>
                                    <div class="col-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
</div>
</body>
@stop
</html>
