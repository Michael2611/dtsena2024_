@extends('layouts.app')
@section('content')
    <div class="content" style="width: 99%;margin-left:0px">
        <div class="row">
            <div class="col-md-8">
                <div class="content-izq">
                    <img src="{{asset('img/principal.jpg')}}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="contenido-login">
                    <div class="form">
                        <div class="img-logo" style="width: 200px; height: 200px;margin:auto">
                            <img style="width: 100%; height: 100%;" src="{{asset('img/LOGO_DTSENA_SINFONDO_COPY.png')}}" alt="">
                        </div>
                        <div class="card border-0">
                            <div class="card-body">
                                <form action="/login" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo electronico</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo electronico">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" placeholder="Ingrese contraseña" id="password" name="password">
                                    </div>
                                    <div class="d-flex mb-3">
                                        <button class="btn btn-primary w-100">Ingresar</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-center justify-content-end gap-2">
                                        <a href="">Recuperar contraseña</a>
                                        <a href="/registro">Nuevo usuario</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
