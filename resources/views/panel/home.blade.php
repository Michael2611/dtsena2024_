@extends('layouts.app')
@section('content')
    <div class="d-flex content-f">
        @extends('panel.sidebar.sidebar')
        <div class="container p-3" style="margin-left: 400px;">
            <div class="row">
                <div class="col-md-8">
                    <section class="canales-publicos mt-5">
                        <div class="d-flex gap-2 align-items-center">
                            <h3>Canales públicos</h3>
                            @if (Auth::check())
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear
                                canal</a>
                            @endif
                        </div>
                        <div class="row">
                            @foreach ($canales as $item)
                                <div class="col-md-6">
<<<<<<< HEAD
                                    <a class="card border-0 mt-4 shadow-sm" href="/panel/mis-canales/canal/{{$item->id}}" style="background-color: #fff; text-decoration:none">
=======
                                    <div class="card mt-2 border-0">
>>>>>>> e01d2527c679ca4b9d29dc86abe33ecad9936a60
                                        <div class="card-body">
                                            <h4>{{$item->nombre_canal}}</h4>
                                            <p>Total de dispositivos</p>
                                            <p>{{$item->lugar}}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="info mt-5">
                        <div class="card card-body border-0">
                            <h3 class="fw-bold">Sobre DTSENA</h3>
                            <p>DTSENA es una plataforma diseñada específicamente para la recolección de datos del cultivo de pepino poinsset, en el marco del proyecto SENNOVA 2023 titulado "Implementación de un sistema de fertirriego automatizado para un cultivo de hortalizas". Esta plataforma posibilita la recopilación de datos tanto a través de un canal DTSENA desde un dispositivo como desde el entorno web.</p>
                            <img class="img-fluid" src="{{asset('img/logo_sennova.png')}}" alt="">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @if (Auth::check())
        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Creación de canal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/registro-canal" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="nombre_canal">Nombre del canal</label>
                            <input type="text" name="nombre_canal" id="nombre_canal" class="form-control"
                                placeholder="Ingrese nombre del canal" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="lugar">Lugar, ciudad de monitoreo</label>
                            <input type="text" name="lugar" id="lugar" class="form-control"
                                placeholder="Ingrese el lugar o la ciudad donde está realizando el monitoreo" required>
                        </div>
                        <input type="hidden" readonly name="id_user" id="id_user" class="form-control" value="{{Auth::user()->id}}" required>
                        <div class="tipo">
                            <label class="mb-2" for="tipo">Visibilidad</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="flexRadioDefault1"
                                    value="público" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Público
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" value="privado"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Privado
                                </label>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Crear canal</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
