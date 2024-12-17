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
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // @TODO implement
        // implemented
        $params = $request->all();
        $query = Book::with(['authors', 'bookContents', 'reviews']);

        if ( isset($params['title']) && trim($params['title']) !== '') {
            $query->where('title', 'LIKE', '%' . trim($params['title']) . '%');
        }
        if ( isset($params['authors']) && trim($params['authors']) !== '') {
            $query->whereHas('authors', function($q) use ($params){
                $q->whereIn('id', explode(',', trim($params['authors'])));
            });
        }
        if ( isset($params['sortColumn']) && trim($params['sortColumn']) !== '' && in_array($params['sortColumn'], ['title', 'avg_review', 'published_year'])) {
            $direction = (isset($params['sortDirection']) && strtoupper(trim($params['sortDirection'])) == "DESC") ? "DESC" : "ASC" ;
            if (trim($params['sortColumn']) == "avg_review") {
                $query->withCount(['reviews as average_review' => function($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)'));
                }])->orderBy('average_review', $direction);
            } else {
                $query->orderBy(trim($params['sortColumn']), $direction);
            }
        }

        $books = $query->paginate(15);
        return BookResource::collection($books);
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        // implemented
        $book = new Book();
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->published_year = $request->published_year;
        $book->price = $request->price;
        $book->save();

        $book->authors()->attach($request->authors);

        RetreiveBookContentsJob::dispatch($book);

        return new BookResource($book);
    }
}
