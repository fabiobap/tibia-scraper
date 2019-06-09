@extends('layout')

@section('title')
Prediction Base values
@endsection

@section('header')
Prediction Base values
@endsection

@section('content')

@if(!empty($message))
<div class="alert alert-success">
{{ $message }}
</div>
@endif

    <a href="{{ route('form_create_base_stats') }}" class="btn btn-outline-dark mb-2">Create</a>

<ul class="list-group">
    
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Name</span>
        <span>img</span>
        <span>Minimum days</span>
        <span>Average days</span>
        <span>Maximum days</span>
        <span>Actions</span>
    </li>
    @foreach($predictions as $pred)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $pred->Boss->name }}</span>
        <?php $img = "storage/".$pred->Boss->image;?>
        <img src="{{ asset($img) }}" alt="{{ $pred->Boss->name }}" width="40" height="40">
        <span>{{ $pred->minDays }}</span>
        <span>{{ $pred->avgDays }}</span>
        <span>{{ $pred->maxDays }}</span>
        
        <form method="POST" action='/predictions/base/{{ $pred->id }}' onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        </form>
    </li>
    @endforeach
{{ $predictions->links() }}
</ul>
@endsection