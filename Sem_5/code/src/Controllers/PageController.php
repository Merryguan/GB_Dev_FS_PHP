<?php

namespace Geekbrains\Application1\Controllers;
use Geekbrains\Application1\Render;

class PageController {

    public function actionIndex() {
        $render = new Render();
        
        return $render->renderPage(
            'page-index.twig', 
            [
                'title' => 'Главная страница',
                'time' => date('H:i:s', time() + 3 * 60 * 60),
                'menu' => ['Пользователи' => '/user']
            ]);
    }
    
}