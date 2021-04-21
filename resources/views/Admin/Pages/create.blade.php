@extends('adminlte::page')

@section('title', 'Nova Página')

@section('content')

    <div class="card" style="width: 70%; min-width: 400px; margin: 0 auto;  margin-top: -15px">
        <div class="card-header">
            <h1 style="text-align: center;">Adicionar uma nova página</h1>
        </div>
        <form action="{{route('pages.store')}}" class="form-horizontal" method="POST"> 
            @csrf
            <div class="card-body">
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="inputTitle" class="col-sm-3 control-label">Título</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" placeholder="Título da página" name="title" value="{{old('title')}}">
                    </div>
                </div>
                <div class="form-group row" style="margin: 2% auto; display: flex; width: 80%; align-items: baseline;">
                    <label for="inputBody" class="col-sm-3 control-label">Corpo da página</label>
                    <div class="col-sm-9">
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10" style="resize:none">{{old('body')}}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="content-footer" style="display: flex; justify-content:space-around;">
                    <a href="{{route('pages.index')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-info pull-right">Criar</button>
                </div>
            </div>
        </form>
    </div>
@endsection


