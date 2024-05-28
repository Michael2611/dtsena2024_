@extends('layouts.app')
@section('content')
    <div class="contenido-login">
        <div class="form">
            <h1>Registro DTSENA</h1>
            <div class="card border-0">
                <div class="card-body">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form action="/registro" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Ingrese nombres">
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                placeholder="Ingrese apellidos">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electronico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@sena.edu.co">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="d-flex mb-3">
                            <button class="btn btn-primary w-100" type="submit">Registrar</button>
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
@endsection
