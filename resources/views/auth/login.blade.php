@extends('app')

@section('title', 'Log in – Barangay Bulletin')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-bold text-gray-900">Log in</h1>
                <p class="text-sm text-gray-600">Sign in to comment on Barangay Bulletin posts.</p>
            </div>

            <form method="POST" action="{{ url('/login') }}" class="mt-6 flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-1">
                    <label for="email" class="font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password" class="font-medium text-gray-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="rounded bg-blue-800 px-4 py-2 font-semibold text-white hover:bg-blue-900"
                >
                    Log in
                </button>
            </form>
        </div>
    </div>
@endsection
