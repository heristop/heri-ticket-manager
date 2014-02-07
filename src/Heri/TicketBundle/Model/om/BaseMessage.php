<?php

namespace Heri\TicketBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Heri\TicketBundle\Model\Message;
use Heri\TicketBundle\Model\MessagePeer;
use Heri\TicketBundle\Model\MessageQuery;
use Heri\TicketBundle\Model\Priority;
use Heri\TicketBundle\Model\PriorityQuery;
use Heri\TicketBundle\Model\Response;
use Heri\TicketBundle\Model\ResponseQuery;
use Heri\TicketBundle\Model\Topic;
use Heri\TicketBundle\Model\TopicQuery;
use Heri\TicketBundle\Model\User;
use Heri\TicketBundle\Model\UserQuery;

abstract class BaseMessage extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Heri\\TicketBundle\\Model\\MessagePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MessagePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the topic_id field.
     * @var        int
     */
    protected $topic_id;

    /**
     * The value for the priority_id field.
     * @var        int
     */
    protected $priority_id;

    /**
     * The value for the assigned_user_id field.
     * @var        int
     */
    protected $assigned_user_id;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the subject field.
     * @var        string
     */
    protected $subject;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the header_mail field.
     * @var        string
     */
    protected $header_mail;

    /**
     * The value for the body field.
     * @var        string
     */
    protected $body;

    /**
     * The value for the ip_address field.
     * @var        string
     */
    protected $ip_address;

    /**
     * The value for the status field.
     * Note: this column has a database default value of: 'opened'
     * @var        string
     */
    protected $status;

    /**
     * The value for the source field.
     * @var        string
     */
    protected $source;

    /**
     * The value for the overdue_date field.
     * @var        string
     */
    protected $overdue_date;

    /**
     * The value for the last_response_date field.
     * @var        string
     */
    protected $last_response_date;

    /**
     * The value for the creation_date field.
     * @var        string
     */
    protected $creation_date;

    /**
     * The value for the modification_date field.
     * @var        string
     */
    protected $modification_date;

    /**
     * @var        Topic
     */
    protected $aTopic;

    /**
     * @var        Priority
     */
    protected $aPriority;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        PropelObjectCollection|Response[] Collection to store aggregation of Response objects.
     */
    protected $collResponses;
    protected $collResponsesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $responsesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 'opened';
    }

    /**
     * Initializes internal state of BaseMessage object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [topic_id] column value.
     *
     * @return int
     */
    public function getMessageId()
    {

        return $this->topic_id;
    }

    /**
     * Get the [priority_id] column value.
     *
     * @return int
     */
    public function getPriorityId()
    {

        return $this->priority_id;
    }

    /**
     * Get the [assigned_user_id] column value.
     *
     * @return int
     */
    public function getAssignedUserId()
    {

        return $this->assigned_user_id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * Get the [subject] column value.
     *
     * @return string
     */
    public function getSubject()
    {

        return $this->subject;
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
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {

        return $this->phone;
    }

    /**
     * Get the [header_mail] column value.
     *
     * @return string
     */
    public function getHeaderMail()
    {

        return $this->header_mail;
    }

    /**
     * Get the [body] column value.
     *
     * @return string
     */
    public function getBody()
    {

        return $this->body;
    }

    /**
     * Get the [ip_address] column value.
     *
     * @return string
     */
    public function getIpAddress()
    {

        return $this->ip_address;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * Get the [source] column value.
     *
     * @return string
     */
    public function getSource()
    {

        return $this->source;
    }

    /**
     * Get the [optionally formatted] temporal [overdue_date] column value.
     *
     * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
     * option in order to avoid conversions to integers (which are limited in the dates they can express).
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw unix timestamp integer will be returned.
     * @return mixed Formatted date/time value as string or (integer) unix timestamp (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getOverdueDate($format = null)
    {
        if ($this->overdue_date === null) {
            return null;
        }

        if ($this->overdue_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->overdue_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->overdue_date, true), $x);
        }

        if ($format === null) {
            // We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
            return (int) $dt->format('U');
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [last_response_date] column value.
     *
     * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
     * option in order to avoid conversions to integers (which are limited in the dates they can express).
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw unix timestamp integer will be returned.
     * @return mixed Formatted date/time value as string or (integer) unix timestamp (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastResponseDate($format = null)
    {
        if ($this->last_response_date === null) {
            return null;
        }

        if ($this->last_response_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->last_response_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_response_date, true), $x);
        }

        if ($format === null) {
            // We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
            return (int) $dt->format('U');
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [creation_date] column value.
     *
     * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
     * option in order to avoid conversions to integers (which are limited in the dates they can express).
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw unix timestamp integer will be returned.
     * @return mixed Formatted date/time value as string or (integer) unix timestamp (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreationDate($format = null)
    {
        if ($this->creation_date === null) {
            return null;
        }

        if ($this->creation_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->creation_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->creation_date, true), $x);
        }

        if ($format === null) {
            // We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
            return (int) $dt->format('U');
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [modification_date] column value.
     *
     * This accessor only only work with unix epoch dates.  Consider enabling the propel.useDateTimeClass
     * option in order to avoid conversions to integers (which are limited in the dates they can express).
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw unix timestamp integer will be returned.
     * @return mixed Formatted date/time value as string or (integer) unix timestamp (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModificationDate($format = null)
    {
        if ($this->modification_date === null) {
            return null;
        }

        if ($this->modification_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->modification_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->modification_date, true), $x);
        }

        if ($format === null) {
            // We cast here to maintain BC in API; obviously we will lose data if we're dealing with pre-/post-epoch dates.
            return (int) $dt->format('U');
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MessagePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [topic_id] column.
     *
     * @param  int $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setMessageId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->topic_id !== $v) {
            $this->topic_id = $v;
            $this->modifiedColumns[] = MessagePeer::TOPIC_ID;
        }

        if ($this->aTopic !== null && $this->aTopic->getId() !== $v) {
            $this->aTopic = null;
        }


        return $this;
    } // setMessageId()

    /**
     * Set the value of [priority_id] column.
     *
     * @param  int $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setPriorityId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->priority_id !== $v) {
            $this->priority_id = $v;
            $this->modifiedColumns[] = MessagePeer::PRIORITY_ID;
        }

        if ($this->aPriority !== null && $this->aPriority->getId() !== $v) {
            $this->aPriority = null;
        }


        return $this;
    } // setPriorityId()

    /**
     * Set the value of [assigned_user_id] column.
     *
     * @param  int $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setAssignedUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->assigned_user_id !== $v) {
            $this->assigned_user_id = $v;
            $this->modifiedColumns[] = MessagePeer::ASSIGNED_USER_ID;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setAssignedUserId()

    /**
     * Set the value of [username] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = MessagePeer::USERNAME;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [subject] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setSubject($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subject !== $v) {
            $this->subject = $v;
            $this->modifiedColumns[] = MessagePeer::SUBJECT;
        }


        return $this;
    } // setSubject()

    /**
     * Set the value of [email] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = MessagePeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = MessagePeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [header_mail] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setHeaderMail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->header_mail !== $v) {
            $this->header_mail = $v;
            $this->modifiedColumns[] = MessagePeer::HEADER_MAIL;
        }


        return $this;
    } // setHeaderMail()

    /**
     * Set the value of [body] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setBody($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->body !== $v) {
            $this->body = $v;
            $this->modifiedColumns[] = MessagePeer::BODY;
        }


        return $this;
    } // setBody()

    /**
     * Set the value of [ip_address] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setIpAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ip_address !== $v) {
            $this->ip_address = $v;
            $this->modifiedColumns[] = MessagePeer::IP_ADDRESS;
        }


        return $this;
    } // setIpAddress()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = MessagePeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [source] column.
     *
     * @param  string $v new value
     * @return Message The current object (for fluent API support)
     */
    public function setSource($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->source !== $v) {
            $this->source = $v;
            $this->modifiedColumns[] = MessagePeer::SOURCE;
        }


        return $this;
    } // setSource()

    /**
     * Sets the value of [overdue_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Message The current object (for fluent API support)
     */
    public function setOverdueDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->overdue_date !== null || $dt !== null) {
            $currentDateAsString = ($this->overdue_date !== null && $tmpDt = new DateTime($this->overdue_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->overdue_date = $newDateAsString;
                $this->modifiedColumns[] = MessagePeer::OVERDUE_DATE;
            }
        } // if either are not null


        return $this;
    } // setOverdueDate()

    /**
     * Sets the value of [last_response_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Message The current object (for fluent API support)
     */
    public function setLastResponseDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_response_date !== null || $dt !== null) {
            $currentDateAsString = ($this->last_response_date !== null && $tmpDt = new DateTime($this->last_response_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->last_response_date = $newDateAsString;
                $this->modifiedColumns[] = MessagePeer::LAST_RESPONSE_DATE;
            }
        } // if either are not null


        return $this;
    } // setLastResponseDate()

    /**
     * Sets the value of [creation_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Message The current object (for fluent API support)
     */
    public function setCreationDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->creation_date !== null || $dt !== null) {
            $currentDateAsString = ($this->creation_date !== null && $tmpDt = new DateTime($this->creation_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->creation_date = $newDateAsString;
                $this->modifiedColumns[] = MessagePeer::CREATION_DATE;
            }
        } // if either are not null


        return $this;
    } // setCreationDate()

    /**
     * Sets the value of [modification_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Message The current object (for fluent API support)
     */
    public function setModificationDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modification_date !== null || $dt !== null) {
            $currentDateAsString = ($this->modification_date !== null && $tmpDt = new DateTime($this->modification_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->modification_date = $newDateAsString;
                $this->modifiedColumns[] = MessagePeer::MODIFICATION_DATE;
            }
        } // if either are not null


        return $this;
    } // setModificationDate()

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
            if ($this->status !== 'opened') {
                return false;
            }

        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->topic_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->priority_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->assigned_user_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->username = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->subject = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->email = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->phone = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->header_mail = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->body = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->ip_address = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->status = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->source = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->overdue_date = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->last_response_date = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->creation_date = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->modification_date = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 17; // 17 = MessagePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Message object", $e);
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

        if ($this->aTopic !== null && $this->topic_id !== $this->aTopic->getId()) {
            $this->aTopic = null;
        }
        if ($this->aPriority !== null && $this->priority_id !== $this->aPriority->getId()) {
            $this->aPriority = null;
        }
        if ($this->aUser !== null && $this->assigned_user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(MessagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MessagePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTopic = null;
            $this->aPriority = null;
            $this->aUser = null;
            $this->collResponses = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(MessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MessageQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(MessagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(MessagePeer::CREATION_DATE)) {
                    $this->setCreationDate(time());
                }
                if (!$this->isColumnModified(MessagePeer::MODIFICATION_DATE)) {
                    $this->setModificationDate(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(MessagePeer::MODIFICATION_DATE)) {
                    $this->setModificationDate(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                MessagePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTopic !== null) {
                if ($this->aTopic->isModified() || $this->aTopic->isNew()) {
                    $affectedRows += $this->aTopic->save($con);
                }
                $this->setTopic($this->aTopic);
            }

            if ($this->aPriority !== null) {
                if ($this->aPriority->isModified() || $this->aPriority->isNew()) {
                    $affectedRows += $this->aPriority->save($con);
                }
                $this->setPriority($this->aPriority);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->responsesScheduledForDeletion !== null) {
                if (!$this->responsesScheduledForDeletion->isEmpty()) {
                    ResponseQuery::create()
                        ->filterByPrimaryKeys($this->responsesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->responsesScheduledForDeletion = null;
                }
            }

            if ($this->collResponses !== null) {
                foreach ($this->collResponses as $referrerFK) {
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
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = MessagePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MessagePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MessagePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MessagePeer::TOPIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`topic_id`';
        }
        if ($this->isColumnModified(MessagePeer::PRIORITY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`priority_id`';
        }
        if ($this->isColumnModified(MessagePeer::ASSIGNED_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`assigned_user_id`';
        }
        if ($this->isColumnModified(MessagePeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`username`';
        }
        if ($this->isColumnModified(MessagePeer::SUBJECT)) {
            $modifiedColumns[':p' . $index++]  = '`subject`';
        }
        if ($this->isColumnModified(MessagePeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(MessagePeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(MessagePeer::HEADER_MAIL)) {
            $modifiedColumns[':p' . $index++]  = '`header_mail`';
        }
        if ($this->isColumnModified(MessagePeer::BODY)) {
            $modifiedColumns[':p' . $index++]  = '`body`';
        }
        if ($this->isColumnModified(MessagePeer::IP_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`ip_address`';
        }
        if ($this->isColumnModified(MessagePeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(MessagePeer::SOURCE)) {
            $modifiedColumns[':p' . $index++]  = '`source`';
        }
        if ($this->isColumnModified(MessagePeer::OVERDUE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`overdue_date`';
        }
        if ($this->isColumnModified(MessagePeer::LAST_RESPONSE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`last_response_date`';
        }
        if ($this->isColumnModified(MessagePeer::CREATION_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`creation_date`';
        }
        if ($this->isColumnModified(MessagePeer::MODIFICATION_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`modification_date`';
        }

        $sql = sprintf(
            'INSERT INTO `message` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`topic_id`':
                        $stmt->bindValue($identifier, $this->topic_id, PDO::PARAM_INT);
                        break;
                    case '`priority_id`':
                        $stmt->bindValue($identifier, $this->priority_id, PDO::PARAM_INT);
                        break;
                    case '`assigned_user_id`':
                        $stmt->bindValue($identifier, $this->assigned_user_id, PDO::PARAM_INT);
                        break;
                    case '`username`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`subject`':
                        $stmt->bindValue($identifier, $this->subject, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`header_mail`':
                        $stmt->bindValue($identifier, $this->header_mail, PDO::PARAM_STR);
                        break;
                    case '`body`':
                        $stmt->bindValue($identifier, $this->body, PDO::PARAM_STR);
                        break;
                    case '`ip_address`':
                        $stmt->bindValue($identifier, $this->ip_address, PDO::PARAM_STR);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case '`source`':
                        $stmt->bindValue($identifier, $this->source, PDO::PARAM_STR);
                        break;
                    case '`overdue_date`':
                        $stmt->bindValue($identifier, $this->overdue_date, PDO::PARAM_STR);
                        break;
                    case '`last_response_date`':
                        $stmt->bindValue($identifier, $this->last_response_date, PDO::PARAM_STR);
                        break;
                    case '`creation_date`':
                        $stmt->bindValue($identifier, $this->creation_date, PDO::PARAM_STR);
                        break;
                    case '`modification_date`':
                        $stmt->bindValue($identifier, $this->modification_date, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTopic !== null) {
                if (!$this->aTopic->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aTopic->getValidationFailures());
                }
            }

            if ($this->aPriority !== null) {
                if (!$this->aPriority->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPriority->getValidationFailures());
                }
            }

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }


            if (($retval = MessagePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collResponses !== null) {
                    foreach ($this->collResponses as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getMessageId();
                break;
            case 2:
                return $this->getPriorityId();
                break;
            case 3:
                return $this->getAssignedUserId();
                break;
            case 4:
                return $this->getUsername();
                break;
            case 5:
                return $this->getSubject();
                break;
            case 6:
                return $this->getEmail();
                break;
            case 7:
                return $this->getPhone();
                break;
            case 8:
                return $this->getHeaderMail();
                break;
            case 9:
                return $this->getBody();
                break;
            case 10:
                return $this->getIpAddress();
                break;
            case 11:
                return $this->getStatus();
                break;
            case 12:
                return $this->getSource();
                break;
            case 13:
                return $this->getOverdueDate();
                break;
            case 14:
                return $this->getLastResponseDate();
                break;
            case 15:
                return $this->getCreationDate();
                break;
            case 16:
                return $this->getModificationDate();
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
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Message'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Message'][$this->getPrimaryKey()] = true;
        $keys = MessagePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getMessageId(),
            $keys[2] => $this->getPriorityId(),
            $keys[3] => $this->getAssignedUserId(),
            $keys[4] => $this->getUsername(),
            $keys[5] => $this->getSubject(),
            $keys[6] => $this->getEmail(),
            $keys[7] => $this->getPhone(),
            $keys[8] => $this->getHeaderMail(),
            $keys[9] => $this->getBody(),
            $keys[10] => $this->getIpAddress(),
            $keys[11] => $this->getStatus(),
            $keys[12] => $this->getSource(),
            $keys[13] => $this->getOverdueDate(),
            $keys[14] => $this->getLastResponseDate(),
            $keys[15] => $this->getCreationDate(),
            $keys[16] => $this->getModificationDate(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTopic) {
                $result['Topic'] = $this->aTopic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPriority) {
                $result['Priority'] = $this->aPriority->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collResponses) {
                $result['Responses'] = $this->collResponses->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = MessagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setMessageId($value);
                break;
            case 2:
                $this->setPriorityId($value);
                break;
            case 3:
                $this->setAssignedUserId($value);
                break;
            case 4:
                $this->setUsername($value);
                break;
            case 5:
                $this->setSubject($value);
                break;
            case 6:
                $this->setEmail($value);
                break;
            case 7:
                $this->setPhone($value);
                break;
            case 8:
                $this->setHeaderMail($value);
                break;
            case 9:
                $this->setBody($value);
                break;
            case 10:
                $this->setIpAddress($value);
                break;
            case 11:
                $this->setStatus($value);
                break;
            case 12:
                $this->setSource($value);
                break;
            case 13:
                $this->setOverdueDate($value);
                break;
            case 14:
                $this->setLastResponseDate($value);
                break;
            case 15:
                $this->setCreationDate($value);
                break;
            case 16:
                $this->setModificationDate($value);
                break;
        } // switch()
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = MessagePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setMessageId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPriorityId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAssignedUserId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUsername($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSubject($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setEmail($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPhone($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setHeaderMail($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBody($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIpAddress($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setStatus($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setSource($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setOverdueDate($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setLastResponseDate($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setCreationDate($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setModificationDate($arr[$keys[16]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MessagePeer::DATABASE_NAME);

        if ($this->isColumnModified(MessagePeer::ID)) $criteria->add(MessagePeer::ID, $this->id);
        if ($this->isColumnModified(MessagePeer::TOPIC_ID)) $criteria->add(MessagePeer::TOPIC_ID, $this->topic_id);
        if ($this->isColumnModified(MessagePeer::PRIORITY_ID)) $criteria->add(MessagePeer::PRIORITY_ID, $this->priority_id);
        if ($this->isColumnModified(MessagePeer::ASSIGNED_USER_ID)) $criteria->add(MessagePeer::ASSIGNED_USER_ID, $this->assigned_user_id);
        if ($this->isColumnModified(MessagePeer::USERNAME)) $criteria->add(MessagePeer::USERNAME, $this->username);
        if ($this->isColumnModified(MessagePeer::SUBJECT)) $criteria->add(MessagePeer::SUBJECT, $this->subject);
        if ($this->isColumnModified(MessagePeer::EMAIL)) $criteria->add(MessagePeer::EMAIL, $this->email);
        if ($this->isColumnModified(MessagePeer::PHONE)) $criteria->add(MessagePeer::PHONE, $this->phone);
        if ($this->isColumnModified(MessagePeer::HEADER_MAIL)) $criteria->add(MessagePeer::HEADER_MAIL, $this->header_mail);
        if ($this->isColumnModified(MessagePeer::BODY)) $criteria->add(MessagePeer::BODY, $this->body);
        if ($this->isColumnModified(MessagePeer::IP_ADDRESS)) $criteria->add(MessagePeer::IP_ADDRESS, $this->ip_address);
        if ($this->isColumnModified(MessagePeer::STATUS)) $criteria->add(MessagePeer::STATUS, $this->status);
        if ($this->isColumnModified(MessagePeer::SOURCE)) $criteria->add(MessagePeer::SOURCE, $this->source);
        if ($this->isColumnModified(MessagePeer::OVERDUE_DATE)) $criteria->add(MessagePeer::OVERDUE_DATE, $this->overdue_date);
        if ($this->isColumnModified(MessagePeer::LAST_RESPONSE_DATE)) $criteria->add(MessagePeer::LAST_RESPONSE_DATE, $this->last_response_date);
        if ($this->isColumnModified(MessagePeer::CREATION_DATE)) $criteria->add(MessagePeer::CREATION_DATE, $this->creation_date);
        if ($this->isColumnModified(MessagePeer::MODIFICATION_DATE)) $criteria->add(MessagePeer::MODIFICATION_DATE, $this->modification_date);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(MessagePeer::DATABASE_NAME);
        $criteria->add(MessagePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Message (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMessageId($this->getMessageId());
        $copyObj->setPriorityId($this->getPriorityId());
        $copyObj->setAssignedUserId($this->getAssignedUserId());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setSubject($this->getSubject());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setHeaderMail($this->getHeaderMail());
        $copyObj->setBody($this->getBody());
        $copyObj->setIpAddress($this->getIpAddress());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setSource($this->getSource());
        $copyObj->setOverdueDate($this->getOverdueDate());
        $copyObj->setLastResponseDate($this->getLastResponseDate());
        $copyObj->setCreationDate($this->getCreationDate());
        $copyObj->setModificationDate($this->getModificationDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getResponses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addResponse($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Message Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return MessagePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MessagePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Topic object.
     *
     * @param                  Topic $v
     * @return Message The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTopic(Topic $v = null)
    {
        if ($v === null) {
            $this->setMessageId(NULL);
        } else {
            $this->setMessageId($v->getId());
        }

        $this->aTopic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Topic object, it will not be re-added.
        if ($v !== null) {
            $v->addMessage($this);
        }


        return $this;
    }


    /**
     * Get the associated Topic object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Topic The associated Topic object.
     * @throws PropelException
     */
    public function getTopic(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aTopic === null && ($this->topic_id !== null) && $doQuery) {
            $this->aTopic = TopicQuery::create()->findPk($this->topic_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTopic->addMessages($this);
             */
        }

        return $this->aTopic;
    }

    /**
     * Declares an association between this object and a Priority object.
     *
     * @param                  Priority $v
     * @return Message The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPriority(Priority $v = null)
    {
        if ($v === null) {
            $this->setPriorityId(NULL);
        } else {
            $this->setPriorityId($v->getId());
        }

        $this->aPriority = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Priority object, it will not be re-added.
        if ($v !== null) {
            $v->addMessage($this);
        }


        return $this;
    }


    /**
     * Get the associated Priority object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Priority The associated Priority object.
     * @throws PropelException
     */
    public function getPriority(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPriority === null && ($this->priority_id !== null) && $doQuery) {
            $this->aPriority = PriorityQuery::create()->findPk($this->priority_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPriority->addMessages($this);
             */
        }

        return $this->aPriority;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param                  User $v
     * @return Message The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setAssignedUserId(NULL);
        } else {
            $this->setAssignedUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addMessage($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUser === null && ($this->assigned_user_id !== null) && $doQuery) {
            $this->aUser = UserQuery::create()->findPk($this->assigned_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addMessages($this);
             */
        }

        return $this->aUser;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Response' == $relationName) {
            $this->initResponses();
        }
    }

    /**
     * Clears out the collResponses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Message The current object (for fluent API support)
     * @see        addResponses()
     */
    public function clearResponses()
    {
        $this->collResponses = null; // important to set this to null since that means it is uninitialized
        $this->collResponsesPartial = null;

        return $this;
    }

    /**
     * reset is the collResponses collection loaded partially
     *
     * @return void
     */
    public function resetPartialResponses($v = true)
    {
        $this->collResponsesPartial = $v;
    }

    /**
     * Initializes the collResponses collection.
     *
     * By default this just sets the collResponses collection to an empty array (like clearcollResponses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initResponses($overrideExisting = true)
    {
        if (null !== $this->collResponses && !$overrideExisting) {
            return;
        }
        $this->collResponses = new PropelObjectCollection();
        $this->collResponses->setModel('Response');
    }

    /**
     * Gets an array of Response objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Message is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Response[] List of Response objects
     * @throws PropelException
     */
    public function getResponses($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collResponsesPartial && !$this->isNew();
        if (null === $this->collResponses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collResponses) {
                // return empty collection
                $this->initResponses();
            } else {
                $collResponses = ResponseQuery::create(null, $criteria)
                    ->filterByMessage($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collResponsesPartial && count($collResponses)) {
                      $this->initResponses(false);

                      foreach ($collResponses as $obj) {
                        if (false == $this->collResponses->contains($obj)) {
                          $this->collResponses->append($obj);
                        }
                      }

                      $this->collResponsesPartial = true;
                    }

                    $collResponses->getInternalIterator()->rewind();

                    return $collResponses;
                }

                if ($partial && $this->collResponses) {
                    foreach ($this->collResponses as $obj) {
                        if ($obj->isNew()) {
                            $collResponses[] = $obj;
                        }
                    }
                }

                $this->collResponses = $collResponses;
                $this->collResponsesPartial = false;
            }
        }

        return $this->collResponses;
    }

    /**
     * Sets a collection of Response objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $responses A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Message The current object (for fluent API support)
     */
    public function setResponses(PropelCollection $responses, PropelPDO $con = null)
    {
        $responsesToDelete = $this->getResponses(new Criteria(), $con)->diff($responses);


        $this->responsesScheduledForDeletion = $responsesToDelete;

        foreach ($responsesToDelete as $responseRemoved) {
            $responseRemoved->setMessage(null);
        }

        $this->collResponses = null;
        foreach ($responses as $response) {
            $this->addResponse($response);
        }

        $this->collResponses = $responses;
        $this->collResponsesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Response objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Response objects.
     * @throws PropelException
     */
    public function countResponses(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collResponsesPartial && !$this->isNew();
        if (null === $this->collResponses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collResponses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getResponses());
            }
            $query = ResponseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMessage($this)
                ->count($con);
        }

        return count($this->collResponses);
    }

    /**
     * Method called to associate a Response object to this object
     * through the Response foreign key attribute.
     *
     * @param    Response $l Response
     * @return Message The current object (for fluent API support)
     */
    public function addResponse(Response $l)
    {
        if ($this->collResponses === null) {
            $this->initResponses();
            $this->collResponsesPartial = true;
        }

        if (!in_array($l, $this->collResponses->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddResponse($l);

            if ($this->responsesScheduledForDeletion and $this->responsesScheduledForDeletion->contains($l)) {
                $this->responsesScheduledForDeletion->remove($this->responsesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Response $response The response object to add.
     */
    protected function doAddResponse($response)
    {
        $this->collResponses[]= $response;
        $response->setMessage($this);
    }

    /**
     * @param	Response $response The response object to remove.
     * @return Message The current object (for fluent API support)
     */
    public function removeResponse($response)
    {
        if ($this->getResponses()->contains($response)) {
            $this->collResponses->remove($this->collResponses->search($response));
            if (null === $this->responsesScheduledForDeletion) {
                $this->responsesScheduledForDeletion = clone $this->collResponses;
                $this->responsesScheduledForDeletion->clear();
            }
            $this->responsesScheduledForDeletion[]= clone $response;
            $response->setMessage(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Message is new, it will return
     * an empty collection; or if this Message has previously
     * been saved, it will retrieve related Responses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Message.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Response[] List of Response objects
     */
    public function getResponsesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ResponseQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getResponses($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->topic_id = null;
        $this->priority_id = null;
        $this->assigned_user_id = null;
        $this->username = null;
        $this->subject = null;
        $this->email = null;
        $this->phone = null;
        $this->header_mail = null;
        $this->body = null;
        $this->ip_address = null;
        $this->status = null;
        $this->source = null;
        $this->overdue_date = null;
        $this->last_response_date = null;
        $this->creation_date = null;
        $this->modification_date = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collResponses) {
                foreach ($this->collResponses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aTopic instanceof Persistent) {
              $this->aTopic->clearAllReferences($deep);
            }
            if ($this->aPriority instanceof Persistent) {
              $this->aPriority->clearAllReferences($deep);
            }
            if ($this->aUser instanceof Persistent) {
              $this->aUser->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collResponses instanceof PropelCollection) {
            $this->collResponses->clearIterator();
        }
        $this->collResponses = null;
        $this->aTopic = null;
        $this->aPriority = null;
        $this->aUser = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MessagePeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     Message The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = MessagePeer::MODIFICATION_DATE;

        return $this;
    }

}
