<?php

namespace App\Hw\Room;

use App\Hw\Books\Book;

Class Shelf {

    private int $shelfNumber = 0;
    private $books = [];                                     /*Массив для хранения книг*/

    public function __construct(int $shelfNumber) {
        $this->shelfNumber=$shelfNumber;
    }

    public function getShelfNumber(): int {
        return $this->shelfNumber;
    }

    public function setShelfNumber(int $shelfNumber) {
        $this->shelfNumber = $shelfNumber;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function info() {
        print("Номер полки: {$this->shelfNumber}\n");
        foreach ($this->books as $i => $value) {
            $this->books[$i]->info();
        }
    }

}