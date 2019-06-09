@extends('layout')

@section('title')
Boss Sightings list
@endsection

@section('header')
Boss Sightings
@endsection

@section('content')

@if(!empty($message))
<div class="alert alert-success">
{{ $message }}
</div>
@endif
<form method="POST">
    @csrf
    <label>Search and add boss sightings automatically: </label>
    <button class="btn btn-outline-primary btn-sm mt-2 mb-2">Go</button>
    <p>may take a while..</p>
</form>

<ul class="list-group">
    
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Name</span>
        <span>img</span>
        <span>Seen in...</span>
        <span>Seen at...</span>
        <span>Actions</span>
    </li>
    @foreach($sightings as $sight)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $sight->Boss->name }}</span>
        <?php $img = "storage/".$sight->Boss->image;?>
        <img src="{{ asset($img) }}" alt="{{ $sight->Boss->name }}" width="40" height="40">
        <span>{{  \Carbon\Carbon::parse($sight->created_at)->format('d/m/Y') }}</span>
        <span>{{ $sight->Server->name }}</span>
        
        <form method="POST" action='/sightings/{{ $sight->id }}' onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        </form>
    </li>
    @endforeach
{{ $sightings->links() }}
</ul>
@endsection