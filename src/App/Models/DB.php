<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Controllers\Config;

class DB
{
    private static $_instance = null;
    private $_pdo, $_query, $_results, $_count = 0, $_error = false;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO(Config::get('mysql/url'), Config::get('mysql/username'), Config::get('mysql/password'));
            //echo 'Connected to DB!';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $k = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($k, $param);
                    $k++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    private function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $operators = array('=', '<', '>', '<=', '>=');

            $field         = $where[0];
            $operator     = $where[1];
            $value         = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }

        return false;
    }

    public function get($table, $where)
    {
        return $this->action("SELECT *", $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action("DELETE", $table, $where);
    }

    public function insert($table, $fields = array())
    {
        if (count($fields)) {
            $keys     = array_keys($fields);
            $values = '';
            $k = 1;

            foreach ($fields as $field) {
                $values .= '?';
                if ($k < count($fields)) {
                    $values .= ', ';
                }
                $k++;
            }

            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES (" . $values . ")";
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        return false;
    }

    public function update($table, $id, $fields = array())
    {
        $set = '';
        $k = 1;

        foreach ($fields as $name => $value) {
            $set .=  $name . ' = ?';
            if ($k < count($fields)) {
                $set .= ', ';
            }
            $k++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = $id";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }

    public function pdo()
    {
        return $this->_pdo;
    }
}
