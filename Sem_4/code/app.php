<?php

namespace App\Hw\App;

use App\Hw\Books\Book;
use App\Hw\Books\RealBook;
use App\Hw\Books\DigitBook;
use App\Hw\Room\Room;
use App\Hw\Room\Shelf;
use App\Hw\Catalog\Catalog;

require_once __DIR__ . '/vendor/autoload.php';

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