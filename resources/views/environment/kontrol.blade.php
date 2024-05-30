<div class="container-fluid">




    {{-- Device Status --}}
    <section class="pt-0 mt-0">
        <div class="container-fluid">
            <div class="row d-flex align-items-stretch gy-4">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <h4 class="h4 mb-3">Status</h4>
                                <div class="row align-items-end">
                                    @foreach($devicesPanel as $energy_panel)
                                    <div class="col-sm-6">
                                        <p class="text-xl mb-0 text-info">{{$energy_panel->nama}}</p>
                                    </div>
                                    @if($energy_panel->status==1)
                                    <div class="col-sm-6">
                                        <p class="text-xl mb-0 text-end text-success">ON</p>
                                    </div>
                                    @else
                                    <div class="col-sm-6">
                                        <p class="text-xl mb-0 text-end text-dash-color-3">OFF</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    
</div>