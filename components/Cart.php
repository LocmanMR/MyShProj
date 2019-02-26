<?php

Class Cart
{
    public static function addProduct($id): int
    {
        $id = intval($id);
        $productsInCart = [];

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            $productsInCart[$id] = 1;
        }

        // Записываем массив с товарами в сессию
        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }
    //Считает количество товаров в сессии
    public static function countItems(): int
    {
        if (isset ($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    public static function getTotalPrice($products): int
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();

        // Подсчитываем общую стоимость
        $total = 0;
        if ($productsInCart) {
            // Если в корзине не пусто
            // Проходим по переданному в метод массиву товаров
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }

    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    public static function deleteProduct($id)
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();

        // Удаляем из массива элемент с указанным id
        unset($productsInCart[$id]);

        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;
    }
}