<?php

namespace Heri\TicketBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Heri\TicketBundle\Model\Message;
use Heri\TicketBundle\Model\Response;
use Heri\TicketBundle\Model\ResponsePeer;
use Heri\TicketBundle\Model\ResponseQuery;
use Heri\TicketBundle\Model\User;

/**
 * @method ResponseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ResponseQuery orderByMessageId($order = Criteria::ASC) Order by the message_id column
 * @method ResponseQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method ResponseQuery orderByBody($order = Criteria::ASC) Order by the body column
 * @method ResponseQuery orderByIpAddress($order = Criteria::ASC) Order by the ip_address column
 * @method ResponseQuery orderByCreationDate($order = Criteria::ASC) Order by the creation_date column
 * @method ResponseQuery orderByModificationDate($order = Criteria::ASC) Order by the modification_date column
 *
 * @method ResponseQuery groupById() Group by the id column
 * @method ResponseQuery groupByMessageId() Group by the message_id column
 * @method ResponseQuery groupByUserId() Group by the user_id column
 * @method ResponseQuery groupByBody() Group by the body column
 * @method ResponseQuery groupByIpAddress() Group by the ip_address column
 * @method ResponseQuery groupByCreationDate() Group by the creation_date column
 * @method ResponseQuery groupByModificationDate() Group by the modification_date column
 *
 * @method ResponseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ResponseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ResponseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ResponseQuery leftJoinMessage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Message relation
 * @method ResponseQuery rightJoinMessage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Message relation
 * @method ResponseQuery innerJoinMessage($relationAlias = null) Adds a INNER JOIN clause to the query using the Message relation
 *
 * @method ResponseQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method ResponseQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method ResponseQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Response findOne(PropelPDO $con = null) Return the first Response matching the query
 * @method Response findOneOrCreate(PropelPDO $con = null) Return the first Response matching the query, or a new Response object populated from the query conditions when no match is found
 *
 * @method Response findOneByMessageId(int $message_id) Return the first Response filtered by the message_id column
 * @method Response findOneByUserId(int $user_id) Return the first Response filtered by the user_id column
 * @method Response findOneByBody(string $body) Return the first Response filtered by the body column
 * @method Response findOneByIpAddress(string $ip_address) Return the first Response filtered by the ip_address column
 * @method Response findOneByCreationDate(string $creation_date) Return the first Response filtered by the creation_date column
 * @method Response findOneByModificationDate(string $modification_date) Return the first Response filtered by the modification_date column
 *
 * @method array findById(int $id) Return Response objects filtered by the id column
 * @method array findByMessageId(int $message_id) Return Response objects filtered by the message_id column
 * @method array findByUserId(int $user_id) Return Response objects filtered by the user_id column
 * @method array findByBody(string $body) Return Response objects filtered by the body column
 * @method array findByIpAddress(string $ip_address) Return Response objects filtered by the ip_address column
 * @method array findByCreationDate(string $creation_date) Return Response objects filtered by the creation_date column
 * @method array findByModificationDate(string $modification_date) Return Response objects filtered by the modification_date column
 */
