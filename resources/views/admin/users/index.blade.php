@extends('layouts.app_admin')
@section('content')
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3>Usuários</h3>
        </div>
        <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-primary">Cadastrar</button>
        </div>
    </div>
    <users-index-component></users-index-component>
@endsection
