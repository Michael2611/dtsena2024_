@extends('layouts.app')
@section('content')
    <div class="d-flex content-f">
        @extends('panel.sidebar.sidebar')
        <div class="container p-3 mt-2">
            <h1 class="fw-bold">Mis canales</h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre canal</th>
                                <th>Lugar - Ubicación</th>
                                <th>Tipo visibilidad</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach ($canales as $item)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item->nombre_canal}}</td>
                                    <td>{{$item->lugar}}</td>
                                    <td>{{$item->tipo}}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <a class="btn btn-primary" href="/panel/mis-canales/canal/{{$item->id}}">Ver</a>
                                            <form action="/panel/canal/{{$item->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger mt-3" type="submit">Eliminar</button>
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
@endsection
@section('footer')
@endsection
