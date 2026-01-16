@extends('layouts.app')
@section('title','Buyer Dashboard')
@section('content')
<h2>Welcome, {{ auth()->user()->name }}</h2>
<p>Your recent orders will appear here.</p>
@endsection
