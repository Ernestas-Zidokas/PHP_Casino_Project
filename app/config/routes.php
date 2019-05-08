<?php

\Core\Page\Router::addRoute('/about', '\App\Controller\About');
\Core\Page\Router::addRoute('/login', '\App\Controller\Login');
\Core\Page\Router::addRoute('/register', '\App\Controller\Register');
\Core\Page\Router::addRoute('/logout', '\App\Controller\Logout');
\Core\Page\Router::addRoute('/home', '\App\Controller\Home');
\Core\Page\Router::addRoute('/cash-in', '\App\Controller\CashIn');
\Core\Page\Router::addRoute('/dice', '\App\Controller\Dice');
\Core\Page\Router::addRoute('/slotMachine3x3', '\App\Controller\SlotMachine3x3');
\Core\Page\Router::addRoute('/slotMachine5x3', '\App\Controller\SlotMachine5x3');
\Core\Page\Router::addRoute('/blackjack', '\App\Controller\BlackJack');



