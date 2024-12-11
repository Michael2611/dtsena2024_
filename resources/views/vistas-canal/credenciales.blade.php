@extends('layouts.app')
@section('content')
@include('panel.sidebar.sidebar')
    <div class="d-flex content-f">
        <div class="container">
            @include('header-admin.header_admin')
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>API de escritura</h3>
                        <input class="form-control" type="text" name="token_conexion"
                            id="token_conexion" readonly value="{{ $canal->token_conexion }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
