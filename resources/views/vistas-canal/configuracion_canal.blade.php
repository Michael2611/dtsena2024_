@extends('layouts.app')
@section('content')
@include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')

            <div class="row mt-2">
                <div class="col-md-7">
                    <div class="card mt-2 border-0">
                        <form action="/actualizar-canal/{{ $canal->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body bg-white">
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">ID
                                        Canal</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value="{{ $canal->id }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="nombre_canal" class="col-sm-3 col-form-label">Nombre
                                        canal</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nombre_canal" name="nombre_canal"
                                            value="{{ $canal->nombre_canal }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="2" rows="2">{{ $canal->descripcion }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="lugar" class="col-sm-3 col-form-label">API
                                        credencial escritura</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="token_conexion" name="token_conexion"
                                            readonly value="{{ $canal->token_conexion }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="lugar" class="col-sm-3 col-form-label">Lugar</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="lugar" name="lugar"
                                            value="{{ $canal->lugar }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="lugar" class="col-sm-3 col-form-label">Tasa de
                                        refresco</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="tasa_de_refresco"
                                            name="tasa_de_refresco" value="{{ $canal->tasa_de_refresco }}">
                                        <span class="text-muted fw-bold"><small>Tiempo de recarga
                                                en segundos (s).</small></span>
                                    </div>
                                </div>
                                <button class="btn btn-primary mb-3">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    <h3>Ayuda</h3>
                    <p>Los canales almacenan todos los datos que recopila una aplicación ThingSpeak. Cada canal incluye ocho
                        campos que pueden contener cualquier tipo de datos, además de tres campos para datos de ubicación y
                        uno para datos de estado. Una vez que recopila datos en un canal, puede usar aplicaciones ThingSpeak
                        para analizarlos y visualizarlos.</p>
                </div>
                <?php $i = 1; ?>
                @foreach ($dispositivos as $item)
                    <div class="mb-1 row">
                        <div class="col-sm-2"><label for="">Dispositivo
                                {{ $i++ }}</label></div>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control" id="nombre_canal"
                                value="{{ $item->dispositivo }}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control" id="nombre_canal"
                                value="{{ $item->nombre_conexion }}">
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
