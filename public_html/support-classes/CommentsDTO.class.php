<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 03.05.2017
 * Time: 12.01
 */
use Propel\Runtime\Propel;
require_once(dirname(__DIR__, 1) . "/global_init.php");

/**
 * Class CommentsDTO
 * Support class for comments
 */
class CommentsDTO implements Serializable{
    public $commentId;
    public $toPost;
    public $toComment;
    public $madeByUser;
    public $commentContent;
    public $commentMade;


    public function __construct()
    {

    }

    public static function create(Comments $comment)
    {
        $CommentsDTO = new CommentsDTO();
        if ($comment == null)
            return $CommentsDTO;

        $CommentsDTO->commentId = $comment->getCommentId();
        $CommentsDTO->toPost = $comment->getToPost();
        $CommentsDTO->toComment = $comment->getToComment();
        $CommentsDTO->madeByUser = $comment->getMadeByUser();
        $CommentsDTO->commentContent = $comment->getComment();
        $CommentsDTO->commentMade = $comment->getCommentMade();


        return $CommentsDTO;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->commentId = $data['commentId'];
        $this->toPost = $data['toPost'];
        $this->toComment = $data['toComment'];
        $this->madeByUser = $data['madeByUser'];
        $this->commentContent = $data['commentContent'];
        $this->commentMade = $data['$commentMade'];


    }

    public function toArray()
    {

        $result = array(
            'commentId' => $this->commentId,
            'toPost' => $this->toPost,
            'toComment' => $this->toComment,
            'madeByUser' => $this->madeByUser,
            'commentContent' => $this->commentContent,
            '$commentMade' => $this->commentMade
        );

        return $result;
    }

    public static function getphpName()
    {
        return 'CommentsDTO';
    }
}



