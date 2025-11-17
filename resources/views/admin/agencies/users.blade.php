@extends('admin.layouts.app')

@section('content')
<h3>Users in {{ $agency->name }}</h3>

<form method="POST" action="{{ route('admin.agencies.users.store', $agency->id) }}">
    @csrf
    <input name="name" placeholder="User Name" required>
    <input name="email" placeholder="Email" required>
    <input name="password" placeholder="Password" required>
    <select name="role">
        <option value="agency_admin">Agency Admin</option>
        <option value="agent">Agent</option>
    </select>
    <button>Add User</button>
</form>

<ul>
@foreach($users as $user)
    <li>
        {{ $user->name }} ({{ $user->role }})
        <form method="POST" action="{{ route('admin.agencies.users.destroy', [$agency->id, $user->id]) }}">
            @csrf @method('DELETE')
            <button>Delete</button>
        </form>
    </li>
@endforeach
</ul>

@endsection
