<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController {

    public function actionIndex() {

        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'time' => date('H:i:s'),
                    'menu' => ['Главная' => '/'],
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'time' => date('H:i:s'),
                    'menu' => ['Главная' => '/'],
                    'users' => $users
                ]);
        }

    }

    public function actionSave() {

        $users = user::save($_REQUEST["name"], $_REQUEST["birthday"]);

        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-added.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'time' => date('H:i:s'),
                    'menu' => ['Главная' => '/'],
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-added.twig',
                [
                    'title' => 'Пользователь добавлен в хранилище',
                    'time' => date('H:i:s'),
                    'menu' => ['Главная' => '/'],
                    'users' => $users
                ]);
        }

    }

}