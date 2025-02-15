<?php

abstract Class Book {

    protected string $authorName;
    protected string $authorSurname;
    protected string $title;
    protected string $publisher;
    protected int $readsCount = 0;

    public function __construct(string $authorName, string $authorSurname, string $title, string $publisher) {
        $this->authorName = $authorName;
        $this->authorSurname = $authorSurname;
        $this->title = $title;
        $this->publisher = $publisher;
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

Class Room {
    
    private $shelfs = [];

    public function addShelf(Shelf $shelf) {
        $this->shelfs[] = $shelf;
    }

    public function getShelf(int $number) {
        return $this->shelfs[$number - 1];
    }

    public function info() {
        print("Фонды:\n");
        foreach ($this->shelfs as $i => $value) {
            $this->shelfs[$i]->info();
        }
    }

}

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

$catalog = new Catalog();
$catalog->addBook(new RealBook("Михаил", "Булгаков", "Собачье сердце", "Литрес"));
$catalog->getBook(1)->setReadsCount(4);
$catalog->addBook(new RealBook("Ник", "Перумов", "Алмазный Меч, Деревянный Меч. Том 1", "Литрес"));
$catalog->getBook(2)->setReadsCount(10);
$catalog->addBook(new RealBook("Уильям", "Гибсон", "Нейромант (сборник)", "Литрес"));
$catalog->getBook(3)->setReadsCount(24);
$catalog->addBook(new RealBook("Михаил", "Булгаков", "Мастер и Маргорита", "Литрес"));
$catalog->getBook(4)->setReadsCount(14);
$catalog->addBook(new RealBook("Айзек", "Азимов", "Академия. Начало", "Литрес"));
$catalog->getBook(5)->setReadsCount(8);
$catalog->addBook(new DigitBook("Михаил", "Булгаков", "Собачье сердце", "Литрес"));
$catalog->getBook(6)->setReadsCount(5);
$catalog->addBook(new DigitBook("Михаил", "Булгаков", "Мастер и Маргорита", "Литрес"));
$catalog->getBook(7)->setReadsCount(1);
$library = new Room();
$library->addShelf(new Shelf(1));
$library->addShelf(new Shelf(2));
$library->addShelf(new Shelf(3));
$library->addShelf(new Shelf(4));
$catalog->putBookOnShelf($catalog->getBook(1), $library->getShelf(1));
$catalog->putBookOnShelf($catalog->getBook(2), $library->getShelf(2));
$catalog->putBookOnShelf($catalog->getBook(3), $library->getShelf(3));
$catalog->putBookOnShelf($catalog->getBook(4), $library->getShelf(4));
$catalog->putBookOnShelf($catalog->getBook(5), $library->getShelf(2));
$catalog->putBookOnSite($catalog->getBook(6), "https://library.com/1");
$catalog->putBookOnSite($catalog->getBook(7), "https://library.com/2");
$catalog->printCatalog();
$library->info();
$catalog->getBook(3)->takeBook();
$catalog->getBook(6)->takeBook();
$catalog->printCatalog();
/*var_dump($library);*/