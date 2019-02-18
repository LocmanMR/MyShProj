<?php

class User
{
    //Добавл. данные из формы в БД
    public static function register($name, $email, $password): bool
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
            . ' VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }
    // Имя не меньше 2 символов
    public static function checkName($name): bool
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    // Пароль не меньше 6 символов
    public static function checkPassword($password): bool
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    // Проверяем email
    public static function checkEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function checkEmailExists($email): bool
    {
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email',$email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        } else{
            return false;
        }
    }
}
