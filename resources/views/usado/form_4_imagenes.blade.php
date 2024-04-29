<form method="POST" action="{{ url('/imgusado') }}" enctype="multipart/form-data">
    @csrf
    @php
    $i = 1;
    @endphp
    @isset($imagenes)
        @foreach($imagenes as $imagen)
            @php 
                $img[$i] = $imagen->ruta;
                $i++;
            @endphp
        @endforeach
    @endisset
    <input hidden type="text"  id="id_usado" name="id_usado" value="{{ isset($id_usado)?$id_usado:old('id_usado') }}">
    <div class="form-group row">
        <label for="img1" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 1') }} *</label>

        <div class="col-md-6">
            <input id="img1" type="file" class="form-control-file" name="img1" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>
            <span class="text-danger" id="img1Error"></span>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[1])?asset('/img/usados/'.$img[1]):'' }}" id="imgSubir1" class="img img-responsive" width="100%">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="img2" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 2') }} *</label>

        <div class="col-md-6">
            <input id="img2" type="file" class="form-control-file" name="img2" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>

            <span class="text-danger" id="img2Error"></span>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[2])?asset('/img/usados/'.$img[2]):'' }}" id="imgSubir2" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img3" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 3') }} *</label>

        <div class="col-md-6">
            <input id="img3" type="file" class="form-control-file" name="img3" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>

            <span class="text-danger" id="img3Error"></span>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[3])?asset('/img/usados/'.$img[3]):'' }}" id="imgSubir3" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img4" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 4') }} *</label>

        <div class="col-md-6">
            <input id="img4" type="file" class="form-control-file" name="img4" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>

            <span class="text-danger" id="img4Error"></span>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[4])?asset('/img/usados/'.$img[4]):'' }}" id="imgSubir4" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img5" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 5') }} *</label>

        <div class="col-md-6">
            <input id="img5" type="file" class="form-control-file" name="img5" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>

            <span class="text-danger" id="img5Error"></span>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[5])?asset('/img/usados/'.$img[5]):'' }}" id="imgSubir5" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img6" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 6') }} </label>

        <div class="col-md-6">
            <input id="img6" type="file" class="form-control-file" name="img6" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[6])?asset('/img/usados/'.$img[6]):'' }}" id="imgSubir6" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img7" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 7') }} </label>

        <div class="col-md-6">
            <input id="img7" type="file" class="form-control-file" name="img7" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[7])?asset('/img/usados/'.$img[7]):'' }}" id="imgSubir7" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row">
        <label for="img8" class="col-md-2 col-form-label text-md-right">{{ __('Imagen 8') }} </label>

        <div class="col-md-6">
            <input id="img8" type="file" class="form-control-file" name="img8" accept=".jpg,.png,.jpeg,.gif,.svg" autofocus>
        </div>
        <br>
        <br>
        <div class="col-md-4">
            <img src="{{ isset($img[8])?asset('/img/usados/'.$img[8]):''}}" id="imgSubir8" class="img img-responsive" width="100%">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-warning" hidden>Siguiente</button>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button id="btn-paso4" class="btn btn-warning">Siguiente</button>
        </div>
    </div>
</form>