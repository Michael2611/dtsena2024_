@extends('layouts.app')
@section('content')
@include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')
            <div class="row">
                <div class="col-md-7">
                    <div class="card mt-2 border-0">
                        <div class="card-body bg-white">
                            <h3>Registro de dispositivos</h3>
                            @if ($dis != '' || $dis != null)
                                <form class="row g-3"
                                    action="/panel/mis-canales/actualizar-dispositivo/{{ $dis->id }}/{{ $canal->id }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-0">
                                        <label for="dispositivo" class="form-label">Nombre
                                            dispositivo</label>
                                        <input type="text" class="form-control" id="dispositivo" name="dispositivo"
                                            value="{{ $dis->dispositivo }}" placeholder="Ingrese nombre dispositivo"
                                            required>
                                    </div>
                                    <div class="mb-0">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select" name="estado" id="estado">
                                            <option value="">--- Seleccione estado ---</option>
                                            <option value="1" {{ $dis->estado == 1 ? 'selected' : '' }}>Activo
                                            </option>
                                            <option value="2" {{ $dis->estado == 2 ? 'selected' : '' }}>Inactivo
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="tipo_grafico" class="form-label">Tipo de
                                            gráfico</label>
                                        <select class="form-select" name="tipo_grafico" id="tipo_grafico">
                                            <option value="">--- Seleccione tipo gráfico ---
                                            </option>
                                            <option value="line" {{ $dis->tipo_grafico == 'line' ? 'selected' : '' }}>
                                                Line</option>
                                            <option value="area" {{ $dis->tipo_grafico == 'area' ? 'selected' : '' }}>
                                                Area</option>
                                            <option value="bar" {{ $dis->tipo_grafico == 'bar' ? 'selected' : '' }}>Bar
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="label_grafico" class="form-label">Etiqueta label
                                            (gráfico)</label>
                                        <input type="text" class="form-control" id="label_grafico" name="label_grafico"
                                            placeholder="Ingrese nombre de la etiqueta label"
                                            value="{{ $dis->label_grafico }}">
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="label_grafico" class="form-label">Minímo
                                                valor</label>
                                            <input type="number" class="form-control" id="min_grafico" name="min_grafico"
                                                value="{{ $dis->min_grafico }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="label_grafico" class="form-label">Máximo
                                                valor</label>
                                            <input type="number" class="form-control" id="max_grafico" name="max_grafico"
                                                value="{{ $dis->max_grafico }}">
                                        </div>
                                    </div>
                                    <input type="hidden" readonly name="id_canal" id="id_canal"
                                        value="{{ $canal->id }}">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary" type="submit">Actualizar</button>
                                        <a class="btn btn-secondary"
                                            href="/panel/mis-canales/canal/{{ $canal->id }}">Cancelar</a>
                                    </div>
                                </form>
                            @elseif($dis == '' || $dis == null)
                                <form class="row g-3" action="/panel/mis-canales/registro-dispositivo" method="POST">
                                    @csrf
                                    <div class="mb-0">
                                        <label for="dispositivo" class="form-label">Nombre
                                            dispositivo</label>
                                        <input type="text" class="form-control" id="dispositivo" name="dispositivo"
                                            placeholder="Ingrese nombre dispositivo" required>
                                    </div>
                                    <div class="mb-0">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select" name="estado" id="estado">
                                            <option value="">--- Seleccione estado ---</option>
                                            <option value="1" selected>Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="tipo_grafico" class="form-label">Tipo de
                                            gráfico</label>
                                        <select class="form-select" name="tipo_grafico" id="tipo_grafico">
                                            <option value="">--- Seleccione tipo gráfico ---
                                            </option>
                                            <option value="line">Line</option>
                                            <option value="area">Area</option>
                                            <option value="bar">Bar</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="label_grafico" class="form-label">Etiqueta label
                                            (gráfico)</label>
                                        <input type="text" class="form-control" id="label_grafico"
                                            name="label_grafico" placeholder="Ingrese nombre de la etiqueta label">
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="label_grafico" class="form-label">Minímo
                                                valor</label>
                                            <input type="number" class="form-control" id="min_grafico"
                                                name="min_grafico" placeholder="Ingrese nombre de la etiqueta label">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="label_grafico" class="form-label">Máximo
                                                valor</label>
                                            <input type="number" class="form-control" id="max_grafico"
                                                name="max_grafico" placeholder="Ingrese nombre de la etiqueta label">
                                        </div>
                                    </div>
                                    <input type="hidden" readonly name="id_canal" id="id_canal"
                                        value="{{ $canal->id }}">
                                    <div>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card mt-2 border-0">
                        <div class="card-body bg-white">
                            <h3>Ayuda</h3>
                            <p>Los canales almacenan todos los datos que recopila una aplicación ThingSpeak. Cada canal
                                incluye ocho campos que pueden contener cualquier tipo de datos, además de tres campos para
                                datos de ubicación y uno para datos de estado. Una vez que recopila datos en un canal, puede
                                usar aplicaciones ThingSpeak para analizarlos y visualizarlos.</p>
                            <h3>Creando un nuevo dispositivo</h3>
                            <ul>
                                <li>Nombre del dispositivo: Ingrese el nombre del dispositivo que va a crear.</li>
                                <li>Estado: El dispositivo puede tener alguno de los dos estados activo o inactivo.</li>
                                <li>Tipo de gráfico: Seleccione como quiere observar sus datos.</li>
                                <li>Etiqueta: Identifica palabras claves del dispositivo.</li>
                                <li>Mínimo: Ingrese el valor mínimo que puede detectar el dispositivo.</li>
                                <li>Máximo: Ingrese el valor máximo que puede detectar el dispositivo.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mt-2 border-0">
                        <div class="card-body bg-white">
                            <table class="table bg-white">
                                <thead>
                                    <tr>
                                        <th>Nombre dispositivio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dispositivos as $item)
                                        <tr>
                                            <td>
                                                {{ $item->dispositivo }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <a class="btn btn-info btn-sm"
                                                        href="/panel/mis-canales/canal/{{ $canal->id }}/dispositivos/{{ $item->id }}">Editar</a>
                                                    <form
                                                        action="/panel/mis-canales/eliminar-dispositivo/{{ $item->id }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm mt-3">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
