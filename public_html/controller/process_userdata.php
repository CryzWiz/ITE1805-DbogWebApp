<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 01.05.2017
 * Time: 21.51
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Mypage.class.php");

if ( isset( $_POST['type'] ) ) {

    switch ($_POST['type']) {

        case 'updateFirstName':
            $result = false;
            if(isset($_POST['fname'])  && isset($_POST['email'])){
                $fname = $_POST['fname'];
                $email = $_POST['email'];
                $result = Mypage::updateFirstname($fname, $email);
            }

            else {
                $responceMessage = 'Fornavn manglet.';
            }


            $res = new stdClass();
            if($result){
                $res->message='Oppdateringen var vellykket!';
                $res->success='true';
            }
            else{
                $res->message=$responceMessage;
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'updateLastName':
            $result = false;
            if(isset($_POST['lname'])  && isset($_POST['email'])){
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $result = Mypage::updateLastname($lname, $email);
            }

            else {
                $responceMessage = 'Etternavn manglet.';
            }

            $res = new stdClass();
            if($result){
                $res->message='Oppdateringen var vellykket!';
                $res->success='true';
            }
            else{
                $res->message=$responceMessage;
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'updateUsername':
            $result = false;
            if(isset($_POST['uname'])  && isset($_POST['email'])){
                $uname = $_POST['uname'];
                $email = $_POST['email'];
                $result = Mypage::updateUsername($uname, $email);
            }

            else {
                $responceMessage = 'Brukernavn manglet.';
            }

            $res = new stdClass();

            if($result){
                $res->message='Oppdateringen var vellykket!';
                $res->success='true';
            }
            else{
                $res->message=$responceMessage;
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'updatePassword':
            $result = false;
            if(isset($_POST['passOne']) && isset($_POST['passTwo']) && isset($_POST['email'])){
                $passOne = $_POST['passOne'];
                $passTwo = $_POST['passTwo'];
                $email = $_POST['email'];
                if($passOne == $passTwo && strlen($passOne) > 5)
                    $result = Mypage::updatePassword($passOne, $email);
                else
                    $responceMessage = 'Passordene matchet ikke, eller var for kort. Minimum 6 tegn.';
            }

            else {
                $responceMessage = 'Brukernavn manglet.';
            }

            $res = new stdClass();

            if($result){
                $res->message='Oppdateringen var vellykket!';
                $res->success='true';
            }
            else{
                $res->message=$responceMessage;
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'deactivateAccount':
            $res = new stdClass();
            $result = Mypage::changeAccountStatus($_POST['email']);
            if($result){
                $res->message='Kontoen er deaktivert!';
                $res->success='true';
            }
            else{
                $res->message='Noe gikk galt... Kontoen er fremdeles aktiv.';
                $res->success='false';
            }
            echo  json_encode($res);
            break;
        case 'activateAccount':
            $res = new stdClass();
            $result = Mypage::changeAccountStatus($_POST['email']);
            if($result){
                $res->message='Kontoen er aktivert!!';
                $res->success='true';
            }
            else{
                $res->message='Noe gikk galt... Kontoen er fremdeles deaktivert.';
                $res->success='false';
            }
            echo  json_encode($res);
            break;

    }
}
