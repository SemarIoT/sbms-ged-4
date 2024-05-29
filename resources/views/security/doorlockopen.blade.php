@foreach($posts as $postses)
                      @if($postses->status==0)
                        <h1 class="display-6 fw-bold">Pintu Terkunci</h1>
                        <a class="btn btn-success" href="{{ url('change_state_doorlock/'.$postses->id) }}">Tekan Untuk Membuka Pintu</a>
                        <label class="switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch2" checked>
                          <a href="{{ url('change_state_doorlock/'.$postses->id) }}" class="slider round" ></a>
                      </label>
                      @else
                       
                    <label class="switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch2" disabled>
                        <a href="{{ url('change_state_doorlock/'.$postses->id) }}" class="slider round" ></a>
                    </label>
                        <h1 class="display-6 fw-bold">Pintu Terbuka</h1>
                        <a class="btn btn-info" href="{{ url('change_state_doorlock/'.$postses->id) }}">Tekan Untuk Mengunci Pintu</a>
                      @endif
                    @endforeach

