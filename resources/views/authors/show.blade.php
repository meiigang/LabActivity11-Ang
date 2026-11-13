@extends('app')

@section('title', $author->name.' – Barangay Bulletin – Purok Ang')

@section('content')
    <div class="flex flex-col gap-6">
        <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">
            &larr; Back to posts
        </a>

        <header class="rounded-xl bg-white p-6 shadow">
            <h1 class="text-3xl font-bold text-gray-900">{{ $author->name }}</h1>
            <p class="mt-2 text-gray-600">{{ $author->position }}</p>
            <p class="mt-3 text-sm text-gray-500">{{ $author->comments_count }} comments received</p>
        </header>

        <section class="flex flex-col gap-4">
            <h2 class="text-2xl font-bold text-gray-900">Published posts</h2>
            @forelse ($author->posts as $post)
                <article class="rounded-xl bg-white p-6 shadow">
                    <h3 class="text-xl font-bold">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-gray-900 hover:text-blue-700">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">{{ $post->published_at?->format('M d, Y') }}</p>
                </article>
            @empty
                <p class="rounded-lg bg-white p-6 text-gray-600 shadow">This author has no published posts.</p>
            @endforelse
        </section>
    </div>
@endsection
