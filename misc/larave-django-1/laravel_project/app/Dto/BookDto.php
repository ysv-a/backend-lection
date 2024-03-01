<?php
namespace App\Dto;

class BookDto
{
    public function __construct(
        public readonly string $isbn,
        public readonly string $title,
        public readonly int $price,
        public readonly int $page,
        public readonly string $excerpt = '',
    ) {
    }
}
