@extends('admin.layouts.app')

@section('content')
<h3>Agencies</h3>

<form method="POST" action="{{ route('admin.agencies.store') }}">
    @csrf
    <input name="name" placeholder="Agency Name" required>
    <input name="email" placeholder="Email">
    <input name="phone" placeholder="Phone">
    <button>Add Agency</button>
</form>

<ul>
@foreach($agencies as $agency)
    <li>
        <a href="{{ route('admin.agencies.show', $agency->id) }}">
            {{ $agency->name }}
        </a>
    </li>
@endforeach
</ul>
@endsection
