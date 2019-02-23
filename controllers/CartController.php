<?php

class CartController
{

    public function actionAdd($id)
    {
        Cart::addProduct($id);
        //Возвращаем пользователя на тсраницу
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function actionAddAjax($id): bool
    {
        //Добавляем товар в корзину
        echo Cart::addProduct($id);
        return true;
    }

    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $productsInCart = false;
        //получаем данные из корзины
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            //Получаем полную информцию о товарах
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            //Общая стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT.'/views/cart/index.php');
    }
}