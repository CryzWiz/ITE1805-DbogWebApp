<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 17.04.2017
 * Time: 19.25
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/CreateAdminDbTasks.class.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
use Propel\Runtime\Propel;
/**
 * This file is part of the five-some CreateAdminDbTasks.class.php,
 * create_admin.php, create_admin_action.php and create_admin.twig, create_admin.css.
 *
 * These files are not exactly part of the blog. They are supposed to work in that way
 * that if the database holds no data ( precisely site_activated and a user with role 2)
 * the user get routed though this and has to give up some basic information for the site.
 * Make a admin account, set site name, site mail, give up full name etc etc.
 *
 * Just a quick way to get the site running after a fresh installation -> But not developed
 * very far since its not part of the exercise. Just a very simple implementation. Probably
 * not bug free.
 */

$message = '';
$error = false;

if(isset($_POST['submit'])){
    switch($_POST['type']) {
        case 'reg_account':

            if (empty($_POST['email'])) { // No email entered
                $message .= "Ingen epost skrevet inn - ";
                $error = true;
            } else {
                if (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
                    && preg_match('/@.+\./', $_POST['email']))
                ) {
                    $message .= "Ugyldig epost skrevet inn - ";
                    $error = true;
                }
            }

            if (empty($_POST['password'])) { // NO PASSWORD ENTERED
                $message .= "Ingen passord skrevet inn! - ";
                $error = true;

            } else {
                if (empty($_POST['password2'])) { // NO SECOND PASSWORD ENTERED
                    $message .= "Du har ikke bekreftet passordet! - ";
                    $error = true;

                } elseif ($_POST['password'] != $_POST['password2']) { // PASSWORD DOES NOT MATCH
                    $message .= "Passordene du skrev inn stemmer ikke overrens! - ";
                    $error = true;

                } elseif (strlen($_POST['password']) < 6) { // PASSWORD TOO SHORT
                    $message .= "Passordet er for kort. MINIMUM 6 karakterer langt! - ";
                    $error = true;
                }
            }
            if (empty($_POST['fname'])) { // No firstname entered
                $message .= "Ingen fornavn skrevet inn - ";
                $error = true;
            }
            if (empty($_POST['lname'])) { // No lastname entered
                $message .= "Ingen etternavn skrevet inn - ";
                $error = true;
            }
            if (empty($_POST['username'])) { // No username entered
                $message .= "Ingen brukernavn skrevet inn - ";
                $error = true;
            }
            if (empty($_POST['email'])) { // No email entered
                $message .= "Klarte ikke fange opp eposten - ";
                $error = true;
            }

            if (!$error) { // NO ERRORS
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $username = $_POST['username'];
                $current_id = $_POST['current_id'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                CreateAdminDbTasks::CreateAdminAccount($fname, $lname, $username, $email, $password);

            } else { // THERE WERE ERRORS
                redirect("/controller/create_admin.php?step=1&&error=" . $error . "&&message=" . $message . "");
                exit();
            }
            break;

        case 'reg_sitesettings':

            if (empty($_POST['sitename'])) { // No sitename entered
                $message .= "Ingen nettstedsnavn skrevet inn - ";
                $error = true;
            }

            if (empty($_POST['bloggtitle'])) { // No bloggtitle entered
                $message .= "Ingen bloggtitle skrevet inn - ";
                $error = true;
            }
            if (empty($_POST['bloggsubtitle'])) { // No bloggsubtitle entered
                $message .= "Ingen bloggsubtitle skrevet inn - ";
                $error = true;
            }
            if (empty($_POST['email'])) { // No current_id entered
                $message .= "Klarte ikke å fange opp bruker eposten - ";
                $error = true;
            }

            if (!$error) { // NO ERRORS
                $site_name = $_POST['sitename'];
                $mail = $_POST['email'];
                $bloggtitle = $_POST['bloggtitle'];
                $bloggsubtitle = $_POST['bloggsubtitle'];
                $current_id = $_POST['current_id'];

                CreateAdminDbTasks::SetSiteSettings($site_name, $bloggtitle, $bloggsubtitle, $mail);

            } else { // THERE WERE ERRORS
                redirect("/controller/create_admin.php?step=2&&error=" . $error . "&&message=" . $message . "");
                exit();
            }

            break;
    }



}
