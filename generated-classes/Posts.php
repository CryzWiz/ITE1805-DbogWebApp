<?php

use Base\Posts as BasePosts;

/**
 * Skeleton subclass for representing a row from the 'posts' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Posts extends BasePosts
{
	private $numberOfComments;

	public function getNumberOfComments(){
		if($this->numberOfComments != null){
			return $this->numberOfComments;
		}
		return $this->numberOfComments = sizeof(CommentsQuery::create()->findByToPost($this->post_id)->getData());
	}
}
