<?php

namespace Base;

use \Comments as ChildComments;
use \CommentsDeleted as ChildCommentsDeleted;
use \CommentsDeletedQuery as ChildCommentsDeletedQuery;
use \CommentsQuery as ChildCommentsQuery;
use \Posts as ChildPosts;
use \PostsQuery as ChildPostsQuery;
use \Sitesettings as ChildSitesettings;
use \SitesettingsQuery as ChildSitesettingsQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \ValidationLink as ChildValidationLink;
use \ValidationLinkQuery as ChildValidationLinkQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CommentsDeletedTableMap;
use Map\CommentsTableMap;
use Map\PostsTableMap;
use Map\SitesettingsTableMap;
use Map\UsersTableMap;
use Map\ValidationLinkTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'users' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class Users implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UsersTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * The value for the reg_date field.
     * 
     * @var        DateTime
     */
    protected $reg_date;

    /**
     * The value for the password field.
     * 
     * @var        string
     */
    protected $password;

    /**
     * The value for the role field.
     * 
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $role;

    /**
     * The value for the active field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the validated field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $validated;

    /**
     * The value for the firstname field.
     * 
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     * 
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the user_name field.
     * 
     * @var        string
     */
    protected $user_name;

    /**
     * The value for the current_login field.
     * 
     * @var        DateTime
     */
    protected $current_login;

    /**
     * The value for the last_login field.
     * 
     * @var        DateTime
     */
    protected $last_login;

    /**
     * @var        ObjectCollection|ChildComments[] Collection to store aggregation of ChildComments objects.
     */
    protected $collCommentss;
    protected $collCommentssPartial;

    /**
     * @var        ObjectCollection|ChildCommentsDeleted[] Collection to store aggregation of ChildCommentsDeleted objects.
     */
    protected $collCommentsDeleteds;
    protected $collCommentsDeletedsPartial;

    /**
     * @var        ObjectCollection|ChildPosts[] Collection to store aggregation of ChildPosts objects.
     */
    protected $collPostss;
    protected $collPostssPartial;

    /**
     * @var        ObjectCollection|ChildSitesettings[] Collection to store aggregation of ChildSitesettings objects.
     */
    protected $collSitesettingss;
    protected $collSitesettingssPartial;

    /**
     * @var        ObjectCollection|ChildValidationLink[] Collection to store aggregation of ChildValidationLink objects.
     */
    protected $collValidationLinks;
    protected $collValidationLinksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComments[]
     */
    protected $commentssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCommentsDeleted[]
     */
    protected $commentsDeletedsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPosts[]
     */
    protected $postssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSitesettings[]
     */
    protected $sitesettingssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildValidationLink[]
     */
    protected $validationLinksScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->role = 1;
        $this->active = false;
        $this->validated = false;
    }

    /**
     * Initializes internal state of Base\Users object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Users</code> instance.  If
     * <code>obj</code> is an instance of <code>Users</code>, delegates to
     * <code>equals(Users)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Users The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [optionally formatted] temporal [reg_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegDate($format = NULL)
    {
        if ($format === null) {
            return $this->reg_date;
        } else {
            return $this->reg_date instanceof \DateTimeInterface ? $this->reg_date->format($format) : null;
        }
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [role] column value.
     * 
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the [active] column value.
     * 
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [active] column value.
     * 
     * @return boolean
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get the [validated] column value.
     * 
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Get the [validated] column value.
     * 
     * @return boolean
     */
    public function isValidated()
    {
        return $this->getValidated();
    }

    /**
     * Get the [firstname] column value.
     * 
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     * 
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [user_name] column value.
     * 
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Get the [optionally formatted] temporal [current_login] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCurrentLogin($format = NULL)
    {
        if ($format === null) {
            return $this->current_login;
        } else {
            return $this->current_login instanceof \DateTimeInterface ? $this->current_login->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_login] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastLogin($format = NULL)
    {
        if ($format === null) {
            return $this->last_login;
        } else {
            return $this->last_login instanceof \DateTimeInterface ? $this->last_login->format($format) : null;
        }
    }

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsersTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Sets the value of [reg_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setRegDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->reg_date !== null || $dt !== null) {
            if ($this->reg_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->reg_date->format("Y-m-d H:i:s.u")) {
                $this->reg_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UsersTableMap::COL_REG_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setRegDate()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UsersTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [role] column.
     * 
     * @param int $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setRole($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role !== $v) {
            $this->role = $v;
            $this->modifiedColumns[UsersTableMap::COL_ROLE] = true;
        }

        return $this;
    } // setRole()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[UsersTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Sets the value of the [validated] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setValidated($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->validated !== $v) {
            $this->validated = $v;
            $this->modifiedColumns[UsersTableMap::COL_VALIDATED] = true;
        }

        return $this;
    } // setValidated()

    /**
     * Set the value of [firstname] column.
     * 
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[UsersTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     * 
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[UsersTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Set the value of [user_name] column.
     * 
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setUserName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_name !== $v) {
            $this->user_name = $v;
            $this->modifiedColumns[UsersTableMap::COL_USER_NAME] = true;
        }

        return $this;
    } // setUserName()

    /**
     * Sets the value of [current_login] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setCurrentLogin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->current_login !== null || $dt !== null) {
            if ($this->current_login === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->current_login->format("Y-m-d H:i:s.u")) {
                $this->current_login = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UsersTableMap::COL_CURRENT_LOGIN] = true;
            }
        } // if either are not null

        return $this;
    } // setCurrentLogin()

    /**
     * Sets the value of [last_login] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setLastLogin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_login !== null || $dt !== null) {
            if ($this->last_login === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_login->format("Y-m-d H:i:s.u")) {
                $this->last_login = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UsersTableMap::COL_LAST_LOGIN] = true;
            }
        } // if either are not null

        return $this;
    } // setLastLogin()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->role !== 1) {
                return false;
            }

            if ($this->active !== false) {
                return false;
            }

            if ($this->validated !== false) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsersTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsersTableMap::translateFieldName('RegDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->reg_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsersTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsersTableMap::translateFieldName('Role', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsersTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsersTableMap::translateFieldName('Validated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->validated = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsersTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UsersTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UsersTableMap::translateFieldName('UserName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UsersTableMap::translateFieldName('CurrentLogin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->current_login = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UsersTableMap::translateFieldName('LastLogin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_login = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = UsersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Users'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCommentss = null;

            $this->collCommentsDeleteds = null;

            $this->collPostss = null;

            $this->collSitesettingss = null;

            $this->collValidationLinks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Users::setDeleted()
     * @see Users::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsersQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }
 
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UsersTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->commentssScheduledForDeletion !== null) {
                if (!$this->commentssScheduledForDeletion->isEmpty()) {
                    \CommentsQuery::create()
                        ->filterByPrimaryKeys($this->commentssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentssScheduledForDeletion = null;
                }
            }

            if ($this->collCommentss !== null) {
                foreach ($this->collCommentss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsDeletedsScheduledForDeletion !== null) {
                if (!$this->commentsDeletedsScheduledForDeletion->isEmpty()) {
                    \CommentsDeletedQuery::create()
                        ->filterByPrimaryKeys($this->commentsDeletedsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsDeletedsScheduledForDeletion = null;
                }
            }

            if ($this->collCommentsDeleteds !== null) {
                foreach ($this->collCommentsDeleteds as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postssScheduledForDeletion !== null) {
                if (!$this->postssScheduledForDeletion->isEmpty()) {
                    \PostsQuery::create()
                        ->filterByPrimaryKeys($this->postssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postssScheduledForDeletion = null;
                }
            }

            if ($this->collPostss !== null) {
                foreach ($this->collPostss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sitesettingssScheduledForDeletion !== null) {
                if (!$this->sitesettingssScheduledForDeletion->isEmpty()) {
                    \SitesettingsQuery::create()
                        ->filterByPrimaryKeys($this->sitesettingssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sitesettingssScheduledForDeletion = null;
                }
            }

            if ($this->collSitesettingss !== null) {
                foreach ($this->collSitesettingss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->validationLinksScheduledForDeletion !== null) {
                if (!$this->validationLinksScheduledForDeletion->isEmpty()) {
                    \ValidationLinkQuery::create()
                        ->filterByPrimaryKeys($this->validationLinksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->validationLinksScheduledForDeletion = null;
                }
            }

            if ($this->collValidationLinks !== null) {
                foreach ($this->collValidationLinks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsersTableMap::COL_REG_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'reg_date';
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UsersTableMap::COL_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'role';
        }
        if ($this->isColumnModified(UsersTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(UsersTableMap::COL_VALIDATED)) {
            $modifiedColumns[':p' . $index++]  = 'validated';
        }
        if ($this->isColumnModified(UsersTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'firstname';
        }
        if ($this->isColumnModified(UsersTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'lastname';
        }
        if ($this->isColumnModified(UsersTableMap::COL_USER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'user_name';
        }
        if ($this->isColumnModified(UsersTableMap::COL_CURRENT_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = 'current_login';
        }
        if ($this->isColumnModified(UsersTableMap::COL_LAST_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = 'last_login';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'reg_date':                        
                        $stmt->bindValue($identifier, $this->reg_date ? $this->reg_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'role':                        
                        $stmt->bindValue($identifier, $this->role, PDO::PARAM_INT);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'validated':
                        $stmt->bindValue($identifier, (int) $this->validated, PDO::PARAM_INT);
                        break;
                    case 'firstname':                        
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'lastname':                        
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'user_name':                        
                        $stmt->bindValue($identifier, $this->user_name, PDO::PARAM_STR);
                        break;
                    case 'current_login':                        
                        $stmt->bindValue($identifier, $this->current_login ? $this->current_login->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'last_login':                        
                        $stmt->bindValue($identifier, $this->last_login ? $this->last_login->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getEmail();
                break;
            case 1:
                return $this->getRegDate();
                break;
            case 2:
                return $this->getPassword();
                break;
            case 3:
                return $this->getRole();
                break;
            case 4:
                return $this->getActive();
                break;
            case 5:
                return $this->getValidated();
                break;
            case 6:
                return $this->getFirstname();
                break;
            case 7:
                return $this->getLastname();
                break;
            case 8:
                return $this->getUserName();
                break;
            case 9:
                return $this->getCurrentLogin();
                break;
            case 10:
                return $this->getLastLogin();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Users'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Users'][$this->hashCode()] = true;
        $keys = UsersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEmail(),
            $keys[1] => $this->getRegDate(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getRole(),
            $keys[4] => $this->getActive(),
            $keys[5] => $this->getValidated(),
            $keys[6] => $this->getFirstname(),
            $keys[7] => $this->getLastname(),
            $keys[8] => $this->getUserName(),
            $keys[9] => $this->getCurrentLogin(),
            $keys[10] => $this->getLastLogin(),
        );
        if ($result[$keys[1]] instanceof \DateTime) {
            $result[$keys[1]] = $result[$keys[1]]->format('c');
        }
        
        if ($result[$keys[9]] instanceof \DateTime) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }
        
        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collCommentss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commentss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commentss';
                        break;
                    default:
                        $key = 'Commentss';
                }
        
                $result[$key] = $this->collCommentss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCommentsDeleteds) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commentsDeleteds';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comments_deleteds';
                        break;
                    default:
                        $key = 'CommentsDeleteds';
                }
        
                $result[$key] = $this->collCommentsDeleteds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPostss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'postss';
                        break;
                    default:
                        $key = 'Postss';
                }
        
                $result[$key] = $this->collPostss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSitesettingss) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sitesettingss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sitesettingss';
                        break;
                    default:
                        $key = 'Sitesettingss';
                }
        
                $result[$key] = $this->collSitesettingss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collValidationLinks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'validationLinks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'validation_links';
                        break;
                    default:
                        $key = 'ValidationLinks';
                }
        
                $result[$key] = $this->collValidationLinks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Users
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Users
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEmail($value);
                break;
            case 1:
                $this->setRegDate($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setRole($value);
                break;
            case 4:
                $this->setActive($value);
                break;
            case 5:
                $this->setValidated($value);
                break;
            case 6:
                $this->setFirstname($value);
                break;
            case 7:
                $this->setLastname($value);
                break;
            case 8:
                $this->setUserName($value);
                break;
            case 9:
                $this->setCurrentLogin($value);
                break;
            case 10:
                $this->setLastLogin($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UsersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEmail($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRegDate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPassword($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setRole($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setActive($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setValidated($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFirstname($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLastname($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUserName($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCurrentLogin($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setLastLogin($arr[$keys[10]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Users The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UsersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $criteria->add(UsersTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsersTableMap::COL_REG_DATE)) {
            $criteria->add(UsersTableMap::COL_REG_DATE, $this->reg_date);
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $criteria->add(UsersTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UsersTableMap::COL_ROLE)) {
            $criteria->add(UsersTableMap::COL_ROLE, $this->role);
        }
        if ($this->isColumnModified(UsersTableMap::COL_ACTIVE)) {
            $criteria->add(UsersTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(UsersTableMap::COL_VALIDATED)) {
            $criteria->add(UsersTableMap::COL_VALIDATED, $this->validated);
        }
        if ($this->isColumnModified(UsersTableMap::COL_FIRSTNAME)) {
            $criteria->add(UsersTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(UsersTableMap::COL_LASTNAME)) {
            $criteria->add(UsersTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(UsersTableMap::COL_USER_NAME)) {
            $criteria->add(UsersTableMap::COL_USER_NAME, $this->user_name);
        }
        if ($this->isColumnModified(UsersTableMap::COL_CURRENT_LOGIN)) {
            $criteria->add(UsersTableMap::COL_CURRENT_LOGIN, $this->current_login);
        }
        if ($this->isColumnModified(UsersTableMap::COL_LAST_LOGIN)) {
            $criteria->add(UsersTableMap::COL_LAST_LOGIN, $this->last_login);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUsersQuery::create();
        $criteria->add(UsersTableMap::COL_EMAIL, $this->email);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getEmail();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getEmail();
    }

    /**
     * Generic method to set the primary key (email column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setEmail($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getEmail();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Users (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEmail($this->getEmail());
        $copyObj->setRegDate($this->getRegDate());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setRole($this->getRole());
        $copyObj->setActive($this->getActive());
        $copyObj->setValidated($this->getValidated());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setUserName($this->getUserName());
        $copyObj->setCurrentLogin($this->getCurrentLogin());
        $copyObj->setLastLogin($this->getLastLogin());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComments($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCommentsDeleteds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommentsDeleted($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPostss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPosts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSitesettingss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSitesettings($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getValidationLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addValidationLink($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Users Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Comments' == $relationName) {
            return $this->initCommentss();
        }
        if ('CommentsDeleted' == $relationName) {
            return $this->initCommentsDeleteds();
        }
        if ('Posts' == $relationName) {
            return $this->initPostss();
        }
        if ('Sitesettings' == $relationName) {
            return $this->initSitesettingss();
        }
        if ('ValidationLink' == $relationName) {
            return $this->initValidationLinks();
        }
    }

    /**
     * Clears out the collCommentss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentss()
     */
    public function clearCommentss()
    {
        $this->collCommentss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentss collection loaded partially.
     */
    public function resetPartialCommentss($v = true)
    {
        $this->collCommentssPartial = $v;
    }

    /**
     * Initializes the collCommentss collection.
     *
     * By default this just sets the collCommentss collection to an empty array (like clearcollCommentss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentss($overrideExisting = true)
    {
        if (null !== $this->collCommentss && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentsTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentss = new $collectionClassName;
        $this->collCommentss->setModel('\Comments');
    }

    /**
     * Gets an array of ChildComments objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     * @throws PropelException
     */
    public function getCommentss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                // return empty collection
                $this->initCommentss();
            } else {
                $collCommentss = ChildCommentsQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentssPartial && count($collCommentss)) {
                        $this->initCommentss(false);

                        foreach ($collCommentss as $obj) {
                            if (false == $this->collCommentss->contains($obj)) {
                                $this->collCommentss->append($obj);
                            }
                        }

                        $this->collCommentssPartial = true;
                    }

                    return $collCommentss;
                }

                if ($partial && $this->collCommentss) {
                    foreach ($this->collCommentss as $obj) {
                        if ($obj->isNew()) {
                            $collCommentss[] = $obj;
                        }
                    }
                }

                $this->collCommentss = $collCommentss;
                $this->collCommentssPartial = false;
            }
        }

        return $this->collCommentss;
    }

    /**
     * Sets a collection of ChildComments objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setCommentss(Collection $commentss, ConnectionInterface $con = null)
    {
        /** @var ChildComments[] $commentssToDelete */
        $commentssToDelete = $this->getCommentss(new Criteria(), $con)->diff($commentss);

        
        $this->commentssScheduledForDeletion = $commentssToDelete;

        foreach ($commentssToDelete as $commentsRemoved) {
            $commentsRemoved->setUsers(null);
        }

        $this->collCommentss = null;
        foreach ($commentss as $comments) {
            $this->addComments($comments);
        }

        $this->collCommentss = $commentss;
        $this->collCommentssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comments objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comments objects.
     * @throws PropelException
     */
    public function countCommentss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentss());
            }

            $query = ChildCommentsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collCommentss);
    }

    /**
     * Method called to associate a ChildComments object to this object
     * through the ChildComments foreign key attribute.
     *
     * @param  ChildComments $l ChildComments
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addComments(ChildComments $l)
    {
        if ($this->collCommentss === null) {
            $this->initCommentss();
            $this->collCommentssPartial = true;
        }

        if (!$this->collCommentss->contains($l)) {
            $this->doAddComments($l);

            if ($this->commentssScheduledForDeletion and $this->commentssScheduledForDeletion->contains($l)) {
                $this->commentssScheduledForDeletion->remove($this->commentssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComments $comments The ChildComments object to add.
     */
    protected function doAddComments(ChildComments $comments)
    {
        $this->collCommentss[]= $comments;
        $comments->setUsers($this);
    }

    /**
     * @param  ChildComments $comments The ChildComments object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeComments(ChildComments $comments)
    {
        if ($this->getCommentss()->contains($comments)) {
            $pos = $this->collCommentss->search($comments);
            $this->collCommentss->remove($pos);
            if (null === $this->commentssScheduledForDeletion) {
                $this->commentssScheduledForDeletion = clone $this->collCommentss;
                $this->commentssScheduledForDeletion->clear();
            }
            $this->commentssScheduledForDeletion[]= clone $comments;
            $comments->setUsers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Commentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     */
    public function getCommentssJoinCommentsRelatedByToComment(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsQuery::create(null, $criteria);
        $query->joinWith('CommentsRelatedByToComment', $joinBehavior);

        return $this->getCommentss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Commentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     */
    public function getCommentssJoinPosts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsQuery::create(null, $criteria);
        $query->joinWith('Posts', $joinBehavior);

        return $this->getCommentss($query, $con);
    }

    /**
     * Clears out the collCommentsDeleteds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentsDeleteds()
     */
    public function clearCommentsDeleteds()
    {
        $this->collCommentsDeleteds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentsDeleteds collection loaded partially.
     */
    public function resetPartialCommentsDeleteds($v = true)
    {
        $this->collCommentsDeletedsPartial = $v;
    }

    /**
     * Initializes the collCommentsDeleteds collection.
     *
     * By default this just sets the collCommentsDeleteds collection to an empty array (like clearcollCommentsDeleteds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentsDeleteds($overrideExisting = true)
    {
        if (null !== $this->collCommentsDeleteds && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentsDeletedTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentsDeleteds = new $collectionClassName;
        $this->collCommentsDeleteds->setModel('\CommentsDeleted');
    }

    /**
     * Gets an array of ChildCommentsDeleted objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCommentsDeleted[] List of ChildCommentsDeleted objects
     * @throws PropelException
     */
    public function getCommentsDeleteds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsDeletedsPartial && !$this->isNew();
        if (null === $this->collCommentsDeleteds || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentsDeleteds) {
                // return empty collection
                $this->initCommentsDeleteds();
            } else {
                $collCommentsDeleteds = ChildCommentsDeletedQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsDeletedsPartial && count($collCommentsDeleteds)) {
                        $this->initCommentsDeleteds(false);

                        foreach ($collCommentsDeleteds as $obj) {
                            if (false == $this->collCommentsDeleteds->contains($obj)) {
                                $this->collCommentsDeleteds->append($obj);
                            }
                        }

                        $this->collCommentsDeletedsPartial = true;
                    }

                    return $collCommentsDeleteds;
                }

                if ($partial && $this->collCommentsDeleteds) {
                    foreach ($this->collCommentsDeleteds as $obj) {
                        if ($obj->isNew()) {
                            $collCommentsDeleteds[] = $obj;
                        }
                    }
                }

                $this->collCommentsDeleteds = $collCommentsDeleteds;
                $this->collCommentsDeletedsPartial = false;
            }
        }

        return $this->collCommentsDeleteds;
    }

    /**
     * Sets a collection of ChildCommentsDeleted objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentsDeleteds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setCommentsDeleteds(Collection $commentsDeleteds, ConnectionInterface $con = null)
    {
        /** @var ChildCommentsDeleted[] $commentsDeletedsToDelete */
        $commentsDeletedsToDelete = $this->getCommentsDeleteds(new Criteria(), $con)->diff($commentsDeleteds);

        
        $this->commentsDeletedsScheduledForDeletion = $commentsDeletedsToDelete;

        foreach ($commentsDeletedsToDelete as $commentsDeletedRemoved) {
            $commentsDeletedRemoved->setUsers(null);
        }

        $this->collCommentsDeleteds = null;
        foreach ($commentsDeleteds as $commentsDeleted) {
            $this->addCommentsDeleted($commentsDeleted);
        }

        $this->collCommentsDeleteds = $commentsDeleteds;
        $this->collCommentsDeletedsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CommentsDeleted objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CommentsDeleted objects.
     * @throws PropelException
     */
    public function countCommentsDeleteds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsDeletedsPartial && !$this->isNew();
        if (null === $this->collCommentsDeleteds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentsDeleteds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentsDeleteds());
            }

            $query = ChildCommentsDeletedQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collCommentsDeleteds);
    }

    /**
     * Method called to associate a ChildCommentsDeleted object to this object
     * through the ChildCommentsDeleted foreign key attribute.
     *
     * @param  ChildCommentsDeleted $l ChildCommentsDeleted
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addCommentsDeleted(ChildCommentsDeleted $l)
    {
        if ($this->collCommentsDeleteds === null) {
            $this->initCommentsDeleteds();
            $this->collCommentsDeletedsPartial = true;
        }

        if (!$this->collCommentsDeleteds->contains($l)) {
            $this->doAddCommentsDeleted($l);

            if ($this->commentsDeletedsScheduledForDeletion and $this->commentsDeletedsScheduledForDeletion->contains($l)) {
                $this->commentsDeletedsScheduledForDeletion->remove($this->commentsDeletedsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCommentsDeleted $commentsDeleted The ChildCommentsDeleted object to add.
     */
    protected function doAddCommentsDeleted(ChildCommentsDeleted $commentsDeleted)
    {
        $this->collCommentsDeleteds[]= $commentsDeleted;
        $commentsDeleted->setUsers($this);
    }

    /**
     * @param  ChildCommentsDeleted $commentsDeleted The ChildCommentsDeleted object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeCommentsDeleted(ChildCommentsDeleted $commentsDeleted)
    {
        if ($this->getCommentsDeleteds()->contains($commentsDeleted)) {
            $pos = $this->collCommentsDeleteds->search($commentsDeleted);
            $this->collCommentsDeleteds->remove($pos);
            if (null === $this->commentsDeletedsScheduledForDeletion) {
                $this->commentsDeletedsScheduledForDeletion = clone $this->collCommentsDeleteds;
                $this->commentsDeletedsScheduledForDeletion->clear();
            }
            $this->commentsDeletedsScheduledForDeletion[]= clone $commentsDeleted;
            $commentsDeleted->setUsers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related CommentsDeleteds from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCommentsDeleted[] List of ChildCommentsDeleted objects
     */
    public function getCommentsDeletedsJoinPosts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsDeletedQuery::create(null, $criteria);
        $query->joinWith('Posts', $joinBehavior);

        return $this->getCommentsDeleteds($query, $con);
    }

    /**
     * Clears out the collPostss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostss()
     */
    public function clearPostss()
    {
        $this->collPostss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostss collection loaded partially.
     */
    public function resetPartialPostss($v = true)
    {
        $this->collPostssPartial = $v;
    }

    /**
     * Initializes the collPostss collection.
     *
     * By default this just sets the collPostss collection to an empty array (like clearcollPostss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostss($overrideExisting = true)
    {
        if (null !== $this->collPostss && !$overrideExisting) {
            return;
        }

        $collectionClassName = PostsTableMap::getTableMap()->getCollectionClassName();

        $this->collPostss = new $collectionClassName;
        $this->collPostss->setModel('\Posts');
    }

    /**
     * Gets an array of ChildPosts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPosts[] List of ChildPosts objects
     * @throws PropelException
     */
    public function getPostss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostssPartial && !$this->isNew();
        if (null === $this->collPostss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostss) {
                // return empty collection
                $this->initPostss();
            } else {
                $collPostss = ChildPostsQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostssPartial && count($collPostss)) {
                        $this->initPostss(false);

                        foreach ($collPostss as $obj) {
                            if (false == $this->collPostss->contains($obj)) {
                                $this->collPostss->append($obj);
                            }
                        }

                        $this->collPostssPartial = true;
                    }

                    return $collPostss;
                }

                if ($partial && $this->collPostss) {
                    foreach ($this->collPostss as $obj) {
                        if ($obj->isNew()) {
                            $collPostss[] = $obj;
                        }
                    }
                }

                $this->collPostss = $collPostss;
                $this->collPostssPartial = false;
            }
        }

        return $this->collPostss;
    }

    /**
     * Sets a collection of ChildPosts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setPostss(Collection $postss, ConnectionInterface $con = null)
    {
        /** @var ChildPosts[] $postssToDelete */
        $postssToDelete = $this->getPostss(new Criteria(), $con)->diff($postss);

        
        $this->postssScheduledForDeletion = $postssToDelete;

        foreach ($postssToDelete as $postsRemoved) {
            $postsRemoved->setUsers(null);
        }

        $this->collPostss = null;
        foreach ($postss as $posts) {
            $this->addPosts($posts);
        }

        $this->collPostss = $postss;
        $this->collPostssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Posts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Posts objects.
     * @throws PropelException
     */
    public function countPostss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostssPartial && !$this->isNew();
        if (null === $this->collPostss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostss());
            }

            $query = ChildPostsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collPostss);
    }

    /**
     * Method called to associate a ChildPosts object to this object
     * through the ChildPosts foreign key attribute.
     *
     * @param  ChildPosts $l ChildPosts
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addPosts(ChildPosts $l)
    {
        if ($this->collPostss === null) {
            $this->initPostss();
            $this->collPostssPartial = true;
        }

        if (!$this->collPostss->contains($l)) {
            $this->doAddPosts($l);

            if ($this->postssScheduledForDeletion and $this->postssScheduledForDeletion->contains($l)) {
                $this->postssScheduledForDeletion->remove($this->postssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPosts $posts The ChildPosts object to add.
     */
    protected function doAddPosts(ChildPosts $posts)
    {
        $this->collPostss[]= $posts;
        $posts->setUsers($this);
    }

    /**
     * @param  ChildPosts $posts The ChildPosts object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removePosts(ChildPosts $posts)
    {
        if ($this->getPostss()->contains($posts)) {
            $pos = $this->collPostss->search($posts);
            $this->collPostss->remove($pos);
            if (null === $this->postssScheduledForDeletion) {
                $this->postssScheduledForDeletion = clone $this->collPostss;
                $this->postssScheduledForDeletion->clear();
            }
            $this->postssScheduledForDeletion[]= clone $posts;
            $posts->setUsers(null);
        }

        return $this;
    }

    /**
     * Clears out the collSitesettingss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSitesettingss()
     */
    public function clearSitesettingss()
    {
        $this->collSitesettingss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSitesettingss collection loaded partially.
     */
    public function resetPartialSitesettingss($v = true)
    {
        $this->collSitesettingssPartial = $v;
    }

    /**
     * Initializes the collSitesettingss collection.
     *
     * By default this just sets the collSitesettingss collection to an empty array (like clearcollSitesettingss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSitesettingss($overrideExisting = true)
    {
        if (null !== $this->collSitesettingss && !$overrideExisting) {
            return;
        }

        $collectionClassName = SitesettingsTableMap::getTableMap()->getCollectionClassName();

        $this->collSitesettingss = new $collectionClassName;
        $this->collSitesettingss->setModel('\Sitesettings');
    }

    /**
     * Gets an array of ChildSitesettings objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSitesettings[] List of ChildSitesettings objects
     * @throws PropelException
     */
    public function getSitesettingss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSitesettingssPartial && !$this->isNew();
        if (null === $this->collSitesettingss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSitesettingss) {
                // return empty collection
                $this->initSitesettingss();
            } else {
                $collSitesettingss = ChildSitesettingsQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSitesettingssPartial && count($collSitesettingss)) {
                        $this->initSitesettingss(false);

                        foreach ($collSitesettingss as $obj) {
                            if (false == $this->collSitesettingss->contains($obj)) {
                                $this->collSitesettingss->append($obj);
                            }
                        }

                        $this->collSitesettingssPartial = true;
                    }

                    return $collSitesettingss;
                }

                if ($partial && $this->collSitesettingss) {
                    foreach ($this->collSitesettingss as $obj) {
                        if ($obj->isNew()) {
                            $collSitesettingss[] = $obj;
                        }
                    }
                }

                $this->collSitesettingss = $collSitesettingss;
                $this->collSitesettingssPartial = false;
            }
        }

        return $this->collSitesettingss;
    }

    /**
     * Sets a collection of ChildSitesettings objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sitesettingss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setSitesettingss(Collection $sitesettingss, ConnectionInterface $con = null)
    {
        /** @var ChildSitesettings[] $sitesettingssToDelete */
        $sitesettingssToDelete = $this->getSitesettingss(new Criteria(), $con)->diff($sitesettingss);

        
        $this->sitesettingssScheduledForDeletion = $sitesettingssToDelete;

        foreach ($sitesettingssToDelete as $sitesettingsRemoved) {
            $sitesettingsRemoved->setUsers(null);
        }

        $this->collSitesettingss = null;
        foreach ($sitesettingss as $sitesettings) {
            $this->addSitesettings($sitesettings);
        }

        $this->collSitesettingss = $sitesettingss;
        $this->collSitesettingssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Sitesettings objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Sitesettings objects.
     * @throws PropelException
     */
    public function countSitesettingss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSitesettingssPartial && !$this->isNew();
        if (null === $this->collSitesettingss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSitesettingss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSitesettingss());
            }

            $query = ChildSitesettingsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collSitesettingss);
    }

    /**
     * Method called to associate a ChildSitesettings object to this object
     * through the ChildSitesettings foreign key attribute.
     *
     * @param  ChildSitesettings $l ChildSitesettings
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addSitesettings(ChildSitesettings $l)
    {
        if ($this->collSitesettingss === null) {
            $this->initSitesettingss();
            $this->collSitesettingssPartial = true;
        }

        if (!$this->collSitesettingss->contains($l)) {
            $this->doAddSitesettings($l);

            if ($this->sitesettingssScheduledForDeletion and $this->sitesettingssScheduledForDeletion->contains($l)) {
                $this->sitesettingssScheduledForDeletion->remove($this->sitesettingssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSitesettings $sitesettings The ChildSitesettings object to add.
     */
    protected function doAddSitesettings(ChildSitesettings $sitesettings)
    {
        $this->collSitesettingss[]= $sitesettings;
        $sitesettings->setUsers($this);
    }

    /**
     * @param  ChildSitesettings $sitesettings The ChildSitesettings object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeSitesettings(ChildSitesettings $sitesettings)
    {
        if ($this->getSitesettingss()->contains($sitesettings)) {
            $pos = $this->collSitesettingss->search($sitesettings);
            $this->collSitesettingss->remove($pos);
            if (null === $this->sitesettingssScheduledForDeletion) {
                $this->sitesettingssScheduledForDeletion = clone $this->collSitesettingss;
                $this->sitesettingssScheduledForDeletion->clear();
            }
            $this->sitesettingssScheduledForDeletion[]= clone $sitesettings;
            $sitesettings->setUsers(null);
        }

        return $this;
    }

    /**
     * Clears out the collValidationLinks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addValidationLinks()
     */
    public function clearValidationLinks()
    {
        $this->collValidationLinks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collValidationLinks collection loaded partially.
     */
    public function resetPartialValidationLinks($v = true)
    {
        $this->collValidationLinksPartial = $v;
    }

    /**
     * Initializes the collValidationLinks collection.
     *
     * By default this just sets the collValidationLinks collection to an empty array (like clearcollValidationLinks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initValidationLinks($overrideExisting = true)
    {
        if (null !== $this->collValidationLinks && !$overrideExisting) {
            return;
        }

        $collectionClassName = ValidationLinkTableMap::getTableMap()->getCollectionClassName();

        $this->collValidationLinks = new $collectionClassName;
        $this->collValidationLinks->setModel('\ValidationLink');
    }

    /**
     * Gets an array of ChildValidationLink objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildValidationLink[] List of ChildValidationLink objects
     * @throws PropelException
     */
    public function getValidationLinks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collValidationLinksPartial && !$this->isNew();
        if (null === $this->collValidationLinks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collValidationLinks) {
                // return empty collection
                $this->initValidationLinks();
            } else {
                $collValidationLinks = ChildValidationLinkQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collValidationLinksPartial && count($collValidationLinks)) {
                        $this->initValidationLinks(false);

                        foreach ($collValidationLinks as $obj) {
                            if (false == $this->collValidationLinks->contains($obj)) {
                                $this->collValidationLinks->append($obj);
                            }
                        }

                        $this->collValidationLinksPartial = true;
                    }

                    return $collValidationLinks;
                }

                if ($partial && $this->collValidationLinks) {
                    foreach ($this->collValidationLinks as $obj) {
                        if ($obj->isNew()) {
                            $collValidationLinks[] = $obj;
                        }
                    }
                }

                $this->collValidationLinks = $collValidationLinks;
                $this->collValidationLinksPartial = false;
            }
        }

        return $this->collValidationLinks;
    }

    /**
     * Sets a collection of ChildValidationLink objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $validationLinks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setValidationLinks(Collection $validationLinks, ConnectionInterface $con = null)
    {
        /** @var ChildValidationLink[] $validationLinksToDelete */
        $validationLinksToDelete = $this->getValidationLinks(new Criteria(), $con)->diff($validationLinks);

        
        $this->validationLinksScheduledForDeletion = $validationLinksToDelete;

        foreach ($validationLinksToDelete as $validationLinkRemoved) {
            $validationLinkRemoved->setUsers(null);
        }

        $this->collValidationLinks = null;
        foreach ($validationLinks as $validationLink) {
            $this->addValidationLink($validationLink);
        }

        $this->collValidationLinks = $validationLinks;
        $this->collValidationLinksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ValidationLink objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ValidationLink objects.
     * @throws PropelException
     */
    public function countValidationLinks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collValidationLinksPartial && !$this->isNew();
        if (null === $this->collValidationLinks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collValidationLinks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getValidationLinks());
            }

            $query = ChildValidationLinkQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collValidationLinks);
    }

    /**
     * Method called to associate a ChildValidationLink object to this object
     * through the ChildValidationLink foreign key attribute.
     *
     * @param  ChildValidationLink $l ChildValidationLink
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addValidationLink(ChildValidationLink $l)
    {
        if ($this->collValidationLinks === null) {
            $this->initValidationLinks();
            $this->collValidationLinksPartial = true;
        }

        if (!$this->collValidationLinks->contains($l)) {
            $this->doAddValidationLink($l);

            if ($this->validationLinksScheduledForDeletion and $this->validationLinksScheduledForDeletion->contains($l)) {
                $this->validationLinksScheduledForDeletion->remove($this->validationLinksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildValidationLink $validationLink The ChildValidationLink object to add.
     */
    protected function doAddValidationLink(ChildValidationLink $validationLink)
    {
        $this->collValidationLinks[]= $validationLink;
        $validationLink->setUsers($this);
    }

    /**
     * @param  ChildValidationLink $validationLink The ChildValidationLink object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeValidationLink(ChildValidationLink $validationLink)
    {
        if ($this->getValidationLinks()->contains($validationLink)) {
            $pos = $this->collValidationLinks->search($validationLink);
            $this->collValidationLinks->remove($pos);
            if (null === $this->validationLinksScheduledForDeletion) {
                $this->validationLinksScheduledForDeletion = clone $this->collValidationLinks;
                $this->validationLinksScheduledForDeletion->clear();
            }
            $this->validationLinksScheduledForDeletion[]= clone $validationLink;
            $validationLink->setUsers(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->email = null;
        $this->reg_date = null;
        $this->password = null;
        $this->role = null;
        $this->active = null;
        $this->validated = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->user_name = null;
        $this->current_login = null;
        $this->last_login = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCommentss) {
                foreach ($this->collCommentss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCommentsDeleteds) {
                foreach ($this->collCommentsDeleteds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPostss) {
                foreach ($this->collPostss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSitesettingss) {
                foreach ($this->collSitesettingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collValidationLinks) {
                foreach ($this->collValidationLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommentss = null;
        $this->collCommentsDeleteds = null;
        $this->collPostss = null;
        $this->collSitesettingss = null;
        $this->collValidationLinks = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsersTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
