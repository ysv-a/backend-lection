<?php
namespace App\UseCase\Book;

use App\Events\BookUpdatePrice;
use App\Exceptions\BusinessException;
use App\Mail\NewBook;
use App\Models\Book;
use App\Dto\BookDto;
use App\Services\Sms\Sms;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class BookService
{

    public function __construct(
        public Mailer $mailer,
        public Dispatcher $dispatcher,
        public Sms $sms,
    ) {
    }

    public function create(BookDto $bookDto): Book
    {
        $this->isbnIsUnique($bookDto->isbn);

        $book = new Book;
        $book->isbn = $bookDto->isbn;
        $book->title = $bookDto->title;
        $book->price = $bookDto->price;
        $book->page = $bookDto->page;
        $book->excerpt = $bookDto->excerpt;
        $book->saveOrFail();

        return $book;
    }


    public function notifyBook($book)
    {
        $this->mailer->send(new NewBook($book));
//        Mail::send(new NewBook($book));


        $this->sms->send('+7999999999', 'New Book Created');
    }



    public function update(int $id, BookDto $bookDto): Book
    {
        $book = Book::findOrFail($id);

        $this->isbnIsUnique($bookDto->isbn, $id);

        $old_price = $book->price;
        $book->updateOrFail([
            'isbn' => $bookDto->isbn,
            'title' => $bookDto->title,
            'price' => $bookDto->price,
            'page' => $bookDto->page,
            'excerpt' => $bookDto->excerpt,
        ]);

        if($bookDto->price < $old_price){
            $this->dispatcher->dispatch(
                new BookUpdatePrice($book->id)
            );
//            event(new BookUpdatePrice($book->id));
        }
        return $book;
    }

    private function isbnIsUnique(string $isbn, $exceptId = null): void
    {
        if($exceptId){
            $existBook = Book::where('isbn', $isbn)->where('id', '<>', $exceptId)->count();
        }else{
            $existBook = Book::where('isbn', $isbn)->count();
        }

        if($existBook){
            throw new BusinessException("Book with this isbn already exists " . $isbn);
        }
    }
}
