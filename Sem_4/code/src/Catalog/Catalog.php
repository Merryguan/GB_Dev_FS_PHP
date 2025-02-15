<?php

namespace App\Hw\Catalog;

use App\Hw\Books\Book;
use App\Hw\Books\RealBook;
use App\Hw\Books\DigitBook;
use App\Hw\Room\Shelf;

Class Catalog {
    
    private $books = [];

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function getBook(int $number): Book {
        return $this->books[$number - 1];
    }

    public function putBookOnShelf(RealBook $book, Shelf $shelf) {
        $shelf->addBook($book);
        $book->setShelfNumber($shelf->getShelfNumber());
    }

    public function putBookOnSite(DigitBook $book, string $url) {
        $book->setUrl($url);
    }

    public function printCatalog() {
        print("Каталог:\n");
        foreach ($this->books as $i => $value) {
            $this->books[$i]->info();
        }
    }

}