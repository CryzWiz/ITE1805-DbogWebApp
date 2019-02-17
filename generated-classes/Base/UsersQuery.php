<?php

namespace Base;

use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \Exception;
use \PDO;
use Map\UsersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 * 
 *
 * @method     ChildUsersQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUsersQuery orderByRegDate($order = Criteria::ASC) Order by the reg_date column
 * @method     ChildUsersQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUsersQuery orderByRole($order = Criteria::ASC) Order by the role column
 * @method     ChildUsersQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildUsersQuery orderByValidated($order = Criteria::ASC) Order by the validated column
 * @method     ChildUsersQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildUsersQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildUsersQuery orderByUserName($order = Criteria::ASC) Order by the user_name column
 * @method     ChildUsersQuery orderByCurrentLogin($order = Criteria::ASC) Order by the current_login column
 * @method     ChildUsersQuery orderByLastLogin($order = Criteria::ASC) Order by the last_login column
 *
 * @method     ChildUsersQuery groupByEmail() Group by the email column
 * @method     ChildUsersQuery groupByRegDate() Group by the reg_date column
 * @method     ChildUsersQuery groupByPassword() Group by the password column
 * @method     ChildUsersQuery groupByRole() Group by the role column
 * @method     ChildUsersQuery groupByActive() Group by the active column
 * @method     ChildUsersQuery groupByValidated() Group by the validated column
 * @method     ChildUsersQuery groupByFirstname() Group by the firstname column
 * @method     ChildUsersQuery groupByLastname() Group by the lastname column
 * @method     ChildUsersQuery groupByUserName() Group by the user_name column
 * @method     ChildUsersQuery groupByCurrentLogin() Group by the current_login column
 * @method     ChildUsersQuery groupByLastLogin() Group by the last_login column
 *
 * @method     ChildUsersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUsersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUsersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUsersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUsersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUsersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUsersQuery leftJoinComments($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comments relation
 * @method     ChildUsersQuery rightJoinComments($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comments relation
 * @method     ChildUsersQuery innerJoinComments($relationAlias = null) Adds a INNER JOIN clause to the query using the Comments relation
 *
 * @method     ChildUsersQuery joinWithComments($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comments relation
 *
 * @method     ChildUsersQuery leftJoinWithComments() Adds a LEFT JOIN clause and with to the query using the Comments relation
 * @method     ChildUsersQuery rightJoinWithComments() Adds a RIGHT JOIN clause and with to the query using the Comments relation
 * @method     ChildUsersQuery innerJoinWithComments() Adds a INNER JOIN clause and with to the query using the Comments relation
 *
 * @method     ChildUsersQuery leftJoinCommentsDeleted($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentsDeleted relation
 * @method     ChildUsersQuery rightJoinCommentsDeleted($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentsDeleted relation
 * @method     ChildUsersQuery innerJoinCommentsDeleted($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentsDeleted relation
 *
 * @method     ChildUsersQuery joinWithCommentsDeleted($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CommentsDeleted relation
 *
 * @method     ChildUsersQuery leftJoinWithCommentsDeleted() Adds a LEFT JOIN clause and with to the query using the CommentsDeleted relation
 * @method     ChildUsersQuery rightJoinWithCommentsDeleted() Adds a RIGHT JOIN clause and with to the query using the CommentsDeleted relation
 * @method     ChildUsersQuery innerJoinWithCommentsDeleted() Adds a INNER JOIN clause and with to the query using the CommentsDeleted relation
 *
 * @method     ChildUsersQuery leftJoinPosts($relationAlias = null) Adds a LEFT JOIN clause to the query using the Posts relation
 * @method     ChildUsersQuery rightJoinPosts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Posts relation
 * @method     ChildUsersQuery innerJoinPosts($relationAlias = null) Adds a INNER JOIN clause to the query using the Posts relation
 *
 * @method     ChildUsersQuery joinWithPosts($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Posts relation
 *
 * @method     ChildUsersQuery leftJoinWithPosts() Adds a LEFT JOIN clause and with to the query using the Posts relation
 * @method     ChildUsersQuery rightJoinWithPosts() Adds a RIGHT JOIN clause and with to the query using the Posts relation
 * @method     ChildUsersQuery innerJoinWithPosts() Adds a INNER JOIN clause and with to the query using the Posts relation
 *
 * @method     ChildUsersQuery leftJoinSitesettings($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sitesettings relation
 * @method     ChildUsersQuery rightJoinSitesettings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sitesettings relation
 * @method     ChildUsersQuery innerJoinSitesettings($relationAlias = null) Adds a INNER JOIN clause to the query using the Sitesettings relation
 *
 * @method     ChildUsersQuery joinWithSitesettings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sitesettings relation
 *
 * @method     ChildUsersQuery leftJoinWithSitesettings() Adds a LEFT JOIN clause and with to the query using the Sitesettings relation
 * @method     ChildUsersQuery rightJoinWithSitesettings() Adds a RIGHT JOIN clause and with to the query using the Sitesettings relation
 * @method     ChildUsersQuery innerJoinWithSitesettings() Adds a INNER JOIN clause and with to the query using the Sitesettings relation
 *
 * @method     ChildUsersQuery leftJoinValidationLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the ValidationLink relation
 * @method     ChildUsersQuery rightJoinValidationLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ValidationLink relation
 * @method     ChildUsersQuery innerJoinValidationLink($relationAlias = null) Adds a INNER JOIN clause to the query using the ValidationLink relation
 *
 * @method     ChildUsersQuery joinWithValidationLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ValidationLink relation
 *
 * @method     ChildUsersQuery leftJoinWithValidationLink() Adds a LEFT JOIN clause and with to the query using the ValidationLink relation
 * @method     ChildUsersQuery rightJoinWithValidationLink() Adds a RIGHT JOIN clause and with to the query using the ValidationLink relation
 * @method     ChildUsersQuery innerJoinWithValidationLink() Adds a INNER JOIN clause and with to the query using the ValidationLink relation
 *
 * @method     \CommentsQuery|\CommentsDeletedQuery|\PostsQuery|\SitesettingsQuery|\ValidationLinkQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUsers findOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query
 * @method     ChildUsers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUsers matching the query, or a new ChildUsers object populated from the query conditions when no match is found
 *
 * @method     ChildUsers findOneByEmail(string $email) Return the first ChildUsers filtered by the email column
 * @method     ChildUsers findOneByRegDate(string $reg_date) Return the first ChildUsers filtered by the reg_date column
 * @method     ChildUsers findOneByPassword(string $password) Return the first ChildUsers filtered by the password column
 * @method     ChildUsers findOneByRole(int $role) Return the first ChildUsers filtered by the role column
 * @method     ChildUsers findOneByActive(boolean $active) Return the first ChildUsers filtered by the active column
 * @method     ChildUsers findOneByValidated(boolean $validated) Return the first ChildUsers filtered by the validated column
 * @method     ChildUsers findOneByFirstname(string $firstname) Return the first ChildUsers filtered by the firstname column
 * @method     ChildUsers findOneByLastname(string $lastname) Return the first ChildUsers filtered by the lastname column
 * @method     ChildUsers findOneByUserName(string $user_name) Return the first ChildUsers filtered by the user_name column
 * @method     ChildUsers findOneByCurrentLogin(string $current_login) Return the first ChildUsers filtered by the current_login column
 * @method     ChildUsers findOneByLastLogin(string $last_login) Return the first ChildUsers filtered by the last_login column *

 * @method     ChildUsers requirePk($key, ConnectionInterface $con = null) Return the ChildUsers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers requireOneByEmail(string $email) Return the first ChildUsers filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByRegDate(string $reg_date) Return the first ChildUsers filtered by the reg_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByPassword(string $password) Return the first ChildUsers filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByRole(int $role) Return the first ChildUsers filtered by the role column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByActive(boolean $active) Return the first ChildUsers filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByValidated(boolean $validated) Return the first ChildUsers filtered by the validated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByFirstname(string $firstname) Return the first ChildUsers filtered by the firstname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByLastname(string $lastname) Return the first ChildUsers filtered by the lastname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByUserName(string $user_name) Return the first ChildUsers filtered by the user_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByCurrentLogin(string $current_login) Return the first ChildUsers filtered by the current_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByLastLogin(string $last_login) Return the first ChildUsers filtered by the last_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUsers objects based on current ModelCriteria
 * @method     ChildUsers[]|ObjectCollection findByEmail(string $email) Return ChildUsers objects filtered by the email column
 * @method     ChildUsers[]|ObjectCollection findByRegDate(string $reg_date) Return ChildUsers objects filtered by the reg_date column
 * @method     ChildUsers[]|ObjectCollection findByPassword(string $password) Return ChildUsers objects filtered by the password column
 * @method     ChildUsers[]|ObjectCollection findByRole(int $role) Return ChildUsers objects filtered by the role column
 * @method     ChildUsers[]|ObjectCollection findByActive(boolean $active) Return ChildUsers objects filtered by the active column
 * @method     ChildUsers[]|ObjectCollection findByValidated(boolean $validated) Return ChildUsers objects filtered by the validated column
 * @method     ChildUsers[]|ObjectCollection findByFirstname(string $firstname) Return ChildUsers objects filtered by the firstname column
 * @method     ChildUsers[]|ObjectCollection findByLastname(string $lastname) Return ChildUsers objects filtered by the lastname column
 * @method     ChildUsers[]|ObjectCollection findByUserName(string $user_name) Return ChildUsers objects filtered by the user_name column
 * @method     ChildUsers[]|ObjectCollection findByCurrentLogin(string $current_login) Return ChildUsers objects filtered by the current_login column
 * @method     ChildUsers[]|ObjectCollection findByLastLogin(string $last_login) Return ChildUsers objects filtered by the last_login column
 * @method     ChildUsers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UsersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UsersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Users', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUsersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUsersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUsersQuery) {
            return $criteria;
        }
        $query = new ChildUsersQuery();
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UsersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUsers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT email, reg_date, password, role, active, validated, firstname, lastname, user_name, current_login, last_login FROM users WHERE email = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUsers $obj */
            $obj = new ChildUsers();
            $obj->hydrate($row);
            UsersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsersTableMap::COL_EMAIL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsersTableMap::COL_EMAIL, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the reg_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRegDate('2011-03-14'); // WHERE reg_date = '2011-03-14'
     * $query->filterByRegDate('now'); // WHERE reg_date = '2011-03-14'
     * $query->filterByRegDate(array('max' => 'yesterday')); // WHERE reg_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $regDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByRegDate($regDate = null, $comparison = null)
    {
        if (is_array($regDate)) {
            $useMinMax = false;
            if (isset($regDate['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_REG_DATE, $regDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regDate['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_REG_DATE, $regDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_REG_DATE, $regDate, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the role column
     *
     * Example usage:
     * <code>
     * $query->filterByRole(1234); // WHERE role = 1234
     * $query->filterByRole(array(12, 34)); // WHERE role IN (12, 34)
     * $query->filterByRole(array('min' => 12)); // WHERE role > 12
     * </code>
     *
     * @param     mixed $role The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (is_array($role)) {
            $useMinMax = false;
            if (isset($role['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_ROLE, $role['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($role['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_ROLE, $role['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_ROLE, $role, $comparison);
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsersTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the validated column
     *
     * Example usage:
     * <code>
     * $query->filterByValidated(true); // WHERE validated = true
     * $query->filterByValidated('yes'); // WHERE validated = true
     * </code>
     *
     * @param     boolean|string $validated The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByValidated($validated = null, $comparison = null)
    {
        if (is_string($validated)) {
            $validated = in_array(strtolower($validated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsersTableMap::COL_VALIDATED, $validated, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the user_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUserName('fooValue');   // WHERE user_name = 'fooValue'
     * $query->filterByUserName('%fooValue%', Criteria::LIKE); // WHERE user_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByUserName($userName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_USER_NAME, $userName, $comparison);
    }

    /**
     * Filter the query on the current_login column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrentLogin('2011-03-14'); // WHERE current_login = '2011-03-14'
     * $query->filterByCurrentLogin('now'); // WHERE current_login = '2011-03-14'
     * $query->filterByCurrentLogin(array('max' => 'yesterday')); // WHERE current_login > '2011-03-13'
     * </code>
     *
     * @param     mixed $currentLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByCurrentLogin($currentLogin = null, $comparison = null)
    {
        if (is_array($currentLogin)) {
            $useMinMax = false;
            if (isset($currentLogin['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_CURRENT_LOGIN, $currentLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($currentLogin['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_CURRENT_LOGIN, $currentLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_CURRENT_LOGIN, $currentLogin, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin('2011-03-14'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin('now'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin(array('max' => 'yesterday')); // WHERE last_login > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByLastLogin($lastLogin = null, $comparison = null)
    {
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_LAST_LOGIN, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_LAST_LOGIN, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_LAST_LOGIN, $lastLogin, $comparison);
    }

    /**
     * Filter the query by a related \Comments object
     *
     * @param \Comments|ObjectCollection $comments the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByComments($comments, $comparison = null)
    {
        if ($comments instanceof \Comments) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_EMAIL, $comments->getMadeByUser(), $comparison);
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
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
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByCommentsDeleted($commentsDeleted, $comparison = null)
    {
        if ($commentsDeleted instanceof \CommentsDeleted) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_EMAIL, $commentsDeleted->getMadeByUser(), $comparison);
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
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
     * Filter the query by a related \Posts object
     *
     * @param \Posts|ObjectCollection $posts the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPosts($posts, $comparison = null)
    {
        if ($posts instanceof \Posts) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_EMAIL, $posts->getUserId(), $comparison);
        } elseif ($posts instanceof ObjectCollection) {
            return $this
                ->usePostsQuery()
                ->filterByPrimaryKeys($posts->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
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
     * Filter the query by a related \Sitesettings object
     *
     * @param \Sitesettings|ObjectCollection $sitesettings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterBySitesettings($sitesettings, $comparison = null)
    {
        if ($sitesettings instanceof \Sitesettings) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_EMAIL, $sitesettings->getByUser(), $comparison);
        } elseif ($sitesettings instanceof ObjectCollection) {
            return $this
                ->useSitesettingsQuery()
                ->filterByPrimaryKeys($sitesettings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySitesettings() only accepts arguments of type \Sitesettings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sitesettings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinSitesettings($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sitesettings');

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
            $this->addJoinObject($join, 'Sitesettings');
        }

        return $this;
    }

    /**
     * Use the Sitesettings relation Sitesettings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SitesettingsQuery A secondary query class using the current class as primary query
     */
    public function useSitesettingsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSitesettings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sitesettings', '\SitesettingsQuery');
    }

    /**
     * Filter the query by a related \ValidationLink object
     *
     * @param \ValidationLink|ObjectCollection $validationLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByValidationLink($validationLink, $comparison = null)
    {
        if ($validationLink instanceof \ValidationLink) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_EMAIL, $validationLink->getUserId(), $comparison);
        } elseif ($validationLink instanceof ObjectCollection) {
            return $this
                ->useValidationLinkQuery()
                ->filterByPrimaryKeys($validationLink->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByValidationLink() only accepts arguments of type \ValidationLink or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ValidationLink relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinValidationLink($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ValidationLink');

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
            $this->addJoinObject($join, 'ValidationLink');
        }

        return $this;
    }

    /**
     * Use the ValidationLink relation ValidationLink object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ValidationLinkQuery A secondary query class using the current class as primary query
     */
    public function useValidationLinkQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinValidationLink($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ValidationLink', '\ValidationLinkQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUsers $users Object to remove from the list of results
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function prune($users = null)
    {
        if ($users) {
            $this->addUsingAlias(UsersTableMap::COL_EMAIL, $users->getEmail(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UsersTableMap::clearInstancePool();
            UsersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UsersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UsersTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UsersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UsersQuery
