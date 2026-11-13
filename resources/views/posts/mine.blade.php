@extends('app')

@section('title', 'My Posts – Barangay Bulletin – Purok Ang')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My posts</h1>
                <p class="mt-2 text-gray-600">View your published posts and drafts.</p>
            </div>
            <a href="{{ route('posts.create') }}"
                class="self-start rounded-lg bg-amber-400 px-4 py-2 font-semibold text-blue-950 shadow-sm hover:bg-amber-300">
                New post
            </a>
        </div>

        @forelse ($posts as $post)
            <article class="rounded-xl bg-white p-6 shadow">
                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <span class="rounded-full bg-blue-100 px-3 py-1 font-medium text-blue-800">
                        {{ $post->category }}
                    </span>
                    @if ($post->is_published)
                        <span class="rounded-full bg-green-100 px-3 py-1 font-medium text-green-800">Published</span>
                    @else
                        <span class="rounded-full bg-gray-200 px-3 py-1 font-medium text-gray-700">Draft</span>
                    @endif
                </div>

                <h2 class="mt-3 text-xl font-bold text-gray-900">{{ $post->title }}</h2>
                <p class="mt-2 line-clamp-3 text-gray-600">{{ $post->body }}</p>

                <div class="mt-3 flex flex-wrap gap-2 text-sm">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">#{{ $tag->name }}</span>
                    @endforeach
                </div>

                <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                    @if ($post->published_at)
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                    @else
                        <span>Not published</span>
                    @endif
                    <span>{{ $post->comments_count }} comments</span>
                    @if ($post->is_published)
                        <a href="{{ route('posts.show', $post) }}" class="text-blue-700 hover:underline">
                            View post
                        </a>
                    @endif
                </div>
            </article>
        @empty
            <p class="rounded-lg bg-white p-6 text-gray-600 shadow">You have not created any posts yet.</p>
        @endforelse

        <div>{{ $posts->links() }}</div>
    </div>
@endsection
