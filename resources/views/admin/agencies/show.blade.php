@extends('admin.layouts.app')

@section('content')
<h3>{{ $agency->name }}</h3>

<p>Email: {{ $agency->email }}</p>
<p>Phone: {{ $agency->phone }}</p>
<p>Status: {{ $agency->status }}</p>

<a href="{{ route('admin.agencies.users.index', $agency->id) }}">Manage Users</a>
@endsection
