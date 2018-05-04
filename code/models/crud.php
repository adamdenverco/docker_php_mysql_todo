<?php
/*
 * Create Read Update Delete class
 */
class Crud {

    protected $_table = null;
    protected $_primary_key = null;
    protected $pdo;

    public function __construct() {
        // load our database connection once as a singleton
        $this->pdo = Database::Instance();
    }

    public function create($data = null) {

        $newIdOrFalse = false;
        if ( isArrayAndNotNull($data)) {

            try {

                $sqlColumns = [];
                $sqlColumnBindings = [];
                foreach ($data as $key => $value) {
                    $sqlColumns[] = " `".$key."` ";
                    $sqlColumnBindings[] = ":" . $key;
                }
                $sqlColumns = implode(',', $sqlColumns);
                $sqlColumnBindings = implode(', ', $sqlColumnBindings);

                $sql = "
                    INSERT INTO `". $this->_table ."` (". $sqlColumns .")
                    VALUES (". $sqlColumnBindings .")
                ";

                // prepare SQL statement
                $preparedSqlStatement = $this->pdo->prepare($sql);
                // bind identifiers to protect from SQL injection
                foreach ($data as $key => $value) {
                    $preparedSqlStatement->bindValue(':'. $key, $value);
                }
                // execute and fetch all data
                $preparedSqlStatement->execute();

                $preparedSqlStatement->debugDumpParams();

                $newIdOrFalse = $this->pdo->lastInsertId();

            } catch (PDOException $e) {
                $errorOutput = [
                    'status' => 'error',
                    'message' => 'Insert Database/SQL error: ' . 
                        $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()
                ];
                Logging::writeToFile( json_encode($errorOutput) );
            }

        }
        return $newIdOrFalse;

    }

    public function read($identifiers = null, $orderBy = null, $limit = null) {

        // we'll return an array or false
        $returnData = false;

        // base SQL to start with
        $sql = " SELECT * FROM `". $this->_table ."` {WHERE} ";

        // append order by if available
        $sql = $this->appendOrderBySql($sql, $orderBy);

        // append limit if available
        $sql = $this->appendLimitSql($sql, $limit);

        // if is a single integer, recast as array
        $identifiers = $this->ifIntegerThenRecastToArray($identifiers);

        // verify the $identifiers is an array with more than one value
        if ( is_array($identifiers) && count($identifiers) > 0 ) {

            try {
                // combine all the identifiers into one SQL string
                $sql = $this->appendWhereSql($sql, $identifiers);
                // prepare SQL statement
                $preparedSqlStatement = $this->pdo->prepare($sql);
                // bind identifiers to protect from SQL injection
                foreach ($identifiers as $key => $value) {
                    $preparedSqlStatement->bindValue(':'. $key, $value);
                }
                // execute and fetch all data
                $preparedSqlStatement->execute();
                $returnData = $preparedSqlStatement->fetchall(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                $errorOutput = [
                    'status' => 'error',
                    'message' => 'Database/SQL error: ' . 
                        $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()
                ];
                Logging::writeToFile( json_encode($errorOutput) );
            }
        }
        return (is_array($returnData)) ? $returnData : false;
    }

    public function update($identifiers = null, $data = null) {

        $rowsAffected = 0;
        $returnTrueOrFalse = false;

        // we'll return rows affected
        $returnRowsAffected = 0;

        // base SQL to start with
        $sql = " UPDATE `". $this->_table ."` {SETVALUES} {WHERE} ";

        // if is a single integer, recast as array
        $identifiers = $this->ifIntegerThenRecastToArray($identifiers);

        try {

            // combine all the identifiers into one SQL string
            $sql = $this->appendWhereSql($sql, $identifiers);

            // combine all data values into one SQL string
            $sql = $this->appendSetValuesSql($sql, $data);

            // prepare SQL statement
            $preparedSqlStatement = $this->pdo->prepare($sql);
            
            // bind data values to protect from SQL injection
            foreach ($data as $key => $value) {
                $preparedSqlStatement->bindValue(':'. $key, $value);
            }

            // bind identifiers to protect from SQL injection
            foreach ($identifiers as $key => $value) {
                $preparedSqlStatement->bindValue(':'. $key, $value);
            }

            // execute and fetch all data
            $preparedSqlStatement->execute();
            $rowsAffected = $preparedSqlStatement->rowCount();

        } catch (PDOException $e) {
            $errorOutput = [
                'status' => 'error',
                'message' => 'Database/SQL error: ' . 
                    $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()
            ];
            Logging::writeToFile( json_encode($errorOutput) );
        }

        return ($rowsAffected > 0) ? true:false;

    }

    public function delete($identifiers = null) {

        // if is a single integer, recast as array
        $identifiers = $this->ifIntegerThenRecastToArray($identifiers);

        if ( is_numeric($identifiers) ) {
            // $this->db->where($this->_primary_key, $id);
        } elseif ( is_array($identifiers) ) {
            foreach ($identifiers as $_key => $_value) {
                // $this->db->where($_key, $_value);
            }
        }
        // $q = $this->db->get($this->_table);
        // return $q->result_array();
    }

    public function customSql($sql, $prepareVariables) {
        # for more complex queries
    }

    private function appendWhereSql($sql = null, $identifiers = []) {
        // if we have some sql text
        // and $identifiers is an array more than one entry
        if (
            isset($sql) && !is_null($sql) && 
            is_array($identifiers) && count($identifiers) > 0
        ) {
            $sqlWhere = [];
            foreach ($identifiers as $key => $value) {
                $sqlWhere[] = " ( `". $key ."` = :". $key .") ";
            }
            $sqlWhere = (count($sqlWhere > 0)) ? implode(" AND ", $sqlWhere) : "";
            $sql = str_replace("{WHERE}", " WHERE " .$sqlWhere, $sql);
        }
        return $sql;
    }

    private function appendSetValuesSql($sql = null, $data = []) {
        // if we have some sql text
        // and $identifiers is an array more than one entry
        if (
            isset($sql) && !is_null($sql) && 
            is_array($data) && count($data) > 0
        ) {
            $sqlWhere = [];
            foreach ($data as $key => $value) {
                $sqlSetValues[] = " `". $key ."` = :". $key ." ";
            }
            $sqlSetValues = (count($sqlSetValues > 0)) ? implode(" , ", $sqlSetValues) : "";
            $sql = str_replace("{SETVALUES}", " SET " .$sqlSetValues, $sql);
        }
        return $sql;
    }

    private function appendOrderBySql($sql = null, $orderBy = null) {
        // if we have some sql text
        // and order is an array with a column and a valid order option
        if (
            isset($sql) && !is_null($sql) && 
            is_array($orderBy) && isset($orderBy['column']) && isset($orderBy['order']) && 
            ( $orderBy['order'] == "DESC" || $orderBy['order'] == "ASC" )
        ) {
            $sql = $sql . " ORDER BY `". $orderBy['column'] ."` ". $orderBy['order'] ." ";
        }
        return $sql;
    }

    private function appendLimitSql($sql = null, $limit = null) {
        // if we have some sql text
        // and the limit is a number greater than zero
        if ( isset($sql) && !is_null($sql) && is_int($limit) && $limit > 0 ) {
            // append LIMIT SQL 
            $sql = $sql . " LIMIT ". (int)$limit;
        }
        return $sql;
    }

    private function ifIntegerThenRecastToArray($identifiers) {
        return ( is_int($identifiers) ) ? [ $this->_primary_key => $identifiers ] : $identifiers;
    }

}
