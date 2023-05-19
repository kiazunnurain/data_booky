<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
       $validated = $request->validate([
        'book_id' => 'required',
        'reviews_content' => 'required',
       ]);

       $request['user_id'] = auth()->user()->id;
       $review = Review::create($request->all());

       return new ReviewResource($review->loadMissing(['reviewer:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'reviews_content' =>'required',
            ]);
    
            $review = Review::findOrFail($id);
            $review->update($request->only('reviews_content'));
    
            return new ReviewResource($review->loadMissing(['reviewer:id,username']));
    }

    public function destroy($id)
    {
       $review = Review::findOrFail($id);
       $review->delete();

       return new ReviewResource($review->loadMissing('reviewer:id,username'));
    }
}
