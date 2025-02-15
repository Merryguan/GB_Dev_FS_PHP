<?php

namespace App\Hw\Books;

use App\Hw\Books\Book;

Class RealBook extends Book {

    private int $shelfNumber = 0;

    public function getShelfNumber() {
        $this->shelfNumber = $shelfNumber;
    }

    public function setShelfNumber(int $shelfNumber) {
        $this->shelfNumber = $shelfNumber;
    }

    public function takeBook() {
        print("Книгу можно получить по адресу: Красная площадь, дом 5\n");
        $this->readsCount = $this->readsCount + 1;
    }

    public function info() {
        print("Номер полки: {$this->shelfNumber}; Автор: {$this->authorName} {$this->authorSurname}; Назание: {$this->title}; Издатель: {$this->publisher}; Число прочтений: {$this->readsCount}.\n");
    }

}