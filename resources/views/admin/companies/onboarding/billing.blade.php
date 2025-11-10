@extends('admin.dashboard')
@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Step 4: Billing & Payment</h2>
    <form method="POST" action="{{ route('admin.companies.onboarding.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">Card Information</label>
            <!-- Stripe Elements or card token input here -->
            <input type="text" name="card_token" class="border rounded p-2 w-full" required placeholder="Card Token (simulate for now)">
        </div>
        <button type="submit" class="btn btn-primary">Finish & Create Company</button>
    </form>
</div>
@endsection
