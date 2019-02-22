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
}