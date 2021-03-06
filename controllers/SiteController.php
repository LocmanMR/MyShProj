<?php

class SiteController
{
    public function actionIndex(): bool
    {
        //Список категорий
        $categories = [];
        $categories = Category::getCategoriesList();

        //список для послдених товаров
        $latestProducts = [];
        $latestProducts = Product::getLatestProducts(3);

        //список для товаров из слайдера
        $sliderProducts = Product::getRecommendedProducts();

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    public function actionContact()
    {
        $userEmail = false;
        $userText = false;
        $result = false;

        if (isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                // Отправляем письмо администратору
                $adminEmail = '';//Почта администратора
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }
        require_once(ROOT . '/views/site/contact.php');
        return true;
    }
    //Страница о Магазине
    public function actionAbout()
    {
        // Подключаем вид
        require_once(ROOT . '/views/site/about.php');
        return true;
    }
}