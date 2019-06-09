@extends('layout')

@section('title')
Bosses list
@endsection

@section('header')
Bosses
@endsection

@section('content')

@if(!empty($message))
<div class="alert alert-success">
{{ $message }}
</div>
@endif
<a href="{{ route('form_create_boss') }}" class="btn btn-outline-dark mb-2">Add Boss</a>

<ul class="list-group">
    @foreach($bosses as $boss)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <?php $img = "storage/".$boss->image?>
        <img src="{{ asset($img) }}" alt="{{ $boss->name }}" width="40" height="40">
        {{ $boss->name }}
        <form method="POST" action='/bosses/{{ $boss->id }}' onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        </form>
    </li>
    @endforeach
{{ $bosses->links() }}
</ul>
@endsection