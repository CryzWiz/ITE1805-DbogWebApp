<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20.04.2017
 * Time: 13.11
 */
require_once(dirname(__DIR__, 1)."/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");


session_start();
unset($_SESSION['loginString']);

if(session_destroy()) {
    /**
     * If session is destroyed return the user to index.php
     * Added a $_GET value so we can display a message to the user
     * if we want
     */
    redirect("/index.php?loggedOut=true");
}