@extends('admin.layouts.auth')

@section('content')
    <div class="rounded-2xl bg-gray-900/80 border border-gray-800 shadow-2xl p-8">
        <div class="space-y-2 text-center">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Owner Admin</p>
            <h1 class="text-2xl font-bold text-white">Sign in to Savarix</h1>
            <p class="text-sm text-gray-400">Use your owner credentials to access the admin console.</p>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-lg border border-red-500/60 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input id="email" type="email" name="email" required autofocus
                       class="mt-2 w-full rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-gray-100 focus:border-yellow-400 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-2 w-full rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-gray-100 focus:border-yellow-400 focus:outline-none">
            </div>
            <button type="submit"
                    class="w-full rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-black shadow hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                Sign in
            </button>
        </form>
    </div>
@endsection
