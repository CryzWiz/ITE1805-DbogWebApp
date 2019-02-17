<?php

namespace Map;

use \Posts;
use \PostsQuery;
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
 * This class defines the structure of the 'posts' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PostsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PostsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'local';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'posts';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Posts';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Posts';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the post_id field
     */
    const COL_POST_ID = 'posts.post_id';

    /**
     * the column name for the post_title field
     */
    const COL_POST_TITLE = 'posts.post_title';

    /**
     * the column name for the post_image_url field
     */
    const COL_POST_IMAGE_URL = 'posts.post_image_url';

    /**
     * the column name for the post_date field
     */
    const COL_POST_DATE = 'posts.post_date';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'posts.active';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'posts.user_id';

    /**
     * the column name for the times_visited field
     */
    const COL_TIMES_VISITED = 'posts.times_visited';

    /**
     * the column name for the post_text field
     */
    const COL_POST_TEXT = 'posts.post_text';

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
        self::TYPE_PHPNAME       => array('PostId', 'PostTitle', 'PostImageUrl', 'PostDate', 'Active', 'UserId', 'TimesVisited', 'PostText', ),
        self::TYPE_CAMELNAME     => array('postId', 'postTitle', 'postImageUrl', 'postDate', 'active', 'userId', 'timesVisited', 'postText', ),
        self::TYPE_COLNAME       => array(PostsTableMap::COL_POST_ID, PostsTableMap::COL_POST_TITLE, PostsTableMap::COL_POST_IMAGE_URL, PostsTableMap::COL_POST_DATE, PostsTableMap::COL_ACTIVE, PostsTableMap::COL_USER_ID, PostsTableMap::COL_TIMES_VISITED, PostsTableMap::COL_POST_TEXT, ),
        self::TYPE_FIELDNAME     => array('post_id', 'post_title', 'post_image_url', 'post_date', 'active', 'user_id', 'times_visited', 'post_text', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PostId' => 0, 'PostTitle' => 1, 'PostImageUrl' => 2, 'PostDate' => 3, 'Active' => 4, 'UserId' => 5, 'TimesVisited' => 6, 'PostText' => 7, ),
        self::TYPE_CAMELNAME     => array('postId' => 0, 'postTitle' => 1, 'postImageUrl' => 2, 'postDate' => 3, 'active' => 4, 'userId' => 5, 'timesVisited' => 6, 'postText' => 7, ),
        self::TYPE_COLNAME       => array(PostsTableMap::COL_POST_ID => 0, PostsTableMap::COL_POST_TITLE => 1, PostsTableMap::COL_POST_IMAGE_URL => 2, PostsTableMap::COL_POST_DATE => 3, PostsTableMap::COL_ACTIVE => 4, PostsTableMap::COL_USER_ID => 5, PostsTableMap::COL_TIMES_VISITED => 6, PostsTableMap::COL_POST_TEXT => 7, ),
        self::TYPE_FIELDNAME     => array('post_id' => 0, 'post_title' => 1, 'post_image_url' => 2, 'post_date' => 3, 'active' => 4, 'user_id' => 5, 'times_visited' => 6, 'post_text' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('posts');
        $this->setPhpName('Posts');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Posts');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('post_id', 'PostId', 'INTEGER', true, null, null);
        $this->addColumn('post_title', 'PostTitle', 'VARCHAR', true, 150, null);
        $this->addColumn('post_image_url', 'PostImageUrl', 'VARCHAR', false, 256, null);
        $this->addColumn('post_date', 'PostDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', true, 1, null);
        $this->addForeignKey('user_id', 'UserId', 'VARCHAR', 'users', 'email', true, 45, null);
        $this->addColumn('times_visited', 'TimesVisited', 'INTEGER', false, null, null);
        $this->addColumn('post_text', 'PostText', 'LONGVARCHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Users', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':email',
  ),
), null, null, null, false);
        $this->addRelation('Comments', '\\Comments', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':to_post',
    1 => ':post_id',
  ),
), null, null, 'Commentss', false);
        $this->addRelation('CommentsDeleted', '\\CommentsDeleted', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':to_post',
    1 => ':post_id',
  ),
), null, null, 'CommentsDeleteds', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PostId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PostsTableMap::CLASS_DEFAULT : PostsTableMap::OM_CLASS;
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
     * @return array           (Posts object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PostsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PostsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PostsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PostsTableMap::OM_CLASS;
            /** @var Posts $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PostsTableMap::addInstanceToPool($obj, $key);
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
            $key = PostsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PostsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Posts $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PostsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PostsTableMap::COL_POST_ID);
            $criteria->addSelectColumn(PostsTableMap::COL_POST_TITLE);
            $criteria->addSelectColumn(PostsTableMap::COL_POST_IMAGE_URL);
            $criteria->addSelectColumn(PostsTableMap::COL_POST_DATE);
            $criteria->addSelectColumn(PostsTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(PostsTableMap::COL_USER_ID);
            $criteria->addSelectColumn(PostsTableMap::COL_TIMES_VISITED);
            $criteria->addSelectColumn(PostsTableMap::COL_POST_TEXT);
        } else {
            $criteria->addSelectColumn($alias . '.post_id');
            $criteria->addSelectColumn($alias . '.post_title');
            $criteria->addSelectColumn($alias . '.post_image_url');
            $criteria->addSelectColumn($alias . '.post_date');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.times_visited');
            $criteria->addSelectColumn($alias . '.post_text');
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
        return Propel::getServiceContainer()->getDatabaseMap(PostsTableMap::DATABASE_NAME)->getTable(PostsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PostsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PostsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PostsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Posts or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Posts object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PostsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Posts) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PostsTableMap::DATABASE_NAME);
            $criteria->add(PostsTableMap::COL_POST_ID, (array) $values, Criteria::IN);
        }

        $query = PostsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PostsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PostsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the posts table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PostsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Posts or Criteria object.
     *
     * @param mixed               $criteria Criteria or Posts object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Posts object
        }

        if ($criteria->containsKey(PostsTableMap::COL_POST_ID) && $criteria->keyContainsValue(PostsTableMap::COL_POST_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PostsTableMap::COL_POST_ID.')');
        }


        // Set the correct dbName
        $query = PostsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PostsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PostsTableMap::buildTableMap();
