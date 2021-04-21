@extends('adminlte::page')

@section('title', 'Meu Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>
@endsection

@section('content')
@if(session('warning'))
    <div class="alert alert-success" style="max-width: 720px; min-width: 400px; width: 72%; margin:10px auto;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h5>
            <i class="icon fas fa-check"></i>
            {{session('warning')}}
        </h5>
    </div>
@endif
    <div class="card" style="width: 70%; min-width: 400px; margin: 0 auto;">
        <div class="card-header">
            <h1 style="text-align: center;">Minhas Informações</h1>
        </div>
        <form action="{{route('profile.save')}}" class="form-horizontal" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="inputName" class="col-sm-3 control-label">Nome Completo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{$user->name}}">
                    </div>
                </div>
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="inputEmail13" class="col-sm-3 control-label">E-mail</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" id="inputEmail13" placeholder="Email" name="email" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="password" class="col-sm-3 control-label">Nova Senha</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Senha" name="password">
                    </div>
                </div>
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="password_confirmation" class="col-sm-3 control-label">Confirme a senha</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password_confirmation" placeholder="Confirme a senha" name="password_confirmation">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="content-footer" style="display: flex; justify-content:space-around">
                    <a href="{{route('painel.index')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-info pull-right">Editar</button>
                </div>
            </div>
        </form>
    </div>
@endsection


