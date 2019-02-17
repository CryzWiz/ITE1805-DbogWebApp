<?php

namespace Base;

use \Comments as ChildComments;
use \CommentsQuery as ChildCommentsQuery;
use \Exception;
use \PDO;
use Map\CommentsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'comments' table.
 *
 * 
 *
 * @method     ChildCommentsQuery orderByCommentId($order = Criteria::ASC) Order by the comment_id column
 * @method     ChildCommentsQuery orderByToPost($order = Criteria::ASC) Order by the to_post column
 * @method     ChildCommentsQuery orderByToComment($order = Criteria::ASC) Order by the to_comment column
 * @method     ChildCommentsQuery orderByMadeByUser($order = Criteria::ASC) Order by the made_by_user column
 * @method     ChildCommentsQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildCommentsQuery orderByCommentMade($order = Criteria::ASC) Order by the comment_made column
 * @method     ChildCommentsQuery orderByActive($order = Criteria::ASC) Order by the active column
 *
 * @method     ChildCommentsQuery groupByCommentId() Group by the comment_id column
 * @method     ChildCommentsQuery groupByToPost() Group by the to_post column
 * @method     ChildCommentsQuery groupByToComment() Group by the to_comment column
 * @method     ChildCommentsQuery groupByMadeByUser() Group by the made_by_user column
 * @method     ChildCommentsQuery groupByComment() Group by the comment column
 * @method     ChildCommentsQuery groupByCommentMade() Group by the comment_made column
 * @method     ChildCommentsQuery groupByActive() Group by the active column
 *
 * @method     ChildCommentsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommentsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommentsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommentsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCommentsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCommentsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCommentsQuery leftJoinCommentsRelatedByToComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentsRelatedByToComment relation
 * @method     ChildCommentsQuery rightJoinCommentsRelatedByToComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentsRelatedByToComment relation
 * @method     ChildCommentsQuery innerJoinCommentsRelatedByToComment($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentsRelatedByToComment relation
 *
 * @method     ChildCommentsQuery joinWithCommentsRelatedByToComment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CommentsRelatedByToComment relation
 *
 * @method     ChildCommentsQuery leftJoinWithCommentsRelatedByToComment() Adds a LEFT JOIN clause and with to the query using the CommentsRelatedByToComment relation
 * @method     ChildCommentsQuery rightJoinWithCommentsRelatedByToComment() Adds a RIGHT JOIN clause and with to the query using the CommentsRelatedByToComment relation
 * @method     ChildCommentsQuery innerJoinWithCommentsRelatedByToComment() Adds a INNER JOIN clause and with to the query using the CommentsRelatedByToComment relation
 *
 * @method     ChildCommentsQuery leftJoinPosts($relationAlias = null) Adds a LEFT JOIN clause to the query using the Posts relation
 * @method     ChildCommentsQuery rightJoinPosts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Posts relation
 * @method     ChildCommentsQuery innerJoinPosts($relationAlias = null) Adds a INNER JOIN clause to the query using the Posts relation
 *
 * @method     ChildCommentsQuery joinWithPosts($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Posts relation
 *
 * @method     ChildCommentsQuery leftJoinWithPosts() Adds a LEFT JOIN clause and with to the query using the Posts relation
 * @method     ChildCommentsQuery rightJoinWithPosts() Adds a RIGHT JOIN clause and with to the query using the Posts relation
 * @method     ChildCommentsQuery innerJoinWithPosts() Adds a INNER JOIN clause and with to the query using the Posts relation
 *
 * @method     ChildCommentsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildCommentsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildCommentsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildCommentsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildCommentsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildCommentsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildCommentsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildCommentsQuery leftJoinCommentsRelatedByCommentId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentsRelatedByCommentId relation
 * @method     ChildCommentsQuery rightJoinCommentsRelatedByCommentId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentsRelatedByCommentId relation
 * @method     ChildCommentsQuery innerJoinCommentsRelatedByCommentId($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentsRelatedByCommentId relation
 *
 * @method     ChildCommentsQuery joinWithCommentsRelatedByCommentId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CommentsRelatedByCommentId relation
 *
 * @method     ChildCommentsQuery leftJoinWithCommentsRelatedByCommentId() Adds a LEFT JOIN clause and with to the query using the CommentsRelatedByCommentId relation
 * @method     ChildCommentsQuery rightJoinWithCommentsRelatedByCommentId() Adds a RIGHT JOIN clause and with to the query using the CommentsRelatedByCommentId relation
 * @method     ChildCommentsQuery innerJoinWithCommentsRelatedByCommentId() Adds a INNER JOIN clause and with to the query using the CommentsRelatedByCommentId relation
 *
 * @method     \CommentsQuery|\PostsQuery|\UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComments findOne(ConnectionInterface $con = null) Return the first ChildComments matching the query
 * @method     ChildComments findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComments matching the query, or a new ChildComments object populated from the query conditions when no match is found
 *
 * @method     ChildComments findOneByCommentId(int $comment_id) Return the first ChildComments filtered by the comment_id column
 * @method     ChildComments findOneByToPost(int $to_post) Return the first ChildComments filtered by the to_post column
 * @method     ChildComments findOneByToComment(int $to_comment) Return the first ChildComments filtered by the to_comment column
 * @method     ChildComments findOneByMadeByUser(string $made_by_user) Return the first ChildComments filtered by the made_by_user column
 * @method     ChildComments findOneByComment(string $comment) Return the first ChildComments filtered by the comment column
 * @method     ChildComments findOneByCommentMade(string $comment_made) Return the first ChildComments filtered by the comment_made column
 * @method     ChildComments findOneByActive(boolean $active) Return the first ChildComments filtered by the active column *

 * @method     ChildComments requirePk($key, ConnectionInterface $con = null) Return the ChildComments by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOne(ConnectionInterface $con = null) Return the first ChildComments matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComments requireOneByCommentId(int $comment_id) Return the first ChildComments filtered by the comment_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByToPost(int $to_post) Return the first ChildComments filtered by the to_post column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByToComment(int $to_comment) Return the first ChildComments filtered by the to_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByMadeByUser(string $made_by_user) Return the first ChildComments filtered by the made_by_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByComment(string $comment) Return the first ChildComments filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByCommentMade(string $comment_made) Return the first ChildComments filtered by the comment_made column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComments requireOneByActive(boolean $active) Return the first ChildComments filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComments[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComments objects based on current ModelCriteria
 * @method     ChildComments[]|ObjectCollection findByCommentId(int $comment_id) Return ChildComments objects filtered by the comment_id column
 * @method     ChildComments[]|ObjectCollection findByToPost(int $to_post) Return ChildComments objects filtered by the to_post column
 * @method     ChildComments[]|ObjectCollection findByToComment(int $to_comment) Return ChildComments objects filtered by the to_comment column
 * @method     ChildComments[]|ObjectCollection findByMadeByUser(string $made_by_user) Return ChildComments objects filtered by the made_by_user column
 * @method     ChildComments[]|ObjectCollection findByComment(string $comment) Return ChildComments objects filtered by the comment column
 * @method     ChildComments[]|ObjectCollection findByCommentMade(string $comment_made) Return ChildComments objects filtered by the comment_made column
 * @method     ChildComments[]|ObjectCollection findByActive(boolean $active) Return ChildComments objects filtered by the active column
 * @method     ChildComments[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommentsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CommentsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Comments', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommentsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommentsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommentsQuery) {
            return $criteria;
        }
        $query = new ChildCommentsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildComments|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommentsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CommentsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComments A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT comment_id, to_post, to_comment, made_by_user, comment, comment_made, active FROM comments WHERE comment_id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildComments $obj */
            $obj = new ChildComments();
            $obj->hydrate($row);
            CommentsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildComments|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the comment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentId(1234); // WHERE comment_id = 1234
     * $query->filterByCommentId(array(12, 34)); // WHERE comment_id IN (12, 34)
     * $query->filterByCommentId(array('min' => 12)); // WHERE comment_id > 12
     * </code>
     *
     * @param     mixed $commentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByCommentId($commentId = null, $comparison = null)
    {
        if (is_array($commentId)) {
            $useMinMax = false;
            if (isset($commentId['min'])) {
                $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $commentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($commentId['max'])) {
                $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $commentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $commentId, $comparison);
    }

    /**
     * Filter the query on the to_post column
     *
     * Example usage:
     * <code>
     * $query->filterByToPost(1234); // WHERE to_post = 1234
     * $query->filterByToPost(array(12, 34)); // WHERE to_post IN (12, 34)
     * $query->filterByToPost(array('min' => 12)); // WHERE to_post > 12
     * </code>
     *
     * @see       filterByPosts()
     *
     * @param     mixed $toPost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByToPost($toPost = null, $comparison = null)
    {
        if (is_array($toPost)) {
            $useMinMax = false;
            if (isset($toPost['min'])) {
                $this->addUsingAlias(CommentsTableMap::COL_TO_POST, $toPost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toPost['max'])) {
                $this->addUsingAlias(CommentsTableMap::COL_TO_POST, $toPost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_TO_POST, $toPost, $comparison);
    }

    /**
     * Filter the query on the to_comment column
     *
     * Example usage:
     * <code>
     * $query->filterByToComment(1234); // WHERE to_comment = 1234
     * $query->filterByToComment(array(12, 34)); // WHERE to_comment IN (12, 34)
     * $query->filterByToComment(array('min' => 12)); // WHERE to_comment > 12
     * </code>
     *
     * @see       filterByCommentsRelatedByToComment()
     *
     * @param     mixed $toComment The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByToComment($toComment = null, $comparison = null)
    {
        if (is_array($toComment)) {
            $useMinMax = false;
            if (isset($toComment['min'])) {
                $this->addUsingAlias(CommentsTableMap::COL_TO_COMMENT, $toComment['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toComment['max'])) {
                $this->addUsingAlias(CommentsTableMap::COL_TO_COMMENT, $toComment['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_TO_COMMENT, $toComment, $comparison);
    }

    /**
     * Filter the query on the made_by_user column
     *
     * Example usage:
     * <code>
     * $query->filterByMadeByUser('fooValue');   // WHERE made_by_user = 'fooValue'
     * $query->filterByMadeByUser('%fooValue%', Criteria::LIKE); // WHERE made_by_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $madeByUser The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByMadeByUser($madeByUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($madeByUser)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_MADE_BY_USER, $madeByUser, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%', Criteria::LIKE); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the comment_made column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentMade('2011-03-14'); // WHERE comment_made = '2011-03-14'
     * $query->filterByCommentMade('now'); // WHERE comment_made = '2011-03-14'
     * $query->filterByCommentMade(array('max' => 'yesterday')); // WHERE comment_made > '2011-03-13'
     * </code>
     *
     * @param     mixed $commentMade The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByCommentMade($commentMade = null, $comparison = null)
    {
        if (is_array($commentMade)) {
            $useMinMax = false;
            if (isset($commentMade['min'])) {
                $this->addUsingAlias(CommentsTableMap::COL_COMMENT_MADE, $commentMade['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($commentMade['max'])) {
                $this->addUsingAlias(CommentsTableMap::COL_COMMENT_MADE, $commentMade['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentsTableMap::COL_COMMENT_MADE, $commentMade, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE active = true
     * $query->filterByActive('yes'); // WHERE active = true
     * </code>
     *
     * @param     boolean|string $active The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommentsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query by a related \Comments object
     *
     * @param \Comments|ObjectCollection $comments The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByCommentsRelatedByToComment($comments, $comparison = null)
    {
        if ($comments instanceof \Comments) {
            return $this
                ->addUsingAlias(CommentsTableMap::COL_TO_COMMENT, $comments->getCommentId(), $comparison);
        } elseif ($comments instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentsTableMap::COL_TO_COMMENT, $comments->toKeyValue('PrimaryKey', 'CommentId'), $comparison);
        } else {
            throw new PropelException('filterByCommentsRelatedByToComment() only accepts arguments of type \Comments or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CommentsRelatedByToComment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function joinCommentsRelatedByToComment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CommentsRelatedByToComment');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CommentsRelatedByToComment');
        }

        return $this;
    }

    /**
     * Use the CommentsRelatedByToComment relation Comments object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommentsQuery A secondary query class using the current class as primary query
     */
    public function useCommentsRelatedByToCommentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCommentsRelatedByToComment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CommentsRelatedByToComment', '\CommentsQuery');
    }

    /**
     * Filter the query by a related \Posts object
     *
     * @param \Posts|ObjectCollection $posts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByPosts($posts, $comparison = null)
    {
        if ($posts instanceof \Posts) {
            return $this
                ->addUsingAlias(CommentsTableMap::COL_TO_POST, $posts->getPostId(), $comparison);
        } elseif ($posts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentsTableMap::COL_TO_POST, $posts->toKeyValue('PrimaryKey', 'PostId'), $comparison);
        } else {
            throw new PropelException('filterByPosts() only accepts arguments of type \Posts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Posts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function joinPosts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Posts');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Posts');
        }

        return $this;
    }

    /**
     * Use the Posts relation Posts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostsQuery A secondary query class using the current class as primary query
     */
    public function usePostsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPosts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Posts', '\PostsQuery');
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(CommentsTableMap::COL_MADE_BY_USER, $users->getEmail(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentsTableMap::COL_MADE_BY_USER, $users->toKeyValue('PrimaryKey', 'Email'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\UsersQuery');
    }

    /**
     * Filter the query by a related \Comments object
     *
     * @param \Comments|ObjectCollection $comments the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommentsQuery The current query, for fluid interface
     */
    public function filterByCommentsRelatedByCommentId($comments, $comparison = null)
    {
        if ($comments instanceof \Comments) {
            return $this
                ->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $comments->getToComment(), $comparison);
        } elseif ($comments instanceof ObjectCollection) {
            return $this
                ->useCommentsRelatedByCommentIdQuery()
                ->filterByPrimaryKeys($comments->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommentsRelatedByCommentId() only accepts arguments of type \Comments or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CommentsRelatedByCommentId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function joinCommentsRelatedByCommentId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CommentsRelatedByCommentId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CommentsRelatedByCommentId');
        }

        return $this;
    }

    /**
     * Use the CommentsRelatedByCommentId relation Comments object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommentsQuery A secondary query class using the current class as primary query
     */
    public function useCommentsRelatedByCommentIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCommentsRelatedByCommentId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CommentsRelatedByCommentId', '\CommentsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildComments $comments Object to remove from the list of results
     *
     * @return $this|ChildCommentsQuery The current query, for fluid interface
     */
    public function prune($comments = null)
    {
        if ($comments) {
            $this->addUsingAlias(CommentsTableMap::COL_COMMENT_ID, $comments->getCommentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the comments table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommentsTableMap::clearInstancePool();
            CommentsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommentsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CommentsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CommentsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommentsQuery
