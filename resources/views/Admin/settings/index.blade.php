@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
    <h1>Configurações</h1>
@endsection

@section('content')
    {{-- @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h5>
                <i class="icon fas fa-ban"></i>
                Ocorreu um erro!
            </h5>
        </div>
    @elseif(count($errors->all()) == 0)
    <div class="alert alert-success alert-dismissible">
        <button class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h5>
            <i class="icon fas fa-check"></i>
            Alterações salvas com sucesso!
        </h5>
    </div>
    @endif --}}
    {{-- {{$data}} --}}
    <div class="card">
        <div class="card-body">
            <form action="{{route('settings.save')}}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')
                @forelse($data as $value)
                    @foreach($description as $key => $descriptionValue)
                       @if($value->name === $key)
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">{{$descriptionValue}}</label>
                            <div class="col-sm-10" style="display: flex">
                                @if($value->isColor == 1)
                                    <input type="text" name="{{$value->name}}" value="{{$value->content}}" class="form-control col-sm-11">
                                    <div class="col-sm-0" style="height: 38px; width:38px!important;border-radius:19%;margin-left:3%; background: {{$value->content}}; border: 1px solid #ced4da;"></div>
                                @else
                                    <input type="text" name="{{$value->name}}" value="{{$value->content}}" class="form-control">
                                @endif
                            </div>
                        </div>
                       @endif
                    @endforeach
                @empty
                    <div class="alert alert-warning alert-dismissible">
                        <h5>
                            <i class="icon fas fa-exclamation-triangle"></i>
                            Não há variáveis de ambiente!
                        </h5>
                    </div>
                @endforelse
                @if(!empty($data))
                    <div style="text-align: center;">
                        <input type="submit" value="Salvar" class="btn btn-success" >
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection


@section('js')
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
@endsection