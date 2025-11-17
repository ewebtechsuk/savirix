@extends('admin.layouts.app')

@section('content')
<h3>Owner Login</h3>

<form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>
@endsection
