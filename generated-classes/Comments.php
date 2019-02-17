<?php

use Base\Comments as BaseComments;

/**
 * Skeleton subclass for representing a row from the 'comments' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Comments extends BaseComments
{
    private $replies;

    public function getReplies(){
        if($this->replies != null){
            return $this->replies;
        } else if($this->comment_id != null) {
            return $this->replies = CommentsQuery::create()->findByToComment($this->comment_id);
        } else {
            return $this->replies = array();
        }
    }

    public function setReplies(array $comments){
        $this->replies = $comments;
    }
}
