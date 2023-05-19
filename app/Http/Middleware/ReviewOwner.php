<?php

namespace App\Http\Middleware;

use App\Models\Review;
use Closure;
use Illuminate\Http\Request;


class ReviewOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $review = Review::findOrFail($request->id);
        if ($review->user_id != $user->id) {
            return response()->json(['message' => 'data not found'], 404);
        }

        return $next($request);
    }
}
