<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 01.05.2017
 * Time: 21.59
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
use Propel\Runtime\Propel;
/**
 * Class Mypage = Users.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class Mypage {

    /**
     * No checks are being made since we know this has to be a registered user
     * Just update the information and return true, unless something happens
     * when we update the DB.
     *
     * Regards:
     * update_userinfo(), updateUsername(), updateFirstname(), updateLastname(), updatePassword()
     */
    public static function update_userinfo($uname, $fname, $lname, $email){

        try{
            $user = UsersQuery::create()->findOneByEmail($email);
            $user->setFirstname($fname);
            $user->setLastname($lname);
            $user->setUserName($uname);
            $user->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }

    }

    public static function updateUsername($uname, $email){

        try{
            $user = UsersQuery::create()->findOneByEmail($email);
            $user->setUserName($uname);
            $user->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }
    }

    public static function updateLastname($lname, $email){

        try{
            $user = UsersQuery::create()->findOneByEmail($email);
            $user->setLastname($lname);
            $user->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }
    }

    public static function updateFirstname($fname, $email){

        try{
            $user = UsersQuery::create()->findOneByEmail($email);
            $user->setFirstname($fname);
            $user->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }
    }

    public static function updatePassword($passOne , $email){

        try {
            $user = UsersQuery::create()->findOneByEmail($email);
            $password = getPasswordHash($passOne);
            $user->setPassword($password);
            $user->save();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function changeAccountStatus($email){

        $user = UsersQuery::create()->findOneByEmail($email);
        try {
            if($user->getActive()){
                $user->setActive(false);
            }
            else {
                $user->setActive(true);
            }
            $user->save();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}