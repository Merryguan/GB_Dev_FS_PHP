<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User {

    private ?string $userName;
    private ?string $userLastName;
    private ?int $userBirthday;
    private ?string $userLogin;
    private ?int $idUser;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, string $lastName = null, int $birthday = null, string $Login = null, int $id_user = null) {
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->userLogin = $Login;
        $this->idUser = $id_user;
    }

    public function setUserId(int $id_user): void {
        $this->idUser = $id_user;
    }

    public function getUserId(): ?int {
        return $this->idUser;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function setLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public function getUserLogin(): ?string {
        return $this->userLogin;
    }

    public static function getAllUsersFromStorage(): array {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach($result as $item){
            $user = new User($item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp'], $item['login'], $item['id_user']);
            $users[] = $user;
        }
        
        return $users;
    }

    public static function validateRequestData(): bool{
        $result = true;
        
        if(!(
            isset($_POST['name']) && !empty($_POST['name']) &&
            isset($_POST['lastname']) && !empty($_POST['lastname']) &&
            isset($_POST['birthday']) && !empty($_POST['birthday'])
        )){
            $result = false;
        }

        if (preg_match('/<[(^>)]+>/', $_POST['name']) || 
            preg_match('/<[(^>)]+>/', $_POST['lastname']) || 
            preg_match('/<[(^>)]+>/', $_POST['login'])
        ) {
            $result = false;
        }

        if(!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])){
            $result =  false;
        }

        if(!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $result = false;
        }

        return $result;
    }

    public function setParamsFromRequestData(): void {
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->setBirthdayFromString($_POST['birthday']);
        $this->userLogin = htmlspecialchars($_POST['login']);
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $this->idUser = $_POST['id'];
        }
    }

    public function saveToStorage() {

        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp, login) VALUES (:user_name, :user_lastname, :user_birthday, :user_login)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday,
            'user_login' => $this->userLogin
        ]);

    }

    public function updateToStorage(){
        
        $sql = "UPDATE users SET user_name=:user_name, user_lastname=:user_lastname, user_birthday_timestamp=:user_birthday, login=:user_login WHERE id_user=:id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday,
            'user_login' => $this->userLogin,
            'id' => $this->idUser
        ]);
    }

    public function deleteFromStorage(){
        
        $sql = "DELETE FROM users WHERE id_user=:id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id' => $this->idUser
        ]);
    }

    public static function getUserFromStorageById(int $id): User {
        
        $sql = 'SELECT user_name, user_lastname, user_birthday_timestamp, login, id_user FROM users WHERE id_user = :id';

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $id]);

        $result = $handler->fetch();
        return new User(
            $result['user_name'],
            $result['user_lastname'],
            $result['user_birthday_timestamp'],
            $result['login'],
            $result['id_user']);

    }

}