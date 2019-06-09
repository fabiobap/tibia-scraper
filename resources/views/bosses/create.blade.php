@extends('layout')

@section('title')
Create Boss
@endsection

@section('header')
Bosses
@endsection

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<form method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">        
        <label for="image">Image</label>
        <input type="file" class="form-control" name="image" id="image">

    </div>
    <button class="btn btn-primary">Save</button>
</form>
@endsection