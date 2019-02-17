<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19.04.2017
 * Time: 16.30
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Login.class.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");
use Propel\Runtime\Propel;
/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);

/**
 * Log the user in and generate a json response for the ajax-script
 */
if(isset($_POST['type'])){
    switch($_POST['type']){
        case 'login':
            if (isset($_POST['inputEmail'], $_POST['inputPassword'])) {
                $email = $_POST['inputEmail'];
                $password = $_POST['inputPassword'];
                /**
                 * First we check if the user entered a valid email and password
                 */
                if (Login_class::login($email, $password)) {
                    $message = 'Innlogging var vellykket!';
                    $success = true;
                    $data = new stdClass();
                    $data->success='true';
                    $data->message=$message;
                    echo json_encode($data);


                } else {
                    /**
                     * If the user did not pass the pass & email check we don't care which one
                     * the user failed, and we don't want to give a possible attacker any hints
                     * - so we simply just stop right here and return false
                     */
                    $message = 'Innlogging feilet!';
                    $success = false;
                    $data = new stdClass();
                    $data->success='false';
                    $data->message=$message;
                    echo json_encode($data);
                }
            } else {
                /**
                 * By some reason earlier checks did not stop this from being sent
                 * without all demanded input-fields filled
                 */
                $message = 'Mottok mangelfulle opplysninger!';
                $success = false;
                $data = ['success '=> '', 'message' => $message];
                echo json_encode($data);
            }
            break;
        case 'generate_new_password':
            if (isset($_POST['inputEmail'])) {
                $email = $_POST['inputEmail'];
                /**
                 * If we could send the user a new password on mail
                 */
                if (Login_class::generate_new_password($email)) {
                    $message = 'Ny bekreftelsesmail sendt på mail.';
                    $success = true;
                    $data = new stdClass();
                    $data->success = 'true';
                    $data->message = $message;
                    echo json_encode($data);


                } else {
                    /**
                     * We could not send the new verification-mail
                     */
                    $message = 'Generering av nytt passord feilet';
                    $success = false;
                    $data = new stdClass();
                    $data->success = 'false';
                    $data->message = $message;
                    echo json_encode($data);
                }
            }
            break;

    }
}

