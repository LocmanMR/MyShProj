<?php

//Класс Category - модель для работы с категориями товаров
class Category
{

    //Возвращает массив категорий для списка на сайте
    public static function getCategoriesList(): array
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, name FROM category WHERE status = "1" ORDER BY sort_order, name ASC');
        $i = 0;
        $categoryList = [];
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }
        return $categoryList;
    }

    //Возвращает массив категорий для списка в админпанели
    public static function getCategoriesListAdmin(): array
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, name, sort_order, status FROM category ORDER BY sort_order ASC');

        $categoryList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoryList;
    }

    //Удаляет категорию с заданным id
    public static function deleteCategoryById(int $id): bool
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM category WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    //Редактирование категории с заданным id
    public static function updateCategoryById(int $id, string $name, int $sortOrder, int $status): bool
    {
        $db = Db::getConnection();

        $sql = "UPDATE category
            SET 
                name = :name, 
                sort_order = :sort_order, 
                status = :status
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    //Возвращает категорию с указанным id
    public static function getCategoryById(int $id): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM category WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    //Возвращает текстое пояснение статуса для категории
    public static function getStatusText(int $status): string
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }

    //Добавляет новую категорию
    public static function createCategory(string $name, int $sortOrder, int $status): bool
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO category (name, sort_order, status) '
            . 'VALUES (:name, :sort_order, :status)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

}
