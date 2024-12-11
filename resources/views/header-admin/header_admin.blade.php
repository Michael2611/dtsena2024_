
<style>
    .active{
       background-color: #e6e5e5;
       border: 1px solid #acacac;
    }
</style>

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
    <div class="d-flex gap-2">
        <a class="btn-header-admin {{Route::currentRouteName() == 'vista_publica' ? 'active' : ''}}" href="/canal/{{$canal->id}}/vista-publica">Vista pública</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'configuracion_canal' ? 'active' : ''}}" href="/canal/{{$canal->id}}/configuracion-canal">Configuración del canal</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'vista_dispositivo' ? 'active' : ''}}" href="/canal/{{$canal->id}}/dispositivos">Dispositivos</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'distribucion_terreno' ? 'active' : ''}}" href="/canal/{{$canal->id}}/distribucion-terreno">Distribución terreno</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'compartir' ? 'active' : ''}}" href="/canal/{{$canal->id}}/compartir">Compartir</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'credenciales' ? 'active' : ''}}" href="/canal/{{$canal->id}}/credenciales">Credenciales</a>
        <a class="btn-header-admin {{Route::currentRouteName() == 'exportar_datos' ? 'active' : ''}}" href="#">Exportar datos</a>
    </div>
</div>
