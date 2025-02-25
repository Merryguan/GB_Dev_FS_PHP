<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;

class UserController {

    public function actionIndex(): string {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'menu' => [
                                'Главная' => '/'
                              ],
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'menu' => [
                                'Главная' => '/'
                            ],
                    'users' => $users
                ]);
        }
    }

    public function actionSave(): string {
        if(User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.twig', 
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]);
        }
        else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionUpdate(): string {
        if(User::exists($_GET['id'])) {
            $user = new User();
            $user->setUserId($_GET['id']);
            
            $arrayData = [];

            if(isset($_GET['name']))
                $arrayData['user_name'] = $_GET['name'];

            if(isset($_GET['lastname'])) {
                $arrayData['user_lastname'] = $_GET['lastname'];
            }
            $arrayData['id_user'] = $_GET['id'];

            $user->updateUser($arrayData);
        }
        else {
            throw new \Exception("Пользователь не существует");
        }

        $render = new Render();
        return $render->renderPage(
            'user-created.twig', 
            [
                'title' => 'Пользователь обновлен',
                'menu' => [
                            'Главная' => '/',
                            'Пользователи' => '/user'
                            ],
                'message' => "Обновлен пользователь " . $user->getUserId()
            ]);
    }

    public function actionDelete(): string {

        if(User::exists($_GET['id'])) {
            User::deleteFromStorage($_GET['id']);

            $render = new Render();
            
            return $render->renderPage(
                'user-removed.twig',[]
            );
        }
        else {
            throw new \Exception("Пользователь не существует");
        }

    }

    public function actionShow() {
        
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

        if (User::exists($id)) {
            $user = User::getUserFromStorageById($id);
            $render = new Render();
            return $render->renderPage(
                'user-show.twig',
                [
                    'title' => 'Информация о пользователе',
                    'menu' => [
                                'Главная' => '/',
                                'Пользователи' => '/user'
                                ],
                    'user' => $user
                ]);
        } else {
            throw new \Exception("Пользователь не существует");
        }
    }
    
}