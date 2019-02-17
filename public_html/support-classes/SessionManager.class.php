<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 18.04.2017
 * Time: 16.41
 *
 * Inspired and generated from url: http://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
 *
 * Using this to create secure php sessions for our users
 *  -- NOT IMPLEMENTED
 */
class SessionManager{
    static function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null){
        /**
         * Set cookie name
         */
        session_name($name.'_Session');
        /**
         * Set the domain to current domain
         */
        $domain = isset($domain) ? $domain : isset($_SERVER['SERVER_NAME']);

        /**
         * Set default secure value based on access protocol
         */
        $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);

        /**
         * Set cookie params and start the session
         */
        session_set_cookie_params($limit, $path, $domain, $secure, true);
        session_start();

        /**
         * Check if we have a valid session -> That means check if we have a valid session
         * and destroy it if we don't
         */
        if(self::validateSession()) {
            /**
             * Check if this is a new session or a hijacking
             */
            if(self::preventHijacking()) {
                /**
                 * Reset session data and regenerate session id
                 */
                $_SESSION = array();
                $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                self::regenerateSession();

                /**
                 * Give it a 25% chance of the session id to be changed
                 */
            }elseif(rand(1, 100) <= 25){
                self::regenerateSession();
            }
        }else{
            $_SESSION = array();
            session_destroy();
            session_start();
        }
    }

    static protected function preventHijacking(){
        /**
         * If we dont find a IP or userAgent
         */
        if(isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
            return false;
        /**
         * If IP does not match remote IP
         */
        if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
            return false;
        /**
         * If userAgent don't match HTTP_USER_AGENT
         */
        if($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            return false;
        /**
         * If all checks out, return true
         */
        return true;

    }

    static function regenerateSession() {
        /**
         * If this session is obsolete, there is already a new ID
         */
        if(isset($_SESSION['OBSOLETE']))
            return;
        /**
         * Set current session to expire in 10 sec
         */
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;
        /**
         * Create a new session without destroying the old one
         */
        session_regenerate_id(false);
        /**
         * Get the current session ID and close both sessions to allow
         * other scripts to use them
         */
        $newSession = session_id();
        session_write_close();
        /**
         * Set session ID to the new one and start it up again
         */
        session_id($newSession);
        session_start();
        /**
         * And finally unset the EXPIRATION value and OBSOLETE values
         */
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    static protected function validateSession(){
        /**
         * If session is obsolete or expired
         */
        if(isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']))
            return false;
        if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
            return false;
        /**
         * Else return true
         */
        return true;
    }




}