<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;

Class ErrorController {

    public function actionError() {
        $render = new Render();
        
        return $render->renderPage(
            'page-404.twig', 
            [
                'title' => 'Ошибка 404',
                'time' => date('H:i:s')
            ]);
    }

}