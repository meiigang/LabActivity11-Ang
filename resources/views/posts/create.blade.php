@extends('app')

@section('title', 'New post – Barangay Bulletin – Purok Ang')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-xl bg-white p-6 shadow sm:p-8">
            <h1 class="text-3xl font-bold text-gray-900">Create a new post</h1>

            @if ($errors->any())
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-red-800">
                    <p class="font-semibold">Please correct the following errors:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}" class="mt-6 flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-1">
                    <label for="title" class="font-medium text-gray-700">Title</label>
                    <input id="title" name="title" value="{{ old('title') }}" required
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('title')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label for="body" class="font-medium text-gray-700">Body</label>
                    <textarea id="body" name="body" rows="7" required
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label for="category" class="font-medium text-gray-700">Category</label>
                    <select id="category" name="category" required
                        class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select a category</option>
                        @foreach (['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Event'] as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset class="flex flex-col gap-2">
                    <legend class="font-medium text-gray-700">Tags</legend>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($tags as $tag)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, old('tags', [])))
                                    class="rounded border-gray-300 text-blue-700 focus:ring-blue-500">
                                <span>{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('tags.*')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1"
                        @checked(old('is_published', true))
                        class="rounded border-gray-300 text-blue-700 focus:ring-blue-500">
                    <span class="font-medium text-gray-700">Publish immediately</span>
                </label>
                @error('is_published')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="self-start rounded bg-blue-800 px-5 py-2 font-semibold text-white hover:bg-blue-900">
                    Create post
                </button>
            </form>
        </div>
    </div>
@endsection
