<?php

namespace Base;

use \Sitesettings as ChildSitesettings;
use \SitesettingsQuery as ChildSitesettingsQuery;
use \Exception;
use Map\SitesettingsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sitesettings' table.
 *
 * 
 *
 * @method     ChildSitesettingsQuery orderBySiteName($order = Criteria::ASC) Order by the site_name column
 * @method     ChildSitesettingsQuery orderBySiteTitle($order = Criteria::ASC) Order by the site_title column
 * @method     ChildSitesettingsQuery orderBySiteSubtitle($order = Criteria::ASC) Order by the site_subtitle column
 * @method     ChildSitesettingsQuery orderByUpdated($order = Criteria::ASC) Order by the updated column
 * @method     ChildSitesettingsQuery orderByByUser($order = Criteria::ASC) Order by the by_user column
 * @method     ChildSitesettingsQuery orderBySiteMail($order = Criteria::ASC) Order by the site_mail column
 * @method     ChildSitesettingsQuery orderBySiteActivated($order = Criteria::ASC) Order by the site_activated column
 * @method     ChildSitesettingsQuery orderById($order = Criteria::ASC) Order by the _id column
 *
 * @method     ChildSitesettingsQuery groupBySiteName() Group by the site_name column
 * @method     ChildSitesettingsQuery groupBySiteTitle() Group by the site_title column
 * @method     ChildSitesettingsQuery groupBySiteSubtitle() Group by the site_subtitle column
 * @method     ChildSitesettingsQuery groupByUpdated() Group by the updated column
 * @method     ChildSitesettingsQuery groupByByUser() Group by the by_user column
 * @method     ChildSitesettingsQuery groupBySiteMail() Group by the site_mail column
 * @method     ChildSitesettingsQuery groupBySiteActivated() Group by the site_activated column
 * @method     ChildSitesettingsQuery groupById() Group by the _id column
 *
 * @method     ChildSitesettingsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSitesettingsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSitesettingsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSitesettingsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSitesettingsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSitesettingsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSitesettingsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildSitesettingsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildSitesettingsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildSitesettingsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildSitesettingsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildSitesettingsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildSitesettingsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     \UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSitesettings findOne(ConnectionInterface $con = null) Return the first ChildSitesettings matching the query
 * @method     ChildSitesettings findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSitesettings matching the query, or a new ChildSitesettings object populated from the query conditions when no match is found
 *
 * @method     ChildSitesettings findOneBySiteName(string $site_name) Return the first ChildSitesettings filtered by the site_name column
 * @method     ChildSitesettings findOneBySiteTitle(string $site_title) Return the first ChildSitesettings filtered by the site_title column
 * @method     ChildSitesettings findOneBySiteSubtitle(string $site_subtitle) Return the first ChildSitesettings filtered by the site_subtitle column
 * @method     ChildSitesettings findOneByUpdated(string $updated) Return the first ChildSitesettings filtered by the updated column
 * @method     ChildSitesettings findOneByByUser(string $by_user) Return the first ChildSitesettings filtered by the by_user column
 * @method     ChildSitesettings findOneBySiteMail(string $site_mail) Return the first ChildSitesettings filtered by the site_mail column
 * @method     ChildSitesettings findOneBySiteActivated(boolean $site_activated) Return the first ChildSitesettings filtered by the site_activated column
 * @method     ChildSitesettings findOneById(int $_id) Return the first ChildSitesettings filtered by the _id column *

 * @method     ChildSitesettings requirePk($key, ConnectionInterface $con = null) Return the ChildSitesettings by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOne(ConnectionInterface $con = null) Return the first ChildSitesettings matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSitesettings requireOneBySiteName(string $site_name) Return the first ChildSitesettings filtered by the site_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneBySiteTitle(string $site_title) Return the first ChildSitesettings filtered by the site_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneBySiteSubtitle(string $site_subtitle) Return the first ChildSitesettings filtered by the site_subtitle column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneByUpdated(string $updated) Return the first ChildSitesettings filtered by the updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneByByUser(string $by_user) Return the first ChildSitesettings filtered by the by_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneBySiteMail(string $site_mail) Return the first ChildSitesettings filtered by the site_mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneBySiteActivated(boolean $site_activated) Return the first ChildSitesettings filtered by the site_activated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSitesettings requireOneById(int $_id) Return the first ChildSitesettings filtered by the _id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSitesettings[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSitesettings objects based on current ModelCriteria
 * @method     ChildSitesettings[]|ObjectCollection findBySiteName(string $site_name) Return ChildSitesettings objects filtered by the site_name column
 * @method     ChildSitesettings[]|ObjectCollection findBySiteTitle(string $site_title) Return ChildSitesettings objects filtered by the site_title column
 * @method     ChildSitesettings[]|ObjectCollection findBySiteSubtitle(string $site_subtitle) Return ChildSitesettings objects filtered by the site_subtitle column
 * @method     ChildSitesettings[]|ObjectCollection findByUpdated(string $updated) Return ChildSitesettings objects filtered by the updated column
 * @method     ChildSitesettings[]|ObjectCollection findByByUser(string $by_user) Return ChildSitesettings objects filtered by the by_user column
 * @method     ChildSitesettings[]|ObjectCollection findBySiteMail(string $site_mail) Return ChildSitesettings objects filtered by the site_mail column
 * @method     ChildSitesettings[]|ObjectCollection findBySiteActivated(boolean $site_activated) Return ChildSitesettings objects filtered by the site_activated column
 * @method     ChildSitesettings[]|ObjectCollection findById(int $_id) Return ChildSitesettings objects filtered by the _id column
 * @method     ChildSitesettings[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SitesettingsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SitesettingsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Sitesettings', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSitesettingsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSitesettingsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSitesettingsQuery) {
            return $criteria;
        }
        $query = new ChildSitesettingsQuery();
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
     * @return ChildSitesettings|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The Sitesettings object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The Sitesettings object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The Sitesettings object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The Sitesettings object has no primary key');
    }

    /**
     * Filter the query on the site_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteName('fooValue');   // WHERE site_name = 'fooValue'
     * $query->filterBySiteName('%fooValue%', Criteria::LIKE); // WHERE site_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $siteName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterBySiteName($siteName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($siteName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_SITE_NAME, $siteName, $comparison);
    }

    /**
     * Filter the query on the site_title column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteTitle('fooValue');   // WHERE site_title = 'fooValue'
     * $query->filterBySiteTitle('%fooValue%', Criteria::LIKE); // WHERE site_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $siteTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterBySiteTitle($siteTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($siteTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_SITE_TITLE, $siteTitle, $comparison);
    }

    /**
     * Filter the query on the site_subtitle column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteSubtitle('fooValue');   // WHERE site_subtitle = 'fooValue'
     * $query->filterBySiteSubtitle('%fooValue%', Criteria::LIKE); // WHERE site_subtitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $siteSubtitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterBySiteSubtitle($siteSubtitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($siteSubtitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_SITE_SUBTITLE, $siteSubtitle, $comparison);
    }

    /**
     * Filter the query on the updated column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdated('2011-03-14'); // WHERE updated = '2011-03-14'
     * $query->filterByUpdated('now'); // WHERE updated = '2011-03-14'
     * $query->filterByUpdated(array('max' => 'yesterday')); // WHERE updated > '2011-03-13'
     * </code>
     *
     * @param     mixed $updated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterByUpdated($updated = null, $comparison = null)
    {
        if (is_array($updated)) {
            $useMinMax = false;
            if (isset($updated['min'])) {
                $this->addUsingAlias(SitesettingsTableMap::COL_UPDATED, $updated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updated['max'])) {
                $this->addUsingAlias(SitesettingsTableMap::COL_UPDATED, $updated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_UPDATED, $updated, $comparison);
    }

    /**
     * Filter the query on the by_user column
     *
     * Example usage:
     * <code>
     * $query->filterByByUser('fooValue');   // WHERE by_user = 'fooValue'
     * $query->filterByByUser('%fooValue%', Criteria::LIKE); // WHERE by_user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $byUser The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterByByUser($byUser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($byUser)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_BY_USER, $byUser, $comparison);
    }

    /**
     * Filter the query on the site_mail column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteMail('fooValue');   // WHERE site_mail = 'fooValue'
     * $query->filterBySiteMail('%fooValue%', Criteria::LIKE); // WHERE site_mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $siteMail The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterBySiteMail($siteMail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($siteMail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_SITE_MAIL, $siteMail, $comparison);
    }

    /**
     * Filter the query on the site_activated column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteActivated(true); // WHERE site_activated = true
     * $query->filterBySiteActivated('yes'); // WHERE site_activated = true
     * </code>
     *
     * @param     boolean|string $siteActivated The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterBySiteActivated($siteActivated = null, $comparison = null)
    {
        if (is_string($siteActivated)) {
            $siteActivated = in_array(strtolower($siteActivated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL_SITE_ACTIVATED, $siteActivated, $comparison);
    }

    /**
     * Filter the query on the _id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE _id = 1234
     * $query->filterById(array(12, 34)); // WHERE _id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE _id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SitesettingsTableMap::COL__ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SitesettingsTableMap::COL__ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SitesettingsTableMap::COL__ID, $id, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSitesettingsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(SitesettingsTableMap::COL_BY_USER, $users->getEmail(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SitesettingsTableMap::COL_BY_USER, $users->toKeyValue('PrimaryKey', 'Email'), $comparison);
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
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSitesettings $sitesettings Object to remove from the list of results
     *
     * @return $this|ChildSitesettingsQuery The current query, for fluid interface
     */
    public function prune($sitesettings = null)
    {
        if ($sitesettings) {
            throw new LogicException('Sitesettings object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the sitesettings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SitesettingsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SitesettingsTableMap::clearInstancePool();
            SitesettingsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SitesettingsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SitesettingsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            SitesettingsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SitesettingsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SitesettingsQuery
