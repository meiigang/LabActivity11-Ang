@extends('app')

@section('title', $post->title.' – Barangay Bulletin – Purok Ang')

@section('content')
    <article class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow sm:p-8">
        <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">
            &larr; Back to posts
        </a>

        <div class="mt-6 flex flex-wrap items-center gap-2 text-sm">
            <span class="rounded-full bg-blue-100 px-3 py-1 font-medium text-blue-800">{{ $post->category }}</span>
            @if ($post->is_pinned)
                <span class="rounded-full bg-amber-100 px-3 py-1 font-medium text-amber-800">Pinned</span>
            @endif
        </div>

        <h1 class="mt-4 text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
        <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-500">
            <span>{{ $post->published_at?->format('F d, Y') }}</span>
            <span>{{ $post->views }} views</span>
            <a href="{{ route('authors.show', $post->author) }}" class="text-blue-700 hover:underline">
                {{ $post->author->name }}
            </a>
        </div>
        <div class="mt-4 flex flex-wrap gap-2 text-sm">
            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                    class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 hover:bg-gray-200">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
        <p class="mt-8 whitespace-pre-line leading-7 text-gray-700">{{ $post->body }}</p>

        <section class="mt-10 border-t border-gray-200 pt-6">
            <h2 class="text-xl font-bold text-gray-900">Comments</h2>
            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-red-50 p-4 text-red-800">
                    <p class="font-semibold">Please correct the following errors:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4 flex flex-col gap-2">
                    @csrf
                    <label for="body" class="font-medium text-gray-700">Add a comment</label>
                    <textarea id="body" name="body" rows="4" required
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="self-start rounded bg-blue-800 px-4 py-2 font-semibold text-white hover:bg-blue-900">
                        Post comment
                    </button>
                </form>
            @else
                <p class="mt-4 text-gray-600">
                    <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:underline">Sign in to comment</a>
                </p>
            @endauth
            <div class="mt-4 flex flex-col gap-4">
                @forelse ($post->comments as $comment)
                    <article class="rounded-lg bg-gray-50 p-4">
                        <p class="font-semibold text-gray-900">{{ $comment->user->name }}</p>
                        <p class="mt-1 text-gray-700">{{ $comment->body }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</p>
                    </article>
                @empty
                    <p class="text-gray-600">No comments yet.</p>
                @endforelse
            </div>
        </section>
    </article>
@endsection
