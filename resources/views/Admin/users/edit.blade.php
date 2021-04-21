@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content')
    <div class="card" style="width: 70%; min-width: 400px; margin: 0 auto;">
        <div class="card-header">
            <h1 style="text-align: center;">Editar um usuário</h1>
        </div>
        <form action="{{route('users.update', ['user' => $user->id])}}" class="form-horizontal" method="POST">
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
                    <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-info pull-right">Editar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

