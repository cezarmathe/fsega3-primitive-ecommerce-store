<?php

namespace ECommerce\App\Repository;

// BaseRepository is a utility class for building other repositories.
class BaseRepository {
    private $conn;

    public function __construct() {
        // todo 23/11/2022: load connection string from config file.
        $this->conn = pg_connect("host=localhost dbname=ecommerce user=postgres");
    }

    // Query executes a query.
    protected function query($sql, array $params = []) {
        $result = pg_query_params($this->conn, $sql, $params);
        if ($result === false) {
            throw new \Exception('Failed to execute query: ' . pg_last_error());
        }

        return $result;
    }

    // Begin starts a transaction.
    protected function begin() {
        $result = $this->query('begin');
        if ($result === false) {
            throw new \Exception('Failed to begin transaction: ' . pg_last_error());
        }
    }

    // Rollback rolls back a transaction.
    protected function rollback() {
        $result = $this->query('rollback');
        if ($result === false) {
            throw new \Exception('Failed to rollback transaction: ' . pg_last_error());
        }
    }

    // Commit commits a transaction.
    protected function commit() {
        $result = $this->query('commit');
        if ($result === false) {
            throw new \Exception('Failed to commit transaction: ' . pg_last_error());
        }
    }
}
