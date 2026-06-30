<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Cafe $cafe)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['cafe_id'] = $cafe->id;

        Review::create($validated);
        return redirect()->route('cafes.show', $cafe);
    }
}
