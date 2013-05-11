<?php

namespace Adduc\DomainTracker\Model;

abstract class Model {

    protected
        $dbConn,
        $primary_key,
        $fields = array();

    public function __construct(PDO $dbConn) {
        $this->dbConn = $dbConn;
    }

    public function getPrimaryKey() {
        return $this->primary_key;
    }

    /**
     * Return fields expected for this model, along with an optional
     * "filter_to" array to return only fields present in that array.
     */
    public function getFields($filter_to = array()) {

    }

}
