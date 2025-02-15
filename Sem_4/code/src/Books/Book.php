<?php

namespace App\Hw\Books;

abstract Class Book {

    protected string $authorName;
    protected string $authorSurname;
    protected string $title;
    protected string $publisher;
    protected int $readsCount;

    public function __construct(string $authorName, string $authorSurname, string $title, string $publisher) {
        $this->authorName = $authorName;
        $this->authorSurname = $authorSurname;
        $this->title = $title;
        $this->publisher = $publisher;
        $this->readsCount = 0;
    }

    public function setReadsCount(int $number) {
        $this->readsCount = $number;
    }

    public function getReadsCount(): int {
        return $readsCount;
    }

    abstract public function takeBook();

    abstract public function info();

}