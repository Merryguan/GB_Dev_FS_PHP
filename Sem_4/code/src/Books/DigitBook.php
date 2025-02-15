<?php

namespace App\Hw\Books;

use App\Hw\Books\Book;

Class DigitBook extends Book {

    private string $url = "";

    public function getUrl(): string {
        return $this->url;
    }

    public function setUrl(string $url) {
        $this->url = $url;
    }

    public function takeBook() {
        print("Книгу можно скачать по адресу: {$this->url}\n");
        $this->readsCount = $this->readsCount + 1;
    }

    public function info() {
        print("Адрес: {$this->url}; Электронная. Автор: {$this->authorName} {$this->authorSurname}; Назание: {$this->title}; Издатель: {$this->publisher}; Число прочтений: {$this->readsCount}.\n");
    }

}