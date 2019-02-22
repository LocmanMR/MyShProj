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
        echo '<pre>';
        print_r($_SESSION['products']);
        die();
    }

}