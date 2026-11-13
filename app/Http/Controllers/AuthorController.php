<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\Relation;

class AuthorController extends Controller
{
    public function show(Author $author): View
    {
        $author->load([
            'posts' => fn (Relation $query) => $query
                ->where('is_published', true)
                ->latest('published_at'),
        ]);
        $author->loadCount('comments');

        return view('authors.show', compact('author'));
    }
}
