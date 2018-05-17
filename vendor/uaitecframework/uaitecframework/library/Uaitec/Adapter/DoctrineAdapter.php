<?php

namespace Util\Authentication;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface,
    \Zend\Authentication\Result;

class DoctrineAdapter implements AdapterInterface {

    const RETURN_TYPE_STDOBJECT = 1;
    const RETURN_TYPE_NATIVE = 2;

    /**
     * Database Connection
     * 
     * 
     * @var \Doctrine\Orm\EntityManager
     */
    protected $entityManager;

    /**
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qbSelect;

    /**
     * 
     * @var string
     */
    protected $entityName;

    /**
     * $identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $identityColumn = null;

    /**
     * $credentialColumns - columns to be used as the credentials
     *
     * @var string
     */
    protected $credentialColumn = null;

    /**
     * $identity - Identity value
     *
     * @var string
     */
    protected $identity = null;

    /**
     * $credential - Credential values
     *
     * @var string
     */
    protected $credential = null;

    /**
     * $credentialTreatment - Treatment applied to the credential, such as MD5() or PASSWORD()
     *
     * @var string
     */
    protected $credentialTreatment = null;

    /**
     * $authenticateResultInfo
     *
     * @var array
     */
    protected $authenticateResultInfo = null;

    /**
     * $resultRow - Results of database authentication query
     *
     * @var array
     */
    protected $resultRow = null;

    /**
     * $ambiguityIdentity - Flag to indicate same Identity can be used with
     * different credentials. Default is FALSE and need to be set to true to
     * allow ambiguity usage.
     *
     * @var boolean
     */
    protected $ambiguityIdentity = false;

    public function __construct(EntityManager $entityManager, $entityName = null, $identityColumn = null, $credentialColumn = null, $credentialTreatment = null) {

        $this->entityManager = $entityManager;

        if (null !== $entityName) {
            $this->setEntityName($entityName);
        }

        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) {
            $this->setCredentialColumn($credentialColumn);
        }

