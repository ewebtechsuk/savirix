@extends('admin.layouts.app')

@section('content')
<h3>Dashboard</h3>

<p>Total Agencies: {{ $agencyCount }}</p>
<p>Active Agencies: {{ $activeAgencies }}</p>

<a href="{{ route('admin.agencies.index') }}">Manage Agencies</a>
@endsection
