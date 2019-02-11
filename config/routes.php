<?php
return [

    'news/([0-9]+)' => 'news/view/$1', //actionView в NewsController
    'news' => 'news/index', // actionIndex в NewsController
    /*
    'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',

    'news/([0-9]+)' => 'news/view',

    'news' => 'news/index',          //actionIndex v NewsController
    'products' => 'products/list',   //actionList v ProductController
    */
];