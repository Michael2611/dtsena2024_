@extends('layouts.app')
@section('content')
    <div class="d-flex content-f">
        @extends('panel.sidebar.sidebar')
        <div class="container-fluid mt-1">
            <div class="row">
                <div class="col-md-12 mt-1">
                    <section class="canales-publicos mt-1">
                        <div class="d-flex gap-2 align-items-center">
                            <h1>Canales públicos</h1>
                            @if (Auth::check())
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Crear
                                    canal</a>
                            @endif
                        </div>
                        <div class="row mt-2">
                            @foreach ($canales as $item)
                                <div class="col-md-4">
                                    <a class="card shadow-sm rounded-0"
                                        href="/panel/mis-canales/canal/{{ $item->id }}"
                                        style="background-color: #fff; text-decoration:none">
                                        <div class="card-header rounded-0" style="background-color: #39A900; color: #fff; font-weight: 700"><i class="bi bi-bar-chart-steps"></i> {{$item->nombre_canal}}</div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Nombre canal: <strong>{{$item->nombre_canal}}</strong></li>
                                                <li>Lugar: {{ $item->lugar }}</li>
                                                <li>Acceso: {{ $item->tipo}}</li>
                                            </ul>
                                            <div class="description">
                                                <p>{{Str::limit($item->descripcion,100)}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
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
                            <input type="hidden" readonly name="id_user" id="id_user" class="form-control"
                                value="{{ Auth::user()->id }}" required>
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
