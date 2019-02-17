<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19.04.2017
 * Time: 15.41
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Registration.class.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");
use Propel\Runtime\Propel;


class Login_class { // TODO class name should conventionally match filename
    /**
     * Logs the user in by checking the password
     */
    public static function login($email, $password){
        /**
         * Fetch stored password for this user
         */
        $user = UsersQuery::create()->findOneByEmail($email);
        if($user != null) {
            /**
             * First thing we do is check if the account is active
             */
            if ($user->getActive()) {
                /**
                 * If the stored password matches the given password
                 * We log the user in - setting some $_SESSION data for the user
                 */
                if (password_verify($password, $user->getPassword())) {
                    /**
                     * And if we could update the login times, we return the ok
                     */
                    if (self::update_logintime($email)) {
                        /**
                         * Start the session, but first we destroy the current session -> Probably not needed
                         */
                        session_destroy();
                        session_start();
                        //SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);
                        /**
                         * And we start by making a loginString witch we can use to check when the user
                         * navigates around our site -> If needed is another question. But added security
                         * The loginString is made from the user email, and the users current IP, and the users web-browser. Then we encrypt the result
                         * and store it to the session. Since we have the email on file, we'll know if someone is trying to
                         * access the user account from another IP, or another browser. Although this is taken care of in SessionManager
                         */
                        $_SESSION['loginString'] = password_hash($email . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'], PASSWORD_DEFAULT);
                        /**
                         * Set current time so we can log the user off on in-activity
                         * We set timeout at 30 min
                         */
                        $_SESSION['login_time'] = time();
                        /**
                         * Store the users email and role to the session data. Alternative information we might
                         * need can be accessed in the database as long as you have the email or userId
                         * For security reasons we should keep as little as possible in the session array
                         * that can identify the user or give access to someone who should'nt have access
                         * Although SESSION data is a lot more secure than cookies.
                         */
                        $_SESSION['usermail'] = $email;
                        $_SESSION['role'] = $user->getRole();

                        return true;

                    } else {
                        return false;
                    }

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Check the login by verifying the loginString
     */
    public static function check_login(){
        if(isset($_SESSION['usermail'], $_SESSION['loginString'], $_SESSION['login_time'])){
            /**
             * Variables that should be present in the session if logged in
             */
            $mail = $_SESSION['usermail'];
            $loginString = $_SESSION['loginString'];
            $login_time = $_SESSION['login_time'];
            /**
             * Current time minus 30 minutes
             * 30 minutes * 60 seconds
             */
            $current_time = time() - (30 * 60);
            /**
             * Verify the loginString
             */
            $verifyLoginString = password_verify($mail.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'], $loginString);
            /**
             * If the loginString is verified and $current_time - 30 min < $login_time
             */
            if($verifyLoginString == true && $current_time < $login_time){
                /**
                 * Update the login_time to current time
                 */
                $_SESSION['login_time'] = time();
                /**
                 * And finally return true
                 */
                return true;
            }
        }
        /**
         * else return false
         */
        else
            return false;
    }

    /**
     * Send the user a new password
     * Since we are using UIT's mail script we just send the user a new verification mail
     * and when he returns to the blog through it, we set the verification id as a new password
     */
    public static function generate_new_password($email){
        if(Registration_class::sendVerificationMail($email)){
            return true;
        }
        else {
            return false;
        }

    }

    /**
     * Update the login times in user_details table
     */
    function update_logintime($email){

        $con = Propel::getWriteConnection(\Map\UsersTableMap::DATABASE_NAME);
        $userdetails = UsersQuery::create()->findOneByEmail($email);
        $userdetails->setLastLogin($userdetails->getCurrentLogin());
        $userdetails->setCurrentLogin(date('Y/m/d H:i:s'));
        $con->beginTransaction();
        try {
            if ($userdetails->save() == 0) {
                $con->rollback();
                return false;
            }
            else {
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