abstract class BaseResponseQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseResponseQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Heri\\TicketBundle\\Model\\Response';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ResponseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ResponseQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ResponseQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ResponseQuery) {
            return $criteria;
        }
        $query = new ResponseQuery(null, null, $modelAlias);

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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Response|Response[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ResponsePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ResponsePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Response A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Response A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `message_id`, `user_id`, `body`, `ip_address`, `creation_date`, `modification_date` FROM `response` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Response();
            $obj->hydrate($row);
            ResponsePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Response|Response[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Response[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ResponsePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ResponsePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ResponsePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ResponsePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponsePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the message_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMessageId(1234); // WHERE message_id = 1234
     * $query->filterByMessageId(array(12, 34)); // WHERE message_id IN (12, 34)
     * $query->filterByMessageId(array('min' => 12)); // WHERE message_id >= 12
     * $query->filterByMessageId(array('max' => 12)); // WHERE message_id <= 12
     * </code>
     *
     * @see       filterByMessage()
     *
     * @param     mixed $messageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByMessageId($messageId = null, $comparison = null)
    {
        if (is_array($messageId)) {
            $useMinMax = false;
            if (isset($messageId['min'])) {
                $this->addUsingAlias(ResponsePeer::MESSAGE_ID, $messageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($messageId['max'])) {
                $this->addUsingAlias(ResponsePeer::MESSAGE_ID, $messageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponsePeer::MESSAGE_ID, $messageId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id >= 12
     * $query->filterByUserId(array('max' => 12)); // WHERE user_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ResponsePeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ResponsePeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponsePeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody('fooValue');   // WHERE body = 'fooValue'
     * $query->filterByBody('%fooValue%'); // WHERE body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $body The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByBody($body = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($body)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $body)) {
                $body = str_replace('*', '%', $body);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ResponsePeer::BODY, $body, $comparison);
    }

    /**
     * Filter the query on the ip_address column
     *
     * Example usage:
     * <code>
     * $query->filterByIpAddress('fooValue');   // WHERE ip_address = 'fooValue'
     * $query->filterByIpAddress('%fooValue%'); // WHERE ip_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ipAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByIpAddress($ipAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ipAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ipAddress)) {
                $ipAddress = str_replace('*', '%', $ipAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ResponsePeer::IP_ADDRESS, $ipAddress, $comparison);
    }

    /**
     * Filter the query on the creation_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCreationDate('2011-03-14'); // WHERE creation_date = '2011-03-14'
     * $query->filterByCreationDate('now'); // WHERE creation_date = '2011-03-14'
     * $query->filterByCreationDate(array('max' => 'yesterday')); // WHERE creation_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $creationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByCreationDate($creationDate = null, $comparison = null)
    {
        if (is_array($creationDate)) {
            $useMinMax = false;
            if (isset($creationDate['min'])) {
                $this->addUsingAlias(ResponsePeer::CREATION_DATE, $creationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creationDate['max'])) {
                $this->addUsingAlias(ResponsePeer::CREATION_DATE, $creationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponsePeer::CREATION_DATE, $creationDate, $comparison);
    }

    /**
     * Filter the query on the modification_date column
     *
     * Example usage:
     * <code>
     * $query->filterByModificationDate('2011-03-14'); // WHERE modification_date = '2011-03-14'
     * $query->filterByModificationDate('now'); // WHERE modification_date = '2011-03-14'
     * $query->filterByModificationDate(array('max' => 'yesterday')); // WHERE modification_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $modificationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function filterByModificationDate($modificationDate = null, $comparison = null)
    {
        if (is_array($modificationDate)) {
            $useMinMax = false;
            if (isset($modificationDate['min'])) {
                $this->addUsingAlias(ResponsePeer::MODIFICATION_DATE, $modificationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modificationDate['max'])) {
                $this->addUsingAlias(ResponsePeer::MODIFICATION_DATE, $modificationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponsePeer::MODIFICATION_DATE, $modificationDate, $comparison);
    }

    /**
     * Filter the query by a related Message object
     *
     * @param   Message|PropelObjectCollection $message The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ResponseQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMessage($message, $comparison = null)
    {
        if ($message instanceof Message) {
            return $this
                ->addUsingAlias(ResponsePeer::MESSAGE_ID, $message->getId(), $comparison);
        } elseif ($message instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResponsePeer::MESSAGE_ID, $message->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMessage() only accepts arguments of type Message or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Message relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function joinMessage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Message');

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
            $this->addJoinObject($join, 'Message');
        }

        return $this;
    }

    /**
     * Use the Message relation Message object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Heri\TicketBundle\Model\MessageQuery A secondary query class using the current class as primary query
     */
    public function useMessageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMessage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Message', '\Heri\TicketBundle\Model\MessageQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ResponseQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ResponsePeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResponsePeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Heri\TicketBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Heri\TicketBundle\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Response $response Object to remove from the list of results
     *
     * @return ResponseQuery The current query, for fluid interface
     */
    public function prune($response = null)
    {
        if ($response) {
            $this->addUsingAlias(ResponsePeer::ID, $response->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // senchagridable behavior

    /**
     * Paginate results
     *
     * @param Symfony\Component\HttpFoundation\ParameterBag
     * @return ResponseQuery
     */
    public function paginateGrid($params)
    {
        return $this
            ->addGridFiltersQuery($params)
            ->addGridSortQuery($params)
            ->paginate(
                $params->get('page'),
                $params->get('limit')
            );
    }

    /**
     * Added sort filter on query
     *
     * @param Symfony\Component\HttpFoundation\ParameterBag
     * @return ResponseQuery
     */
    public function addGridSortQuery($params)
    {
        if ($params->get('sort')) {
            $sorts = json_decode($params->get('sort'));
            foreach ($sorts as $sort) {
                $orderBy = "orderBy".ucfirst($sort->property);
                $this->$orderBy(strtolower($sort->direction));
            }
        }

        return $this;
    }

    /**
     * Added sort filter on query
     *
     * @param Symfony\Component\HttpFoundation\ParameterBag
     * @return ResponseQuery
     */
    public function addGridFiltersQuery($params)
    {
        $i = 0;
        $fields = $this->getFields($params);
        if (!empty($fields)) {
            $orConds = array();
            foreach ($fields as $field) {
                $this->condition(
                    "cond$i",
                    'Heri\TicketBundle\Model\Response.'.ucfirst($field).' LIKE ?',
                    "%{$params->get('query')}%"
                );

                $orConds[] = "cond$i";
                $i++;
            }

            $this->where($orConds, 'or');
        }

        $filter = $this->getFilter($params);
        if (!empty($filter)) {
            $andConds = array();
            $count = count($filter);
            for ($j = 0; $j < $count; $j++) {

                switch($filter[$j]['data']['type']) {
                    case 'string': {
                        $this->condition(
                            "cond$i",
                            'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' LIKE ?',
                            "%{$filter[$j]['data']['value']}%"
                        ); break;
                    }
                    case 'list': {
                        if (strstr($filter[$j]['data']['value'], ',')) {
                            $this->condition(
                                "cond$i",
                                'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' IN ?',
                                explode(',', $filter[$j]['data']['value'])
                            );
                        } else {
                            $this->condition(
                                "cond$i",
                                'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' = ?',
                                $filter[$j]['data']['value']
                            );
                        } break;
                    }
                    case 'boolean': {
                        $this->condition(
                            "cond$i",
                            'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' = ?',
                            "{$filter[$j]['data']['value']}"
                        ); break;
                    }
                    case 'numeric': {
                        switch ($filter[$j]['data']['comparison']) {
                            case 'ne': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' != ?',
                                    "{$filter[$j]['data']['value']}"
                                ); break;
                            }
                            case 'eq': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' = ?',
                                    "{$filter[$j]['data']['value']}"
                                ); break;
                            }
                            case 'lt': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' < ?',
                                    "{$filter[$j]['data']['value']}"
                                ); break;
                            }
                            case 'gt': {
                                 $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' > ?',
                                    "{$filter[$j]['data']['value']}"
                                ); break;
                            }
                        } break;
                    }
                    case 'date': {

                        switch ($filter[$j]['data']['comparison']) {
                            case 'ne': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' != ?',
                                    date('Y-m-d', strtotime($filter[$j]['data']['value']))
                                ); break;
                            }
                            case 'eq': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' = ?',
                                    date('Y-m-d', strtotime($filter[$j]['data']['value']))
                                ); break;
                            }
                            case 'lt': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' < ?',
                                    date('Y-m-d', strtotime($filter[$j]['data']['value']))
                                ); break;
                            }
                            case 'gt': {
                                $this->condition(
                                    "cond$i",
                                    'Heri\TicketBundle\Model\Response.'.ucfirst($filter[$j]['field']).' > ?',
                                    date('Y-m-d', strtotime($filtrer[$j]['data']['value']))
                                ); break;
                            }
                        }
                    } break;
                }
                $andConds[] = "cond$i";
                $i++;
            }
            if (!empty($andConds)) $this->where($andConds, 'and');
        }

        return $this;
    }

    /**
     * Get fields from request
     *
     * @param Symfony\Component\HttpFoundation\ParameterBag
     * @return array
     */
    protected function getFields($params) {
        return json_decode($params->get('fields'));
    }

    /**
     * Get filter from request
     *
     * @param Symfony\Component\HttpFoundation\ParameterBag
     * @return array
     */
    protected function getFilter($params) {
        return $params->get('filter');
    }


}
