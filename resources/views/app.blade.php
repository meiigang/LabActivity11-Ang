<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Bulletin – Purok Ang')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-100 text-gray-900">
    <header class="bg-blue-800 text-white shadow">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('posts.index') }}" class="text-xl font-bold">Barangay Bulletin – Purok Ang</a>
            <nav class="flex items-center gap-4">
                @auth
                    <span class="text-sm font-medium">Signed in as {{ auth()->user()->name }}</span>
                    @if (auth()->user()->author()->exists())
                        <a href="{{ route('posts.mine') }}"
                            class="rounded-lg bg-amber-300 px-3 py-2 font-semibold text-blue-950 shadow-sm hover:bg-amber-200">
                            My posts
                        </a>
                        <a href="{{ route('posts.create') }}"
                            class="rounded-lg bg-amber-300 px-3 py-2 font-semibold text-blue-950 shadow-sm hover:bg-amber-200">
                            New post
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-lg bg-red-500 px-3 py-2 font-semibold text-white shadow-sm hover:bg-red-400">
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-lg bg-amber-300 px-3 py-2 font-semibold text-blue-950 shadow-sm hover:bg-amber-200">
                        Sign in
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>
</body>
</html>
