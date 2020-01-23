<?php
include_once "config.php";

function secure_session()
{
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], ".code-end.ro", $cookieParams["secure"]=true, $cookieParams["httponly"]=true);
    session_name('ce-secure');
    session_start();
}