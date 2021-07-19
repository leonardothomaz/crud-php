<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database
{
    const HOST = 'localhost';

    const NAME = 'wdev_vagas';

    const USER = 'root';

    const PASS = 'password';

    private $table;

    private $connection;

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    public function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    public function insert($values)
    {
        // dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        // monta a query
        $query = 'INSERT INTO ';
        $query .= $this->table;
        $query .= ' (' . implode(',', $fields) . ') ';
        $query .= 'VALUES (';
        $query .= implode(',', $binds);
        $query .= ');';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function update($where, $values)
    {
        $fields = array_keys($values);

        $query = 'UPDATE ';
        $query .= $this->table;
        $query .= ' SET ';
        $query .= implode('=?,', $fields);
        $query .= '=?';
        $query .= ' WHERE ';
        $query .= $where;

        $this->execute($query, array_values($values));

        return true;
    }

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? ' WHERE ' . $where : '';
        $order = strlen($order) ? ' ORDER BY ' . $order : '';
        $limit = strlen($limit) ? ' LIMIT ' . $limit : '';

        $query = 'SELECT ';
        $query .= $fields;
        $query .= ' FROM ';
        $query .= $this->table;
        $query .= $where;
        $query .= $order;
        $query .= $limit;

        return $this->execute($query);
    }
}
