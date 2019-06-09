@extends('layout')

@section('title')
Predictions
@endsection

@section('header')
Predictions
@endsection

@section('content')

@if(!empty($message))
<div class="alert alert-success">
{{ $message }}
</div>
@endif
    <li class="list-group-item d-flex justify-content-between align-items-center">
<form method="POST" action="/predictions/create">
    @csrf
    <label>Automatically populate predictions based on existing <a href="/predictions/base">base predictions values</a> for each boss</label>
    <button class="btn btn-outline-primary btn-sm mt-2 mb-2">Go</button>
</form>
<form method="POST" action="/predictions/update">
    @csrf
    <label>Update the predictions</label>
    <button class="btn btn-outline-primary btn-sm mt-2 mb-2">Go</button>
</form>
    </li>

<ul class="list-group">
    
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Name</span>
        <span>img</span>
        <span>Next Sighting</span>
        <span>Last Seen in...</span>
        <span>Seen at...</span>
        <span>Actions</span>
    </li>
    @foreach($predictions as $pred)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $pred->Boss->name }}</span>
        <?php $img = "storage/".$pred->Boss->image;?>
        <img src="{{ asset($img) }}" alt="{{ $pred->Boss->name }}" width="40" height="40">
        @if (!empty($pred->nextSighting))
        <span>{{  \Carbon\Carbon::parse($pred->nextSighting)->format('d/m/Y') }}</span>
        @else
        <span>no prediction yet</span>
        @endif
        @if (!empty($pred->sighting->updated_at))
        <span>{{  \Carbon\Carbon::parse($pred->sighting->updated_at)->format('d/m/Y') }}</span>
        @else
        <span>no last sighting yet</span>
        @endif
        <span>{{ $pred->Server->name }}</span>
        
        <form method="POST" action='/predictions/{{ $pred->id }}' onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        </form>
    </li>
    @endforeach
{{ $predictions->links() }}
</ul>
@endsection