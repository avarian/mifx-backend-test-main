<?php

namespace App\Jobs;

use App\Book;
use Exception;
use App\BookContent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RetreiveBookContentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Book $book
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // @TODO implement
        // implemented
        // Fetch the ISBN of the book from $this->book object
        $isbn = $this->book->isbn;

        // Send a GET request to the endpoint constructed with the configured URI and ISBN
        $response = Http::get(config("bookshelf.uri") . "/{$isbn}");

        // Check if the response is successful (HTTP status code 200)
        if ($response->successful()) {
            // Convert the response to an object for easier access
            $response = $response->object();

            // Iterate over each content item in the table of contents from the response data
            foreach ($response->data->details->table_of_contents as $content) {
                // Create a new BookContent record for each content item
                BookContent::create([
                    'book_id' => $this->book->id,       // Associate the content with the current book ID
                    'label' => $content->label,         // Use the label provided in the content
                    'title' => $content->title,         // Use the title from the content
                    'page_number' => $content->pagenum, // Assign the page number from the content
                ]);
            }
        } else {
            // If the response is not successful, create a default BookContent entry
            BookContent::create([
                'book_id' => $this->book->id, // Associate with the current book ID
                'label' => null,              // No specific label is given
                'title' => 'Cover',           // Default title set to 'Cover'
                'page_number' => 1,           // Default to page number 1
            ]);
        }
    }
}
