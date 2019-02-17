<?php

namespace Base;

use \Posts as ChildPosts;
use \PostsQuery as ChildPostsQuery;
use \Exception;
use \PDO;
use Map\PostsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'posts' table.
 *
 * 
 *
 * @method     ChildPostsQuery orderByPostId($order = Criteria::ASC) Order by the post_id column
 * @method     ChildPostsQuery orderByPostTitle($order = Criteria::ASC) Order by the post_title column
 * @method     ChildPostsQuery orderByPostImageUrl($order = Criteria::ASC) Order by the post_image_url column
 * @method     ChildPostsQuery orderByPostDate($order = Criteria::ASC) Order by the post_date column
 * @method     ChildPostsQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildPostsQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPostsQuery orderByTimesVisited($order = Criteria::ASC) Order by the times_visited column
 * @method     ChildPostsQuery orderByPostText($order = Criteria::ASC) Order by the post_text column
 *
 * @method     ChildPostsQuery groupByPostId() Group by the post_id column
 * @method     ChildPostsQuery groupByPostTitle() Group by the post_title column
 * @method     ChildPostsQuery groupByPostImageUrl() Group by the post_image_url column
 * @method     ChildPostsQuery groupByPostDate() Group by the post_date column
 * @method     ChildPostsQuery groupByActive() Group by the active column
 * @method     ChildPostsQuery groupByUserId() Group by the user_id column
 * @method     ChildPostsQuery groupByTimesVisited() Group by the times_visited column
 * @method     ChildPostsQuery groupByPostText() Group by the post_text column
 *
 * @method     ChildPostsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPostsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPostsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPostsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPostsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPostsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPostsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildPostsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildPostsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildPostsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildPostsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildPostsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildPostsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildPostsQuery leftJoinComments($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comments relation
 * @method     ChildPostsQuery rightJoinComments($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comments relation
 * @method     ChildPostsQuery innerJoinComments($relationAlias = null) Adds a INNER JOIN clause to the query using the Comments relation
 *
 * @method     ChildPostsQuery joinWithComments($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comments relation
 *
 * @method     ChildPostsQuery leftJoinWithComments() Adds a LEFT JOIN clause and with to the query using the Comments relation
 * @method     ChildPostsQuery rightJoinWithComments() Adds a RIGHT JOIN clause and with to the query using the Comments relation
 * @method     ChildPostsQuery innerJoinWithComments() Adds a INNER JOIN clause and with to the query using the Comments relation
 *
 * @method     ChildPostsQuery leftJoinCommentsDeleted($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentsDeleted relation
 * @method     ChildPostsQuery rightJoinCommentsDeleted($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentsDeleted relation
 * @method     ChildPostsQuery innerJoinCommentsDeleted($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentsDeleted relation
 *
 * @method     ChildPostsQuery joinWithCommentsDeleted($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CommentsDeleted relation
 *
 * @method     ChildPostsQuery leftJoinWithCommentsDeleted() Adds a LEFT JOIN clause and with to the query using the CommentsDeleted relation
 * @method     ChildPostsQuery rightJoinWithCommentsDeleted() Adds a RIGHT JOIN clause and with to the query using the CommentsDeleted relation
 * @method     ChildPostsQuery innerJoinWithCommentsDeleted() Adds a INNER JOIN clause and with to the query using the CommentsDeleted relation
 *
 * @method     \UsersQuery|\CommentsQuery|\CommentsDeletedQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPosts findOne(ConnectionInterface $con = null) Return the first ChildPosts matching the query
 * @method     ChildPosts findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPosts matching the query, or a new ChildPosts object populated from the query conditions when no match is found
 *
 * @method     ChildPosts findOneByPostId(int $post_id) Return the first ChildPosts filtered by the post_id column
 * @method     ChildPosts findOneByPostTitle(string $post_title) Return the first ChildPosts filtered by the post_title column
 * @method     ChildPosts findOneByPostImageUrl(string $post_image_url) Return the first ChildPosts filtered by the post_image_url column
 * @method     ChildPosts findOneByPostDate(string $post_date) Return the first ChildPosts filtered by the post_date column
 * @method     ChildPosts findOneByActive(boolean $active) Return the first ChildPosts filtered by the active column
 * @method     ChildPosts findOneByUserId(string $user_id) Return the first ChildPosts filtered by the user_id column
 * @method     ChildPosts findOneByTimesVisited(int $times_visited) Return the first ChildPosts filtered by the times_visited column
 * @method     ChildPosts findOneByPostText(string $post_text) Return the first ChildPosts filtered by the post_text column *

 * @method     ChildPosts requirePk($key, ConnectionInterface $con = null) Return the ChildPosts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOne(ConnectionInterface $con = null) Return the first ChildPosts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPosts requireOneByPostId(int $post_id) Return the first ChildPosts filtered by the post_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByPostTitle(string $post_title) Return the first ChildPosts filtered by the post_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByPostImageUrl(string $post_image_url) Return the first ChildPosts filtered by the post_image_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByPostDate(string $post_date) Return the first ChildPosts filtered by the post_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByActive(boolean $active) Return the first ChildPosts filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByUserId(string $user_id) Return the first ChildPosts filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByTimesVisited(int $times_visited) Return the first ChildPosts filtered by the times_visited column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPosts requireOneByPostText(string $post_text) Return the first ChildPosts filtered by the post_text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPosts[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPosts objects based on current ModelCriteria
 * @method     ChildPosts[]|ObjectCollection findByPostId(int $post_id) Return ChildPosts objects filtered by the post_id column
 * @method     ChildPosts[]|ObjectCollection findByPostTitle(string $post_title) Return ChildPosts objects filtered by the post_title column
 * @method     ChildPosts[]|ObjectCollection findByPostImageUrl(string $post_image_url) Return ChildPosts objects filtered by the post_image_url column
 * @method     ChildPosts[]|ObjectCollection findByPostDate(string $post_date) Return ChildPosts objects filtered by the post_date column
 * @method     ChildPosts[]|ObjectCollection findByActive(boolean $active) Return ChildPosts objects filtered by the active column
 * @method     ChildPosts[]|ObjectCollection findByUserId(string $user_id) Return ChildPosts objects filtered by the user_id column
 * @method     ChildPosts[]|ObjectCollection findByTimesVisited(int $times_visited) Return ChildPosts objects filtered by the times_visited column
 * @method     ChildPosts[]|ObjectCollection findByPostText(string $post_text) Return ChildPosts objects filtered by the post_text column
 * @method     ChildPosts[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PostsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PostsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Posts', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPostsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPostsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPostsQuery) {
            return $criteria;
        }
        $query = new ChildPostsQuery();
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
     * @return ChildPosts|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PostsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPosts A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT post_id, post_title, post_image_url, post_date, active, user_id, times_visited, post_text FROM posts WHERE post_id = :p0';
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
            /** @var ChildPosts $obj */
            $obj = new ChildPosts();
            $obj->hydrate($row);
            PostsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPosts|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PostsTableMap::COL_POST_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PostsTableMap::COL_POST_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the post_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPostId(1234); // WHERE post_id = 1234
     * $query->filterByPostId(array(12, 34)); // WHERE post_id IN (12, 34)
     * $query->filterByPostId(array('min' => 12)); // WHERE post_id > 12
     * </code>
     *
     * @param     mixed $postId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPostId($postId = null, $comparison = null)
    {
        if (is_array($postId)) {
            $useMinMax = false;
            if (isset($postId['min'])) {
                $this->addUsingAlias(PostsTableMap::COL_POST_ID, $postId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postId['max'])) {
                $this->addUsingAlias(PostsTableMap::COL_POST_ID, $postId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_POST_ID, $postId, $comparison);
    }

    /**
     * Filter the query on the post_title column
     *
     * Example usage:
     * <code>
     * $query->filterByPostTitle('fooValue');   // WHERE post_title = 'fooValue'
     * $query->filterByPostTitle('%fooValue%', Criteria::LIKE); // WHERE post_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPostTitle($postTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_POST_TITLE, $postTitle, $comparison);
    }

    /**
     * Filter the query on the post_image_url column
     *
     * Example usage:
     * <code>
     * $query->filterByPostImageUrl('fooValue');   // WHERE post_image_url = 'fooValue'
     * $query->filterByPostImageUrl('%fooValue%', Criteria::LIKE); // WHERE post_image_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postImageUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPostImageUrl($postImageUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postImageUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_POST_IMAGE_URL, $postImageUrl, $comparison);
    }

    /**
     * Filter the query on the post_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPostDate('2011-03-14'); // WHERE post_date = '2011-03-14'
     * $query->filterByPostDate('now'); // WHERE post_date = '2011-03-14'
     * $query->filterByPostDate(array('max' => 'yesterday')); // WHERE post_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $postDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPostDate($postDate = null, $comparison = null)
    {
        if (is_array($postDate)) {
            $useMinMax = false;
            if (isset($postDate['min'])) {
                $this->addUsingAlias(PostsTableMap::COL_POST_DATE, $postDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postDate['max'])) {
                $this->addUsingAlias(PostsTableMap::COL_POST_DATE, $postDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_POST_DATE, $postDate, $comparison);
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
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PostsTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId('fooValue');   // WHERE user_id = 'fooValue'
     * $query->filterByUserId('%fooValue%', Criteria::LIKE); // WHERE user_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the times_visited column
     *
     * Example usage:
     * <code>
     * $query->filterByTimesVisited(1234); // WHERE times_visited = 1234
     * $query->filterByTimesVisited(array(12, 34)); // WHERE times_visited IN (12, 34)
     * $query->filterByTimesVisited(array('min' => 12)); // WHERE times_visited > 12
     * </code>
     *
     * @param     mixed $timesVisited The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByTimesVisited($timesVisited = null, $comparison = null)
    {
        if (is_array($timesVisited)) {
            $useMinMax = false;
            if (isset($timesVisited['min'])) {
                $this->addUsingAlias(PostsTableMap::COL_TIMES_VISITED, $timesVisited['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timesVisited['max'])) {
                $this->addUsingAlias(PostsTableMap::COL_TIMES_VISITED, $timesVisited['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_TIMES_VISITED, $timesVisited, $comparison);
    }

    /**
     * Filter the query on the post_text column
     *
     * Example usage:
     * <code>
     * $query->filterByPostText('fooValue');   // WHERE post_text = 'fooValue'
     * $query->filterByPostText('%fooValue%', Criteria::LIKE); // WHERE post_text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postText The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function filterByPostText($postText = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postText)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostsTableMap::COL_POST_TEXT, $postText, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPostsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(PostsTableMap::COL_USER_ID, $users->getEmail(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PostsTableMap::COL_USER_ID, $users->toKeyValue('PrimaryKey', 'Email'), $comparison);
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
     * @return $this|ChildPostsQuery The current query, for fluid interface
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
     * @return ChildPostsQuery The current query, for fluid interface
     */
    public function filterByComments($comments, $comparison = null)
    {
        if ($comments instanceof \Comments) {
            return $this
                ->addUsingAlias(PostsTableMap::COL_POST_ID, $comments->getToPost(), $comparison);
        } elseif ($comments instanceof ObjectCollection) {
            return $this
                ->useCommentsQuery()
                ->filterByPrimaryKeys($comments->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComments() only accepts arguments of type \Comments or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comments relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function joinComments($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comments');

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
            $this->addJoinObject($join, 'Comments');
        }

        return $this;
    }

    /**
     * Use the Comments relation Comments object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommentsQuery A secondary query class using the current class as primary query
     */
    public function useCommentsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComments($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comments', '\CommentsQuery');
    }

    /**
     * Filter the query by a related \CommentsDeleted object
     *
     * @param \CommentsDeleted|ObjectCollection $commentsDeleted the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostsQuery The current query, for fluid interface
     */
    public function filterByCommentsDeleted($commentsDeleted, $comparison = null)
    {
        if ($commentsDeleted instanceof \CommentsDeleted) {
            return $this
                ->addUsingAlias(PostsTableMap::COL_POST_ID, $commentsDeleted->getToPost(), $comparison);
        } elseif ($commentsDeleted instanceof ObjectCollection) {
            return $this
                ->useCommentsDeletedQuery()
                ->filterByPrimaryKeys($commentsDeleted->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommentsDeleted() only accepts arguments of type \CommentsDeleted or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CommentsDeleted relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function joinCommentsDeleted($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CommentsDeleted');

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
            $this->addJoinObject($join, 'CommentsDeleted');
        }

        return $this;
    }

    /**
     * Use the CommentsDeleted relation CommentsDeleted object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommentsDeletedQuery A secondary query class using the current class as primary query
     */
    public function useCommentsDeletedQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCommentsDeleted($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CommentsDeleted', '\CommentsDeletedQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPosts $posts Object to remove from the list of results
     *
     * @return $this|ChildPostsQuery The current query, for fluid interface
     */
    public function prune($posts = null)
    {
        if ($posts) {
            $this->addUsingAlias(PostsTableMap::COL_POST_ID, $posts->getPostId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the posts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PostsTableMap::clearInstancePool();
            PostsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PostsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PostsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PostsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PostsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PostsQuery
