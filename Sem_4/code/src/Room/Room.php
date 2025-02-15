<?php

namespace App\Hw\Room;

use App\Hw\Room\Shelf;

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