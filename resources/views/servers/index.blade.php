@extends('layout')

@section('title')
Tibia Servers' list
@endsection

@section('header')
Servers
@endsection

@section('content')

@if(!empty($succesful))
<div class="alert alert-success">
{{ $succesful }}
</div>
@elseif(!empty($error))
<div class="alert alert-danger">
{{ $error }}
</div>
@endif

<form method="POST">
    @csrf
    <label for="name">Add all servers automatically: </label>
    <p>may take a while..</p>
    <button class="btn btn-outline-primary btn-sm mt-2 mb-2">Go</button>
</form>

<ul class="list-group">
    @foreach($servers as $server)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{$server->name}}
        <form method="POST" action='/servers/{{ $server->id }}' onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        </form>
    </li>
    @endforeach
{{ $servers->links() }}
</ul>
@endsection