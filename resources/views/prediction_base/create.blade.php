@extends('layout')

@section('title')
Prediction Base values
@endsection

@section('header')
Prediction Base values
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
    <p>So my intention here is to make base stats to be used by the real prediction class, 
        you add base stats for each boss and then prediction can be made for all servers 
        so you don't have to do it manually (64 servers and counting...) </p>
<form method="POST">
    @csrf
    <div class="form-group">  
        <label for="boss_id">Boss</label>
        <select name="boss_id" id="boss_id" class="form-control">
            @foreach($bosses as $boss)
        <option value="{{ $boss->id }}">
            {{ $boss->name }} - {{ $boss->id }}
        </option>
            @endforeach
    </select>
        <label for="minDays">Min days</label>
        <input type="number" class="form-control" name="minDays" id="minDays">         
        <label for="avgDays">Avg days</label>
        <input type="number" class="form-control" name="avgDays" id="avgDays">         
        <label for="maxDays">Max days</label>
        <input type="number" class="form-control" name="maxDays" id="maxDays"> 
    </div>
    <button class="btn btn-primary">Save</button>
</form>
@endsection