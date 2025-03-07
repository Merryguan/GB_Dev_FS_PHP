<?php

namespace Geekbrains\Application1\Application;

class Auth {
    public static function getPasswordHash(string $rawPassword): string {
        return password_hash($_GET['pass_string'], PASSWORD_BCRYPT);
    }

    public function addCookie(string $login, int $expires) {

        $sql = "UPDATE users SET user_cookie=:cookieid WHERE login = :login";

        $coockieid = bin2hex(random_bytes(32));

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(
            [
                'cookieid' => $coockieid,
                'login' => $login
            ]);

        setcookie('ID', $coockieid, $expires, '/');
        
    }

    public function delCookie() {

        $sql = "UPDATE users SET user_cookie=:cookieid WHERE id_user = :id";

        $coockieid = bin2hex(random_bytes(32));

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(
            [
                'cookieid' => $coockieid,
                'id' => $_SESSION["id_user"]
            ]);

        setcookie('ID', "", time() - 3600, '/');
        
    }

    public function proceedAuthByCookie(string $coockie): bool {
        
        $sql = "SELECT id_user, user_name, user_lastname FROM users WHERE user_cookie = :id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $coockie]);
        $result = $handler->fetch();

        if (!empty($result)) {
            //$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_lastname'] = $result['user_lastname'];
            $_SESSION['id_user'] = $result['id_user'];
           
            return true;
        } else {
            return false;
        }

    }

    public function proceedAuthByLogin(string $login, string $password): array {

        $sql = "SELECT id_user, user_name, user_lastname, password_hash FROM users WHERE login = :login";

        if (empty($login) || empty($password)) {
            $logMessage = "Был отправлен пустой логин или пароль." . " ";
            $logMessage = $logMessage . "Попытка вызова адреса: " . $_SERVER['REQUEST_URI'];
            Application::$logger->error($logMessage);
            return [false, "Введите логин или пароль"];
        }

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['login' => $login]);
        $result = $handler->fetch();

        if (empty($result)) {
            $logMessage = "Был отправлен неверный логин." . " ";
            $logMessage = $logMessage . "Попытка вызова адреса: " . $_SERVER['REQUEST_URI'] . " ";
            $logMessage = $logMessage . "Логин: " . $login;
            Application::$logger->error($logMessage);
            return [false, "Неверный логин"];
        }

        $result_login = password_verify($password, $result['password_hash']);
        if (!$result_login) {
            $logMessage = "Был отправлен неверный пароль." . " ";
            $logMessage = $logMessage . "Попытка вызова адреса: " . $_SERVER['REQUEST_URI'] . " ";
            $logMessage = $logMessage . "Пароль: " . $password;
            Application::$logger->error($logMessage);
            return [false, "Неверный пароль"];
        }

        if (!empty($result) && $result_login) {
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_lastname'] = $result['user_lastname'];
            $_SESSION['id_user'] = $result['id_user'];
            
            return [true, "Успех"];
        }
    }

}