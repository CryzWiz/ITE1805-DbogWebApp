<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 02.05.2017
 * Time: 21.25
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SessionManager.class.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
use Propel\Runtime\Propel;
/**
 * Class PostManager = Posts.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class PostManager {

    public static function addOneVisit($postId){
        $post = PostsQuery::create()->findOneByPostId($postId);
        $post->setTimesVisited($post->getTimesVisited() + 1);
        $post->save();
    }
}