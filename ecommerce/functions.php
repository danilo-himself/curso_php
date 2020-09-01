<?php 

use \Hcode\Model\User;
use \Hcode\Model\Cart;

function formatPrice($vlprice)
{
    if(!$vlprice > 0) $vlprice = 0;
    
    return number_format($vlprice, 2, ",", ".");
}

function checkLogin($inadmin = true)
{
    return User::checkLogin($inadmin);
}


function getUserName()
{
    $user = User::getFromSession();     
    
    //var_dump($user);
    //exit;
    
    return $user->getdesperson();
}

function getCartNrQtd()
{
    $cart = Cart::getFromSession();
    
    $total = $cart->getProductsTotals();
    
    return $total["nrqtd"];
    
}

function getCartVlPrice()
{
    $cart = Cart::getFromSession();
    
    $total = $cart->getProductsTotals();
    
    return $total["vlprice"];
    
}

function formatDate($date)
{
    return date("d/m/Y", strtotime($date));
}

?>