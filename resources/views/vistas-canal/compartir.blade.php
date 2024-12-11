@extends('layouts.app')
@section('content')
@include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')
            <div class="row mt-2">
                <div class="d-flex gap-2">
                    <input class="form-control" id="urlInput" type="text"
                        value="{{ $url }}" readonly>
                    <button class="btn btn-primary" onclick="copiarURL()">Compartir</button>
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
