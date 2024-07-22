@extends('layouts.app')
@section('content')
    <div class="d-flex content-f">
        @extends('panel.sidebar.sidebar')
        <div class="container p-2">
            <h1 class="fw-bold display-6">{{ $canal->nombre_canal }}</h1>
            <ul>
                <li>Lugar: {{ $canal->lugar }}</li>
                <li>Tipo: {{ $canal->tipo }}</li>
                <li>Fecha de creación: {{ $canal->created_at }}</li>
            </ul>
            <p>Descripción del canal: {{ $canal->descripcion }}</p>
            <hr>
            <div class="row">
                @foreach ($datosPromedio as $item)
                    <div class="col-md-4">
                        <div class="card card-body d-flex justify-content-between align-items-center bg-white rounded-0">
                            <div class="content-1">
                                <h4 class="fw-bold">{{ $item->dispositivo->dispositivo }}</h4>
                                <p class="text-muted">Valor</p>
                            </div>
                            <div class="content-2">
                                <h1 class="text-primario fw-bold">
                                    {{ $item->valor . ' ' . $item->dispositivo->label_grafico }}</h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !Auth::check() ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">Vista
                            pública</button>
                    </li>
                    @if (Auth::check())
                        @if (Auth::user()->id == $canal->id_user)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $dis == null ? 'active' : '' }}" id="profile-tab"
                                    data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab"
                                    aria-controls="profile-tab-pane" aria-selected="false">Configuración canal</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  {{ $dis != null ? 'active' : '' }}" id="dispositivo-tab"
                                    data-bs-toggle="tab" data-bs-target="#dispositivo-tab-pane" type="button"
                                    role="tab" aria-controls="dispositivo-tab-pane"
                                    aria-selected="true">Dispositivos</button>
                            </li>
                        @endif
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                            type="button" role="tab" aria-controls="contact-tab-pane"
                            aria-selected="false">Compartir</button>
                    </li>
                    @if (Auth::check())
                        @if (Auth::user()->id == $canal->id_user)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#credentials-tab-pane" type="button" role="tab"
                                    aria-controls="credentials-tab-pane" aria-selected="false">Credenciales</button>
                            </li>
                        @endif
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="exportar-tab" data-bs-toggle="tab" data-bs-target="#exportar-tab-pane"
                            type="button" role="tab" aria-controls="exportar-tab-pane" aria-selected="false">Exportar
                            datos</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!--Vista pública-->
                    <div class="tab-pane fade {{ !Auth::check() ? 'show active' : '' }}" id="home-tab-pane" role="tabpanel"
                        aria-labelledby="home-tab" tabindex="0">
                        <div class="row mt-2">
                            @foreach ($dispositivos as $dispositivo)
                                <div class="col-md-6 mt-2 mb-2">
                                    <div class="card shadow-sm rounded-0">
                                        <div class="card-header bg-primario text-white rounded-0">
                                            {{ $dispositivo->dispositivo }}
                                        </div>
                                        <div class="card-body">
                                            <div style="width: 100%; margin: auto;">
                                                <canvas id="barChart{{ $dispositivo->id }}"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    // Crear la gráfica inicialmente
                                    var ctx{{ $dispositivo->id }} = document.getElementById('barChart{{ $dispositivo->id }}').getContext('2d');
                                    var myChart{{ $dispositivo->id }} = new Chart(ctx{{ $dispositivo->id }}, {
                                        type: '{{ $dispositivo->tipo_grafico }}',
                                        data: {
                                            labels: [],
                                            datasets: [{
                                                label: '{{ $dispositivo->label_grafico }}',
                                                data: [],
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 2
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    min: {{ $dispositivo->min_grafico }},
                                                    max: {{ $dispositivo->max_grafico }},
                                                }
                                            }
                                        }
                                    });

                                    function updateChart{{ $dispositivo->id }}(data) {
                                        myChart{{ $dispositivo->id }}.data.labels = data.fechas;
                                        myChart{{ $dispositivo->id }}.data.datasets[0].data = data.valores;
                                        myChart{{ $dispositivo->id }}.update();
                                    }

                                    function fetchData{{ $dispositivo->id }}() {
                                        $.ajax({
                                            url: '{{ route('canal.datos', ['id' => $dispositivo->id_canal]) }}',
                                            method: 'GET',
                                            success: function(response) {
                                                var fechas = [];
                                                var valores = [];
                                                response.forEach(function(dispositivo) {
                                                    if (dispositivo.id === {{ $dispositivo->id }}) {
                                                        dispositivo.datos.forEach(function(dato) {
                                                            fechas.push(new Date(dato.created_at).toLocaleTimeString());
                                                            valores.push(dato.valor);
                                                        });
                                                    }
                                                });
                                                updateChart{{ $dispositivo->id }}({
                                                    fechas: fechas,
                                                    valores: valores
                                                });
                                            }
                                        });
                                    }

                                    setInterval(fetchData{{ $dispositivo->id }}, 5000); // Actualizar cada 5 segundos
                                </script>
                            @endforeach

                        </div>
                    </div>
                    <!--Fin de sección-->
                    @if (Auth::check())
                        @if (Auth::user()->id == $canal->id_user)
                            <!--Seccion agregar nuevos dispositivos-->
                            <div class="tab-pane fade {{ $dis != null ? 'show active' : '' }}" id="dispositivo-tab-pane"
                                role="tabpanel" aria-labelledby="dispositivo-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="card mt-2 rounded-0">
                                            <div class="card-header bg-primario text-white rounded-0">Dispositivos</div>
                                            <div class="card-body bg-white">
                                                @if ($dis != '' || $dis != null)
                                                    <form class="row g-3"
                                                        action="/panel/mis-canales/actualizar-dispositivo/{{ $dis->id }}/{{ $canal->id }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-0">
                                                            <label for="dispositivo" class="form-label">Nombre
                                                                dispositivo</label>
                                                            <input type="text" class="form-control" id="dispositivo"
                                                                name="dispositivo" value="{{ $dis->dispositivo }}"
                                                                placeholder="Ingrese nombre dispositivo" required>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <select class="form-select" name="estado" id="estado">
                                                                <option value="">--- Seleccione estado ---</option>
                                                                <option value="1"
                                                                    {{ $dis->estado == 1 ? 'selected' : '' }}>Activo
                                                                </option>
                                                                <option value="2"
                                                                    {{ $dis->estado == 2 ? 'selected' : '' }}>Inactivo
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label for="tipo_grafico" class="form-label">Tipo de
                                                                gráfico</label>
                                                            <select class="form-select" name="tipo_grafico"
                                                                id="tipo_grafico">
                                                                <option value="">--- Seleccione tipo gráfico ---
                                                                </option>
                                                                <option value="line"
                                                                    {{ $dis->tipo_grafico == 'line' ? 'selected' : '' }}>
                                                                    Line</option>
                                                                <option value="area"
                                                                    {{ $dis->tipo_grafico == 'area' ? 'selected' : '' }}>
                                                                    Area</option>
                                                                <option value="bar"
                                                                    {{ $dis->tipo_grafico == 'bar' ? 'selected' : '' }}>Bar
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label for="label_grafico" class="form-label">Etiqueta label
                                                                (gráfico)</label>
                                                            <input type="text" class="form-control" id="label_grafico"
                                                                name="label_grafico"
                                                                placeholder="Ingrese nombre de la etiqueta label"
                                                                value="{{ $dis->label_grafico }}">
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label for="label_grafico" class="form-label">Minímo
                                                                    valor</label>
                                                                <input type="number" class="form-control"
                                                                    id="min_grafico" name="min_grafico"
                                                                    value="{{ $dis->min_grafico }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="label_grafico" class="form-label">Máximo
                                                                    valor</label>
                                                                <input type="number" class="form-control"
                                                                    id="max_grafico" name="max_grafico"
                                                                    value="{{ $dis->max_grafico }}">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" readonly name="id_canal" id="id_canal"
                                                            value="{{ $canal->id }}">
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-primary"
                                                                type="submit">Actualizar</button>
                                                            <a class="btn btn-secondary"
                                                                href="/panel/mis-canales/canal/{{ $canal->id }}">Cancelar</a>
                                                        </div>
                                                    </form>
                                                @elseif($dis == '' || $dis == null)
                                                    <form class="row g-3" action="/panel/mis-canales/registro-dispositivo"
                                                        method="POST">
                                                        @csrf
                                                        <div class="mb-0">
                                                            <label for="dispositivo" class="form-label">Nombre
                                                                dispositivo</label>
                                                            <input type="text" class="form-control" id="dispositivo"
                                                                name="dispositivo"
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
                                                            <select class="form-select" name="tipo_grafico"
                                                                id="tipo_grafico">
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
                                                                name="label_grafico"
                                                                placeholder="Ingrese nombre de la etiqueta label">
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label for="label_grafico" class="form-label">Minímo
                                                                    valor</label>
                                                                <input type="number" class="form-control"
                                                                    id="min_grafico" name="min_grafico"
                                                                    placeholder="Ingrese nombre de la etiqueta label">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="label_grafico" class="form-label">Máximo
                                                                    valor</label>
                                                                <input type="number" class="form-control"
                                                                    id="max_grafico" name="max_grafico"
                                                                    placeholder="Ingrese nombre de la etiqueta label">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" readonly name="id_canal" id="id_canal"
                                                            value="{{ $canal->id }}">
                                                        <div>
                                                            <button class="btn btn-primary"
                                                                type="submit">Guardar</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card mt-2 rounded-0">
                                            <div class="card-header rounded-0 bg-primario text-white">Dispositivos
                                                registrados</div>
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
                                                                            href="/panel/mis-canales/canal/{{ $canal->id }}/dispositivo/{{ $item->id }}">Editar</a>
                                                                        <form
                                                                            action="/panel/mis-canales/eliminar-dispositivo/{{ $item->id }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button
                                                                                class="btn btn-danger btn-sm mt-3">Eliminar</button>
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
                            <!--Fin de seccion-->
                            <!--Sección configuración de canal -->
                            <div class="tab-pane fade show {{ $dis == null ? 'show active' : '' }}" id="profile-tab-pane"
                                role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <div class="p-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mt-2 rounded-0 border-0">
                                                <div class="card-header bg-primario text-white rounded-0">Configuración
                                                    canal</div>
                                                <form action="/actualizar-canal/{{ $canal->id }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="card-body bg-white">
                                                        <div class="mb-3 row">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label">ID
                                                                Canal</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" readonly
                                                                    class="form-control-plaintext" id="staticEmail"
                                                                    value="{{ $canal->id }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="nombre_canal"
                                                                class="col-sm-3 col-form-label">Nombre
                                                                canal</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    id="nombre_canal" name="nombre_canal"
                                                                    value="{{ $canal->nombre_canal }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="descripcion"
                                                                class="col-sm-3 col-form-label">Descripción</label>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control" name="descripcion" id="descripcion" cols="2" rows="2">{{ $canal->descripcion }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="lugar" class="col-sm-3 col-form-label">API
                                                                credencial escritura</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    id="token_conexion" name="token_conexion" readonly
                                                                    value="{{ $canal->token_conexion }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="lugar"
                                                                class="col-sm-3 col-form-label">Lugar</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="lugar"
                                                                    name="lugar" value="{{ $canal->lugar }}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="lugar" class="col-sm-3 col-form-label">Tasa de
                                                                refresco</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    id="tasa_de_refresco" name="tasa_de_refresco"
                                                                    value="{{ $canal->tasa_de_refresco }}">
                                                                <span class="text-muted fw-bold"><small>Tiempo de recarga
                                                                        en segundos (s).</small></span>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary mb-3">Guardar cambios</button>
                                                        <hr>
                                                        <?php $i = 1; ?>
                                                        @foreach ($dispositivos as $item)
                                                            <div class="mb-1 row">
                                                                <div class="col-sm-2"><label for="">Dispositivo
                                                                        {{ $i++ }}</label></div>
                                                                <div class="col-sm-5">
                                                                    <input type="text" readonly class="form-control"
                                                                        id="nombre_canal"
                                                                        value="{{ $item->dispositivo }}">
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <input type="text" readonly class="form-control"
                                                                        id="nombre_canal"
                                                                        value="{{ $item->nombre_conexion }}">
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin de sección-->
                        @endif
                    @endif
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mt-1">
                                    <div class="card-header">Compartir canal</div>
                                    <div class="card-body">
                                        <div class="d-flex gap-2">
                                            <input class="form-control" id="urlInput" type="text"
                                                value="{{ $url }}" readonly>
                                            <button class="btn btn-primary" onclick="copiarURL()">Compartir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="credentials-tab-pane" role="tabpanel"
                        aria-labelledby="credentials-tab" tabindex="0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mt-2">
                                    <div class="card-header">API de escritura</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h3>API</h3>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="token_conexion"
                                                    id="token_conexion" readonly value="{{ $canal->token_conexion }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="exportar-tab-pane" role="tabpanel" aria-labelledby="exportar-tab"
                        tabindex="0">Exportar datos</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        function copiarURL() {
            var urlInput = document.getElementById("urlInput");
            urlInput.select();
            document.execCommand("copy");
            alert("URL copiada al portapapeles: " + urlInput.value);
        }
    </script>
@endsection
