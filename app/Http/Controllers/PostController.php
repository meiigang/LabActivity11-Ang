<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private const PER_PAGE = 6;

    public function create(): View
    {
        $tags = Tag::query()->orderBy('name')->get();

        return view('posts.create', compact('tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $tagIds = $validated['tags'];
        unset($validated['tags']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $post = $request->user()->author()->firstOrFail()->posts()->create($validated);
        $post->tags()->sync($tagIds);

        return $post->is_published
            ? redirect()->route('posts.show', $post)
            : redirect()->route('posts.mine');
    }

    public function mine(Request $request): View
    {
        $author = $request->user()->author()->firstOrFail();
        $posts = $author->posts()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->latest('created_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('posts.mine', compact('posts'));
    }

    public function index(Request $request): View
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function (Builder $query) use ($request): void {
                $query->where('title', 'like', '%'.$request->string('q')->toString().'%');
            })
            ->when($request->filled('category'), function (Builder $query) use ($request): void {
                $query->where('category', $request->string('category')->toString());
            })
            ->when($request->filled('tag'), function (Builder $query) use ($request): void {
                $query->whereHas('tags', function (Builder $tagQuery) use ($request): void {
                    $tagQuery->where('name', $request->string('tag')->toString());
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Post::query()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(int $id): View
    {
        $post = Post::findOrFail($id);

        abort_unless($post->is_published, 404);

        $post->views++;
        $post->save();
        $post->load([
            'author',
            'tags',
            'comments' => fn (Relation $query) => $query->with('user')->latest(),
        ]);

        return view('posts.show', compact('post'));
    }
}
