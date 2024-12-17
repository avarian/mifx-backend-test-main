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
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // @TODO implement
        // implemented
        $isbn = $this->book->isbn;
        $response = Http::get(config("bookshelf.uri")."/{$isbn}");

        if ($response->successful()) {
            $response = $response->object();

            foreach ($response->data->details->table_of_contents as $content) {
                BookContent::create([
                    'book_id' => $this->book->id,
                    'label' => $content->label,
                    'title' => $content->title,
                    'page_number' => $content->pagenum,
                ]);
            }
        } else {
            BookContent::create([
                'book_id' => $this->book->id,
                'label' => null,
                'title' => 'Cover',
                'page_number' => 1,
            ]);
        }
    }
}
