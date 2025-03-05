<?php

namespace Geekbrains\Application1\Domain\Controllers;
use Geekbrains\Application1\Application\Render;

class PageController {

    public function actionIndex() {
        $render = new Render();
        
        if (isset($_SESSION["user_name"])) {
            $username = $_SESSION["user_name"];
        } else {
            $username = "";
        }

        return $render->renderPage(
            'page-index.twig', 
            [
                'title' => 'Главная страница',
                'menu' => [
                    'Пользователи' => '/user',
                    'Выход' => '/page/logout'
                ],
                'username' => $username
            ]);
    }
}