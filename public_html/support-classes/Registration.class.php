<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20.04.2017
 * Time: 22.27
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
use Propel\Runtime\Propel;

/**
 * Class Registration_class = Users.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class Registration_class{

    public static function register_user($username, $firstname, $lastname, $email, $password){
        /**
         * Registering the user
         *
         */
        if(self::putUserTable($username, $firstname, $lastname, $email, $password)){
            /**
             * If we could store to the UserTable
             */
            if(self::sendVerificationMail($email)){
                /**
                 * And we could send the verification mail
                 */
                return true;
            }
            /**
             * But if we could not send mail
             */
            else{
                return false;
            }
        }
        /**
         * Or store to the UsersTable
         */
        else{
            return false;
        }
    }

    /**
     * Register the basic user data
     */
    public static function putUserTable($username, $firstname, $lastname, $email, $password){
        $result = false;
        /**
         * Check if email is present already
         */
        if(self::checkUniqueEmail($email)){

            $con = Propel::getWriteConnection(\Map\UsersTableMap::DATABASE_NAME);

            $user = new Users();

            $user->setEmail($email);
            $user->setPassword(getPasswordHash($password));
            $user->setRole(1);
            $user->setActive(0);
            $user->setValidated(0);
            $user->setRegDate(date('Y/m/d H:i:s'));
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUserName($username);

            $con->beginTransaction();

            try{
                //Internal errors:
                if($user->save() == 0) {
                    $con->rollback();
                    $result = false;
                }
                else{
                    $con->commit();
                    $result = true;
                }
            }
            catch(Exception $ex){
                $con->rollback();
                $result = false;
            }
        }

        return $result;

    }

    /**
     * Check if this is a new email
     */
    public static function checkUniqueEmail($email){
        if(UsersQuery::create()->findOneByEmail($email)){
            return false;
        }
        else{
            return true;
        }
    }

    public static function sendVerificationMail($email){
        /**
         * Setting some variables we'll need
         */
        $userId = $email;
        $url = $GLOBALS['server_url'] . $GLOBALS['user_dir'] . $GLOBALS['prj_dir']."/controller/verify_mail.php";

        /**
         * Mailer script provided by the school
         * - We just added the $email, $url variables from our site
         */
        // create a new cURL resource
        $ch = curl_init();
        // set URL and other appropriate options
        $id = md5(uniqid(rand(), 1));

        $areWeStored = self::storeVerificationMailToDb($userId, $id);

        if($areWeStored == true) {
            curl_setopt($ch, CURLOPT_URL, "http://kark.uit.no/internett/php/mailer/mailer.php?address=" . $email . "&url=" . $url . "?id=" . $id);
            //curl_setopt($ch, CURLOPT_URL, "http://www.dagbladet.no/");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // grab URL and pass it to the browser
            $output = curl_exec($ch);
            /**
             * Mailer script provided by the school ends here
             */
            return true;
        }
        else{
            return false;
        }
    }
    public static function storeVerificationMailToDb($userId, $id){
        /**
         * Store the Validation mail details to the database
         */
        $con = Propel::getWriteConnection(\Map\ValidationLinkTableMap::DATABASE_NAME);
        $verification = new ValidationLink();
        $verification->setValidationId($id);
        $verification->setUserId($userId);
        $verification->setCreated(date('Y/m/d H:i:s'));
        $con->beginTransaction();
        try{
            //Internal errors:
            if($verification->save() == 0) {
                $con->rollback();
                return false;
            }
            else{
                $con->commit();
                return true;
            }
        }
        catch(Exception $ex){
            $con->rollback();
            return false;
        }
    }
}