@extends('adminlte::page')

@section('title', 'Minhas Páginas')

@section('content_header')
    <h1>
        Minhas Páginas
        <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">Adicionar Página</a>
    </h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th style="text-align: center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td style="width: 60px">{{$page->id}}</td>
                            <td>{{$page->title}}</td>
                            <td style="width: 230px" >
                                <a target="_blank" href="" class="btn btn-sm btn-success">Ver Página</a>
                                <a href="{{route('pages.edit', ['page' => $page->id])}}" class="btn btn-sm btn-info">Editar</a>
                               <form action="{{route('pages.destroy', ['page' => $page->id])}}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir a página com título: {{$page->title}}?');">
                                   @csrf
                                   @method('DELETE')
                                   <button class="btn btn-sm btn-danger">Excluir</button>
                               </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Não há páginas cadastradas</td>
                        </tr>                        
                    @endforelse ($pages as $page)
                </tbody>
            </table>
        </div>
    </div>

    {{ $pages->links('pagination::bootstrap-4') }}
@endsection