@extends('layouts.app')
@section('content')
    @include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')
            <div class="row p-3">
                <h4>Configuración de predio</h4>
                <form action="{{route($tabla ? 'actualizar-tabla' : 'generar-tabla')}}" method="{{$tabla ? 'GET' : 'POST'}}">
                    @csrf
                    <div><input type="hidden" id="canal" value="{{ $canal->id }}" name="canal" required></div>

                    <div>
                        <label for="num_surcos">Número de surcos:</label>
                        <input type="text" id="num_surcos" value="{{ $tabla ? $registro_canal->num_surcos : '' }}" name="num_surcos" required>
                    </div>

                    <div>
                        <label for="num_plantas">Número de plantas:</label>
                        <input type="number" id="num_plantas" value="{{ $tabla ? $registro_canal->num_plantas : '' }}" name="num_plantas" required>
                    </div>

                    <div>
                        <label for="nomenclatura">Seleccione nomenclatura:</label>
                        <select id="nomenclatura" name="nomenclatura" required>
                            <option value="letras">Letras</option>
                            <option value="numeros">Números</option>
                        </select>
                    </div>

                    <div>
                        <label for="lugar">Especies en estudio</label>
                            <select class="mt-3" name="especies[]" id="especies" multiple>
                                <option value="">--- Seleccione ---</option>
                                <option value="Flor de jamaica">Flor de jamaica</option>
                                <option value="Frijol caupi">Frijol caupi   </option>
                            </select>
                    </div>

                    <button class="mt-3" type="submit">Generar Tabla</button>
                </form>

                @if ($registro_canal && !empty($tabla))
                    <!-- Verificamos que el canal exista y que la tabla no esté vacía -->
                    <table class="mt-3" border="1">
                        <thead>
                            <tr>
                                @foreach ($tabla[0] as $surco)
                                    <!-- Usamos el primer registro de la tabla para mostrar los encabezados -->
                                    <th>{{ $surco['surco'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabla as $fila)
                                <!-- Iteramos sobre cada fila de la tabla -->
                                <tr>
                                    @foreach ($fila as $celda)
                                        <!-- Iteramos sobre cada celda de la fila -->
                                        <td>{{ $celda['planta'] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="mt-2">No hay datos disponibles para este canal.</p>
                @endif

                <br>
                <hr>
                <h4>Configuración de especie y parametros</h4>
                <h6>Especies presentes en el predio:</h6>
                <div class="row">
                    @foreach(explode(',', $registro_canal->especies) as $especie)
                        <div class="col-md-6">
                            <input class="form-control" type="text" value="{{ $especie }}" readonly>
                        </div>
                    @endforeach
                </div>
                <br><br>
            </div>
        </div>
    </div>
@endsection
