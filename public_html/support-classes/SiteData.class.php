<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 06.05.2017
 * Time: 13.21
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
use Propel\Runtime\Propel;

/**
 * Class SiteData = SiteSettings.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class SiteData {

    public static function updateSiteName($sitename, $email){

        try{
            $sitesettings = SitesettingsQuery::create()->findOneById(1);
            $sitesettings->setSiteName($sitename);
            $sitesettings->setByUser($email);
            $sitesettings->setUpdated(date('Y/m/d H:i:s'));
            $sitesettings->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }

    }

    public static function updateSiteTitle($sitetitle, $email){

        try{
            $sitesettings = SitesettingsQuery::create()->findOneById(1);
            $sitesettings->setSiteTitle($sitetitle);
            $sitesettings->setByUser($email);
            $sitesettings->setUpdated(date('Y/m/d H:i:s'));
            $sitesettings->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }

    }

    public static function updateSiteSubTitle($sitesubtitle, $email){

        try{
            $sitesettings = SitesettingsQuery::create()->findOneById(1);
            $sitesettings->setSiteSubtitle($sitesubtitle);
            $sitesettings->setByUser($email);
            $sitesettings->setUpdated(date('Y/m/d H:i:s'));
            $sitesettings->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }

    }

    public static function updateSiteMail($sitemail, $email){

        try{
            $sitesettings = SitesettingsQuery::create()->findOneById(1);
            $sitesettings->setSiteMail($sitemail);
            $sitesettings->setByUser($email);
            $sitesettings->setUpdated(date('Y/m/d H:i:s'));
            $sitesettings->save();
            return true;
        }
        catch(Exception $ex){
            return false;
        }

    }
}