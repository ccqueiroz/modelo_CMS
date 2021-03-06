@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Meus Usuários

        {{-- <a href="" class="btn btn-sm btn-success">Novo Usuário</a> --}}
        <a href="{{route('users.create')}}" class="btn btn-sm btn-success">Novo Usuário</a>
    </h1>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="width: 60px">{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                
                        <td  style="width: 150px">
                            @if($log->id !== $user->id)
                                <a href="{{route('users.edit', ['user' => $user->id])}}" class="btn btn-sm btn-info">Editar</a>
                                <form class="d-inline" action="{{route('users.destroy', ['user' => $user->id])}}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir o {{$user->name}}?');">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    
                    @endforelse
                </tbody>    
            </table>
        </div>
    </div>
        {{$users->links('pagination::bootstrap-4')}}
@endsection