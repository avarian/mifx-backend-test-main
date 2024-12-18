<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use Illuminate\Http\Request;
use App\Http\Resources\BookReviewResource;
use App\Http\Requests\PostBookReviewRequest;

class BooksReviewController extends Controller
{
    public function __construct() {}

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        // implemented
        $book = Book::findOrFail($bookId);            // Attempt to find the book by its ID, or fail with a 404 error if not found
        $bookReview = new BookReview();               // Create a new instance of the BookReview model
        $bookReview->book_id = $book->id;             // Set the book_id property to associate the review with the found book
        $bookReview->user_id = $request->user()->id;  // Set the user_id property to associate the review with the currently authenticated user
        $bookReview->review = $request->review;       // Assign the review content from the request to the review property
        $bookReview->comment = $request->comment;     // Assign the comment content from the request to the comment property
        $bookReview->save();                          // Save the filled out BookReview object as a new record in the database

        return new BookReviewResource($bookReview);   // Wrap the newly created book review in a BookReviewResource for structured response output and return it
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        // implemented
        Book::findOrFail($bookId); // Attempt to find the book by its ID, or return a 404 error if the book is not found

        // Query the BookReview model for the review matching both the book ID and the review ID,
        // ensuring that it belongs to the correct book. If no such review exists, fail with a 404 error.
        $review = BookReview::where([
            ['book_id', $bookId], // Filter by the provided book ID
            ['id', $reviewId],    // Filter by the provided review ID
        ])->firstOrFail();

        $review->delete(); // Delete the found review from the database

        return response(null, 204); // Return a HTTP 204 No Content response indicating successful deletion
    }
}
