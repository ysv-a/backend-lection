<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Http\Requests\Book\BookRequest;
use App\UseCase\Book\BookService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class BookController extends Controller
{

    public function index(): View
    {

        $booksCollection = Book::orderBy('id', 'desc')->paginate(5);
        return view('web.books.index', ['booksCollection' => $booksCollection]);
    }



    public function store(BookRequest $request, BookService $service): RedirectResponse
    {

        $book = $service->create($request->getDto());
        $service->notifyBook($book);

        return back()->with('success', 'The book was created');
    }


    public function edit($id): View
    {
        $book = Book::findOrFail($id);
        $booksCollection = Book::orderBy('id', 'desc')->paginate(5);

        return view('web.books.edit', ['book' => $book, 'booksCollection' => $booksCollection]);
    }


    public function update($id, BookRequest $request, BookService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());
        return back()->with('success', 'The book has been successfully updated');
    }


    public function destroy($id): RedirectResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index');
    }


    public function showApi(): JsonResponse
    {
        return new JsonResponse(
            data: Book::all(),
        );
    }
}