        if (null !== $credentialTreatment) {
            $this->setCredentialTreatment($credentialTreatment);
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate() {

        $this->_authenticateSetup();
        $select = $this->createSelect();
        $result = $this->querySelect($select);

        if (($authResult = $this->_authenticateValidateResultset($result)) instanceof \Zend\Authentication\Result) {
            return $authResult;
        }

        $authResult = $this->_authenticateValidateResult(array_shift($result));
        return $authResult;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function createSelect() {
        // build credential expression
        /* if (empty($this->credentialTreatment) || (strpos($this->credentialTreatment, '?') === false)) {
          $this->credentialTreatment = '?';
          } */

        $qb = $this->entityManager->createQueryBuilder();
        $qb->from($this->entityName, 'q');
        $qb->addSelect('q');
        $qb->addSelect("(CASE WHEN q." . $this->credentialColumn . " = :credential THEN 1 ELSE 0 END) AS zend_auth_credential_match");
        $qb->where('q.' . $this->identityColumn . " = :identity");
        $qb->setParameter('identity', $this->getIdentity());
        $qb->setParameter('credential', $this->getCredential());

        return $qb;
    }

    private function querySelect(\Doctrine\ORM\QueryBuilder $query) {

        try {
            $resultO = $query->getQuery()->getResult();
        } catch (\Exception $e) {
            throw new \Zend\Authentication\Adapter\Exception\RuntimeException('The supplied parameters to Zend_Auth_Adapter_Doctrine_Record failed to '
            . 'produce a valid sql statement, please check table and column names '
            . 'for validity.');
        }
        return $resultO;
    }

    /**
     * getResultRowObject() - Returns the result row as a stdClass object
     *
     * @param  string|array $returnColumns
     * @param  string|array $omitColumns
     * @return stdClass|boolean
     */
    public function getResultRowObject($returnType = self::RETURN_TYPE_STDOBJECT, $returnColumns = null, $omitColumns = null) {
        if (!$this->resultRow) {
            return false;
        }

        if ($returnType == self::RETURN_TYPE_STDOBJECT) {
            $returnObject = new \stdClass();

            if (null !== $returnColumns) {

                $availableColumns = array_keys($this->resultRow);
                foreach ((array) $returnColumns as $returnColumn) {
                    if (in_array($returnColumn, $availableColumns)) {
                        $returnObject->{$returnColumn} = $this->resultRow[$returnColumn];
                    }
                }
                return $returnObject;
            } elseif (null !== $omitColumns) {

                $omitColumns = (array) $omitColumns;
                foreach ($this->resultRow as $resultColumn => $resultValue) {
                    if (!in_array($resultColumn, $omitColumns)) {
                        $returnObject->{$resultColumn} = $resultValue;
                    }
                }
                return $returnObject;
            } else {

                foreach ($this->resultRow as $resultColumn => $resultValue) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
                return $returnObject;
            }
        } elseif ($returnType == self::RETURN_TYPE_NATIVE) {
            return $this->resultRow;
        }
    }

    public function getEntityName() {
        return $this->entityName;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function getIdentityColumn() {
        return $this->identityColumn;
    }

    public function setIdentityColumn($identityColumn) {
        $this->identityColumn = $identityColumn;
    }

    public function getCredentialColumn() {
        return $this->credentialColumn;
    }

    public function setCredentialColumn($credentialColumn) {
        $this->credentialColumn = $credentialColumn;
    }

    public function getIdentity() {
        return $this->identity;
    }

    public function setIdentity($identity) {
        $this->identity = $identity;
    }

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential($credential) {
        $this->credential = $credential;
    }

    public function getCredentialTreatment() {
        return $this->credentialTreatment;
    }

    public function setCredentialTreatment($credentialTreatment) {
        $this->credentialTreatment = $credentialTreatment;
    }

    /**
     * setAmbiguityIdentity() - sets a flag for usage of identical identities
     * with unique credentials. It accepts integers (0, 1) or boolean (true,
     * false) parameters. Default is false.
     *
     * @param  int|bool $flag
     * @return DbTable Provides a fluent interface
     */
    public function setAmbiguityIdentity($flag) {
        if (is_integer($flag)) {
            $this->ambiguityIdentity = (1 === $flag ? true : false);
        } elseif (is_bool($flag)) {
            $this->ambiguityIdentity = $flag;
        }
        return $this;
    }

    /**
     * getAmbiguityIdentity() - returns TRUE for usage of multiple identical
     * identities with different credentials, FALSE if not used.
     *
     * @return bool
     */
    public function getAmbiguityIdentity() {
        return $this->ambiguityIdentity;
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with
     * making sure that this adapter was indeed setup properly with all
     * required pieces of information.
     *
     * @throws Exception\RuntimeException in the event that setup was not done properly
     * @return boolean
     */
    protected function _authenticateSetup() {
        $exception = null;

        if ($this->entityName == '') {
            $exception = 'A entity name must be supplied for the DoctrineAdapter authentication adapter.';
        } elseif ($this->identityColumn == '') {
            $exception = 'An identity column must be supplied for the DoctrineAdapter authentication adapter.';
        } elseif ($this->credentialColumn == '') {
            $exception = 'A credential column must be supplied for the DoctrineAdapter authentication adapter.';
        } elseif ($this->identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with EntityManager.';
        } elseif ($this->credential === null) {
            $exception = 'A credential value was not provided prior to authentication with EntityManager.';
        }

        if (null !== $exception) {
            throw new \Zend\Authentication\Adapter\Exception\RuntimeException($exception);
        }

        $this->authenticateResultInfo = array(
            'code' => \Zend\Authentication\Result::FAILURE,
            'identity' => $this->identity,
            'messages' => array()
        );

        return true;
    }

    /**
     * _authenticateValidateResultSet() - This method attempts to make
     * certain that only one record was returned in the resultset
     *
     * @param  array $resultIdentities
     * @return boolean|\Zend\Authentication\Result
     */
    protected function _authenticateValidateResultSet(array $resultIdentities) {

        if (count($resultIdentities) < 1) {
            $this->authenticateResultInfo['code'] = \Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1 && false === $this->getAmbiguityIdentity()) {
            $this->authenticateResultInfo['code'] = \Zend\Authentication\Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        }

        return true;
    }

    /**
     * _authenticateValidateResult() - This method attempts to validate that
     * the record in the resultset is indeed a record that matched the
     * identity provided to this adapter.
     *
     * @param  array $resultIdentity
     * @return AuthenticationResult
     */
    protected function _authenticateValidateResult($resultIdentity) {
        if ($resultIdentity['zend_auth_credential_match'] != '1') {
            $this->authenticateResultInfo['code'] = \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID;
            $this->authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }

        unset($resultIdentity['zend_auth_credential_match']);
        $this->resultRow = $resultIdentity[0];

        $this->authenticateResultInfo['code'] = \Zend\Authentication\Result::SUCCESS;
        $this->authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->_authenticateCreateAuthResult();
    }

    /**
     * Creates a Zend\Authentication\Result object from the information that
     * has been collected during the authenticate() attempt.
     *
     * @return AuthenticationResult
     */
    protected function _authenticateCreateAuthResult() {
        return new \Zend\Authentication\Result(
                $this->authenticateResultInfo['code'], $this->authenticateResultInfo['identity'], $this->authenticateResultInfo['messages']
        );
    }

}
