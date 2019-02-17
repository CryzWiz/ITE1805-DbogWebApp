<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20.04.2017
 * Time: 22.24
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Registration.class.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");
/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);
/**
 * Register a new user in the database and generate a json response for the ajax-script
 */
if(isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'register_user':
            if (isset($_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputFirstname'],
                $_POST['inputLastname'], $_POST['inputUsername'])) {
                $didWeGetStored = Registration_class::register_user($_POST['inputUsername'],
                    $_POST['inputFirstname'],
                    $_POST['inputLastname'],
                    $_POST['inputEmail'],
                    $_POST['inputPassword']);
                if ($didWeGetStored == true) {
                    $message = 'Du er registrert - Sjekk epost for verifikasjonsmail!';
                    $data = new stdClass();
                    $data->success = 'true';
                    $data->message = $message;
                    echo json_encode($data);
                }
                else {
                    // The correct POST variables were not sent to this page.
                    $message = 'Registrering mislyktes.';
                    $data = new stdClass();
                    $data->success = 'false';
                    $data->message = $message;
                    echo json_encode($data);
                }
            }
            else {
                // The correct POST variables were not sent to this page.
                $message = 'Mottok mangelfulle opplysninger!';
                $data = new stdClass();
                $data->success = 'false';
                $data->message = $message;
                echo json_encode($data);
            }
            break;
    }
}
else {
    // The correct POST variables were not sent to this page.
    $message = 'Mottok mangelfulle opplysninger!';
    $data = new stdClass();
    $data->success = 'false';
    $data->message = $message;
    echo json_encode($data);
}