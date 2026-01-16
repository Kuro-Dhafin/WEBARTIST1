@extends('layouts.app')
@section('title','Artist Dashboard')
@section('content')
<h2>Welcome, {{ auth()->user()->name }}</h2>
<p>This is your artist dashboard.</p>
@endsection
