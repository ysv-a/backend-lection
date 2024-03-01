<?php

namespace App\Http\Requests\Book;

use App\Dto\BookDto;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
//            'isbn' => 'required|unique:books,isbn',
            'isbn' => 'required',
            'title' => 'required|max:255',
            'price' => 'required|integer',
            'page' => 'required|integer',
        ];
    }

    public function getDto(): BookDto
    {

        return new BookDto(
            isbn: $this->input('isbn'),
            title: $this->input('title'),
            price: $this->input('price'),
            page: $this->input('page'),
            excerpt: $this->input('excerpt') ?? '',
        );
    }

}
