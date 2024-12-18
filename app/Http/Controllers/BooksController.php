<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use App\Jobs\RetreiveBookContentsJob;
use App\Http\Requests\PostBookRequest;

class BooksController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        // @TODO implement
        // implemented
        // Retrieve all parameters from the incoming request and store them in $params
        $params = $request->all();

        // Start building a query on the Book model
        $query = Book::query();

        // Check if the title parameter exists and is not empty
        if (isset($params['title']) && trim($params['title']) !== '') {
            // Filter books by their title using a LIKE query with wildcard search
            $query->where('title', 'LIKE', '%' . trim($params['title']) . '%');
        }

        // Check if the authors parameter exists and is not empty
        if (isset($params['authors']) && trim($params['authors']) !== '') {
            // Add a subquery to filter books that have specific authors based on provided IDs
            $query->whereHas('authors', function ($q) use ($params) {
                // Use whereIn to match any of the author IDs provided in a comma-separated list
                $q->whereIn('id', explode(',', trim($params['authors'])));
            });
        }

        // Check if a sort column is specified, is not empty, and is an allowed column
        if (isset($params['sortColumn']) && trim($params['sortColumn']) !== '' && in_array($params['sortColumn'], ['title', 'avg_review', 'published_year'])) {

            // Determine the sorting direction, defaulting to ASC if not specified or invalid
            $direction = (isset($params['sortDirection']) && strtoupper(trim($params['sortDirection'])) == "DESC") ? "DESC" : "ASC";

            // Special case for sorting by average review
            if (trim($params['sortColumn']) == "avg_review") {
                // Include a count of reviews with the calculated average, ordered by this average
                $query->withCount(['reviews as average_review' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)')); // Use COALESCE to handle null averages
                }])->orderBy('average_review', $direction);
            } else {
                // Order the query based on the specified sort column and direction
                $query->orderBy(trim($params['sortColumn']), $direction);
            }
        }

        // Paginate the results to retrieve 15 books per page
        $books = $query->paginate(15);

        // Return the paginated collection of books wrapped in a BookResource
        return BookResource::collection($books);
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        // implemented
        // Create a new instance of the Book model
        $book = new Book();

        // Assign values from the request to corresponding properties of the Book object
        $book->isbn = $request->isbn; // Set the ISBN from the request
        $book->title = $request->title; // Set the title from the request
        $book->description = $request->description; // Set the description from the request
        $book->published_year = $request->published_year; // Set the published year from the request
        $book->price = $request->price; // Set the price from the request

        // Save the new book record to the database
        $book->save();

        // Associate authors with the newly created book using their IDs from the request
        $book->authors()->attach($request->authors);

        // Dispatch a job to retrieve book contents asynchronously for the newly created book
        RetreiveBookContentsJob::dispatch($book);

        // Wrap the newly created book in a BookResource and return it as the response
        return new BookResource($book);
    }
}
