<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use Illuminate\Http\Request;
use App\Http\Resources\BookReviewResource;
use App\Http\Requests\PostBookReviewRequest;

class BooksReviewController extends Controller
{
    public function __construct()
    {

    }

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        // implemented
        $book = Book::findOrFail($bookId);
        $bookReview = new BookReview();
        $bookReview->book_id = $book->id;
        $bookReview->user_id = $request->user()->id;
        $bookReview->review = $request->review;
        $bookReview->comment = $request->comment;
        $bookReview->save();

        return new BookReviewResource($bookReview);
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        // implemented
        $book = Book::findOrFail($bookId);
        $review = BookReview::where([
            ['book_id', $bookId],
            ['id', $reviewId],
        ])->firstOrFail();
        $review->delete();

        return response("", 204);
    }
}
