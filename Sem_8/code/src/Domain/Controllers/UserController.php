<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController {

    protected array $actionsPermissions = [
        'actionIndex' => ['admin'],
        'actionCreate' => ['admin'],
        'actionSave' => ['admin'],
        'actionEdit' => ['admin'],
        'actionUpdate' => ['admin'],
        'actionDelete' => ['admin'],
        'actionHash' => ['unauthorized', 'admin'],
        'actionAuth' => ['unauthorized'],
        'actionLogin' => ['unauthorized', 'admin'],
        'actionLogout' => ['admin']
    ];

    public function actionIndex(): string {

        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'menu' => [
                        'Главная' => '/',
                        'Добавить пользователя' => '/user/create',
                        'Выход' => '/user/logout'
                    ],
                    'username' => $_SESSION["user_name"],
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'menu' => [
                        'Главная' => '/',
                        'Добавить пользователя' => '/user/create',
                        'Выход' => '/user/logout'
                        ],
                    'username' => $_SESSION["user_name"],
                    'users' => $users
                ]);
        }
    }

    public function actionCreate(): string {
        $render = new Render();
        
        return $render->renderPageWithForm(
                'user-form.twig', 
                [
                    'title' => 'Форма создания пользователя',
                    'menu' => [
                        'Главная' => '/',
                        'Пользователи' => '/user',
                        'Выход' => '/user/logout'
                    ],
                    'username' => $_SESSION["user_name"],
                    'method' => 'save'
                ]);
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
                    'menu' => [
                        'Главная' => '/',
                        'Пользователи' => '/user',
                        'Выход' => '/user/logout'
                    ],
                    'username' => $_SESSION["user_name"],
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]);
        }
        else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionEdit(): string {

        $result = User::getUserFromStorageById($_GET['id']);

        $render = new Render();
       
        return $render->renderPageWithForm(
                'user-form.twig', 
                [
                    'title' => 'Форма создания пользователя',
                    'method' => 'update',
                    'id' => $result->getUserId(),
                    'user_name' => $result->getUserName(),
                    'user_lastname' => $result->getUserLastname(),
                    'user_birthday' => date("d-m-Y", $result->getUserBirthday()),
                    'user_login' => $result->getUserLogin()
                ]);
    }

    public function actionUpdate(): string {
        
        if(User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->updateToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.twig', 
                [
                    'title' => 'Пользователь обновлен',
                    'menu' => [
                        'Главная' => '/',
                        'Пользователи' => '/user',
                        'Выход' => '/user/logout'
                    ],
                    'username' => $_SESSION["user_name"],
                    'message' => "Обновлен пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]);
        }
        else {
            throw new \Exception("Переданные данные некорректны");
        }
    }

    public function actionDelete(): string {
      
        $user = new User();
        $user->setUserId($_GET['id']);
        $user->DeleteFromStorage();

        $render = new Render();

        return $render->renderPage(
            'user-created.twig', 
            [
                'title' => 'Пользователь удален',
                'menu' => [
                    'Главная' => '/',
                    'Пользователи' => '/user',
                    'Выход' => '/user/logout'
                ],
                'username' => $_SESSION["user_name"],
                'message' => "Удален пользователь "
            ]);
        
    }

    public function actionAuth(): string {
        $render = new Render();
        
        return $render->renderPageWithForm(
                'user-auth.twig', 
                [
                    'title' => 'Форма логина'

                ]);
    }

    public function actionHash(): string {
        return Auth::getPasswordHash($_GET['pass_string']);
    }

    public function actionLogin(): string {

        $result = false;

        if(isset($_POST['login']) && isset($_POST['password'])){
            $result = Application::$auth->proceedAuthByLogin($_POST['login'], $_POST['password']);
        }
     
        if (!$result[0]) {
            $render = new Render();

            return $render->renderPageWithForm(
                'user-auth.twig', 
                [
                    'title' => 'Форма логина',
                    'auth_success' => false,
                    'auth_error' => $result[1]
                ]);
        } else {
            if (isset($_POST['remember-me']) && $_POST['remember-me'] == 'on') {
                Application::$auth->addCookie($_POST['login'], time() + 3600);
            }

            header('Location: /');
            return "";
        }
    }

    public function actionLogout() {

        Application::$auth->delCookie();
        session_unset();
        session_destroy();
        header("Location: /");

    }
}