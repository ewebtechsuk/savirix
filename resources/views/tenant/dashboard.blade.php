@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Company Dashboard</div>
                <div class="card-body">
                    <h3>Welcome to your company dashboard!</h3>
                    <p>This is your private area. Only your company users can access this dashboard.</p>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
