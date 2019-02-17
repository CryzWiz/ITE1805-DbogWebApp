<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 03.05.2017
 * Time: 11.20
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
require_once(dirname(__DIR__, 1) . "/support-classes/CommentsDTO.class.php");
//use Propel\Runtime\Propel;
/**
 * Class GetStats = PostsQuery.php, CommentsQuery.php
 *
 * This class should have been placed in its corresponding class file under generated-classes.
 * But is located here to make a clear separation on our files and the generated files.
 */
class GetStats {
    public static function getTopPosts(){
        $posts = PostsQuery::create()->addDescendingOrderByColumn('times_visited')->find();
        $topPosts = [];
        if(sizeof($posts) > 3){
            for($i = 0; $i < 3; $i++){
                array_push($topPosts, $posts[$i]);
            }
        }
        else {
            for($i = 0; $i < sizeof($posts); $i++){
                array_push($topPosts, $posts[$i]);
            }
        }

        return $topPosts;
    }

    public static function getTopPostsByComments(){
        $comments = new Propel\Runtime\Collection\ObjectCollection();
        $comments->setModel('CommentsDTO');

        $t = CommentsQuery::create()->find();
        $post_ids = [];
        $size = sizeof($t);
        $postTitlesAndPostComments = [];
        if($size > 0){
            for($i = 0; $i < sizeof($t); $i++){
                $temp = CommentsDTO::create($t[$i]);
                $comments->append($temp);
                if(!in_array($comments[$i]->toPost, $post_ids))
                    array_push($post_ids, $comments[$i]->toPost);
            }
            $postIdAndPostComments = [];
            for($i = 0; $i < sizeof($post_ids); $i++){
                $commentsNumber = 0;
                for($x = 0; $x < $size; $x++){
                    if($comments[$x]->toPost == $post_ids[$i]){
                        $commentsNumber = $commentsNumber + 1;
                    }
                }
                $temptwo = array('post_id'=>$post_ids[$i], 'comments' => $commentsNumber);
                array_push($postIdAndPostComments,$temptwo);
            }
            for($i = 0; $i < sizeof($postIdAndPostComments); $i++){
                $postTitle = PostsQuery::create()->findOneByPostId($postIdAndPostComments[$i]['post_id'])->getPostTitle();
                $tempthree = array('post_title'=>$postTitle, 'comments' => $postIdAndPostComments[$i]['comments']);
                array_push($postTitlesAndPostComments,$tempthree);
            }
        }


        return $postTitlesAndPostComments;
    }

    public static function getTopCommenters(){
        $comments = new Propel\Runtime\Collection\ObjectCollection();
        $comments->setModel('CommentsDTO');
        $CommentsDTO = new CommentsDTO;
        $t = CommentsQuery::create()->find();
        $user_ids = [];
        $size = sizeof($t);
        $postTitlesAndPostComments = [];
        if($size > 0) {
            for($i = 0; $i < sizeof($t); $i++){
                //$temp = CommentsDTO::create($t[$i]);

                $comments->append($CommentsDTO->create($t[$i]));
                if(!in_array($comments[$i]->madeByUser, $user_ids))
                    array_push($user_ids, $comments[$i]->madeByUser);
            }
            $postIdAndPostComments = [];
            for($i = 0; $i < sizeof($user_ids); $i++){
                $commentsNumber = 0;
                for($x = 0; $x < $size; $x++){
                    if($comments[$x]->madeByUser == $user_ids[$i]){
                        $commentsNumber = $commentsNumber + 1;
                    }
                }
                $temptwo = array('user_id'=>$user_ids[$i], 'comments' => $commentsNumber);
                array_push($postIdAndPostComments,$temptwo);
            }
            for($i = 0; $i < sizeof($postIdAndPostComments); $i++){
                $postTitle = UsersQuery::create()->findOneByEmail($postIdAndPostComments[$i]['user_id'])->getUserName();
                $tempthree = array('username'=>$postTitle, 'comments' => $postIdAndPostComments[$i]['comments']);
                array_push($postTitlesAndPostComments,$tempthree);
            }
        }

        return $postTitlesAndPostComments;
    }

    public static function getTotalViews(){
        $posts = PostsQuery::create()->find();
        $views = 0;
        for($i = 0; $i < sizeof($posts); $i++ ){
            $views = $views + $posts[$i]->getTimesVisited();
        }
        return $views;
    }

}