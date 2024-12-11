@extends('layouts.app')
@section('content')
    @include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')
            <div class="row mt-2">
                @foreach ($dispositivos as $dispositivo)
                    <div class="col-md-6 mt-2 mb-2">
                        <div class="card shadow-sm rounded-0 border-0">
                            <div class="card-header bg-primario text-white rounded-0">
                                {{ $dispositivo->dispositivo }}
                            </div>
                            <div class="card-body bg-white">
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
                                    var i = 0;
                                    response.forEach(function(dispositivo) {
                                        i++;
                                        if (dispositivo.id === {{ $dispositivo->id }}) {
                                            dispositivo.datos.forEach(function(dato) {
                                                fechas.push(new Date(dato.created_at).toLocaleTimeString());
                                                valores.push(dato["campo" + i]);
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
    </div>
@endsection
