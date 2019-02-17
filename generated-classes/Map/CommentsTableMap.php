<?php

namespace Map;

use \Comments;
use \CommentsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'comments' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CommentsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CommentsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'local';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'comments';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Comments';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Comments';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the comment_id field
     */
    const COL_COMMENT_ID = 'comments.comment_id';

    /**
     * the column name for the to_post field
     */
    const COL_TO_POST = 'comments.to_post';

    /**
     * the column name for the to_comment field
     */
    const COL_TO_COMMENT = 'comments.to_comment';

    /**
     * the column name for the made_by_user field
     */
    const COL_MADE_BY_USER = 'comments.made_by_user';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'comments.comment';

    /**
     * the column name for the comment_made field
     */
    const COL_COMMENT_MADE = 'comments.comment_made';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'comments.active';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('CommentId', 'ToPost', 'ToComment', 'MadeByUser', 'Comment', 'CommentMade', 'Active', ),
        self::TYPE_CAMELNAME     => array('commentId', 'toPost', 'toComment', 'madeByUser', 'comment', 'commentMade', 'active', ),
        self::TYPE_COLNAME       => array(CommentsTableMap::COL_COMMENT_ID, CommentsTableMap::COL_TO_POST, CommentsTableMap::COL_TO_COMMENT, CommentsTableMap::COL_MADE_BY_USER, CommentsTableMap::COL_COMMENT, CommentsTableMap::COL_COMMENT_MADE, CommentsTableMap::COL_ACTIVE, ),
        self::TYPE_FIELDNAME     => array('comment_id', 'to_post', 'to_comment', 'made_by_user', 'comment', 'comment_made', 'active', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('CommentId' => 0, 'ToPost' => 1, 'ToComment' => 2, 'MadeByUser' => 3, 'Comment' => 4, 'CommentMade' => 5, 'Active' => 6, ),
        self::TYPE_CAMELNAME     => array('commentId' => 0, 'toPost' => 1, 'toComment' => 2, 'madeByUser' => 3, 'comment' => 4, 'commentMade' => 5, 'active' => 6, ),
        self::TYPE_COLNAME       => array(CommentsTableMap::COL_COMMENT_ID => 0, CommentsTableMap::COL_TO_POST => 1, CommentsTableMap::COL_TO_COMMENT => 2, CommentsTableMap::COL_MADE_BY_USER => 3, CommentsTableMap::COL_COMMENT => 4, CommentsTableMap::COL_COMMENT_MADE => 5, CommentsTableMap::COL_ACTIVE => 6, ),
        self::TYPE_FIELDNAME     => array('comment_id' => 0, 'to_post' => 1, 'to_comment' => 2, 'made_by_user' => 3, 'comment' => 4, 'comment_made' => 5, 'active' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('comments');
        $this->setPhpName('Comments');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Comments');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('comment_id', 'CommentId', 'INTEGER', true, null, null);
        $this->addForeignKey('to_post', 'ToPost', 'INTEGER', 'posts', 'post_id', true, null, null);
        $this->addForeignKey('to_comment', 'ToComment', 'INTEGER', 'comments', 'comment_id', false, null, null);
        $this->addForeignKey('made_by_user', 'MadeByUser', 'VARCHAR', 'users', 'email', true, 45, null);
        $this->addColumn('comment', 'Comment', 'VARCHAR', true, 1000, null);
        $this->addColumn('comment_made', 'CommentMade', 'TIMESTAMP', true, null, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CommentsRelatedByToComment', '\\Comments', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':to_comment',
    1 => ':comment_id',
  ),
), null, null, null, false);
        $this->addRelation('Posts', '\\Posts', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':to_post',
    1 => ':post_id',
  ),
), null, null, null, false);
        $this->addRelation('Users', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':made_by_user',
    1 => ':email',
  ),
), null, null, null, false);
        $this->addRelation('CommentsRelatedByCommentId', '\\Comments', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':to_comment',
    1 => ':comment_id',
  ),
), null, null, 'CommentssRelatedByCommentId', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('CommentId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CommentsTableMap::CLASS_DEFAULT : CommentsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Comments object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CommentsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CommentsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CommentsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CommentsTableMap::OM_CLASS;
            /** @var Comments $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CommentsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CommentsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CommentsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Comments $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CommentsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CommentsTableMap::COL_COMMENT_ID);
            $criteria->addSelectColumn(CommentsTableMap::COL_TO_POST);
            $criteria->addSelectColumn(CommentsTableMap::COL_TO_COMMENT);
            $criteria->addSelectColumn(CommentsTableMap::COL_MADE_BY_USER);
            $criteria->addSelectColumn(CommentsTableMap::COL_COMMENT);
            $criteria->addSelectColumn(CommentsTableMap::COL_COMMENT_MADE);
            $criteria->addSelectColumn(CommentsTableMap::COL_ACTIVE);
        } else {
            $criteria->addSelectColumn($alias . '.comment_id');
            $criteria->addSelectColumn($alias . '.to_post');
            $criteria->addSelectColumn($alias . '.to_comment');
            $criteria->addSelectColumn($alias . '.made_by_user');
            $criteria->addSelectColumn($alias . '.comment');
            $criteria->addSelectColumn($alias . '.comment_made');
            $criteria->addSelectColumn($alias . '.active');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CommentsTableMap::DATABASE_NAME)->getTable(CommentsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CommentsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CommentsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CommentsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Comments or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Comments object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Comments) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CommentsTableMap::DATABASE_NAME);
            $criteria->add(CommentsTableMap::COL_COMMENT_ID, (array) $values, Criteria::IN);
        }

        $query = CommentsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CommentsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CommentsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the comments table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CommentsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Comments or Criteria object.
     *
     * @param mixed               $criteria Criteria or Comments object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Comments object
        }

        if ($criteria->containsKey(CommentsTableMap::COL_COMMENT_ID) && $criteria->keyContainsValue(CommentsTableMap::COL_COMMENT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CommentsTableMap::COL_COMMENT_ID.')');
        }


        // Set the correct dbName
        $query = CommentsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CommentsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CommentsTableMap::buildTableMap();
