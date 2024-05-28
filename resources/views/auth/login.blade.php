@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="content-izq">
                    <img src="{{asset('img/principal.jpg')}}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="contenido-login">
                    <div class="form">
                        <h1 class="fw-bold">DTSENA</h1>
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <form action="/login" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo electronico</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@sena.edu.co">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="d-flex mb-3">
                                        <button class="btn btn-primary w-100">Ingresar</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-center justify-content-end gap-2">
                                        <a href="">Recuperar contraseña</a>
                                        <a href="">Nuevo usuario</a>
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
