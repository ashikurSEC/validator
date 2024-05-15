<?php

namespace Validator;

use Validator\DB\Database;

class Model
{
    protected $table;

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function create($data = [])
    {
        $columns = array_keys($data);
        $values = array_map(function ($value) {
            if (is_array($value)) {
                return "'" . $value . "'";
            }
            return $value;
        }, array_values($data));

        $sql = "INSERT INTO users (" . implode(', ', $columns) . ") VALUES(" . implode(', ', $values) . ");";
        return $this->db->query($sql);
    }

    public function update($data = [], $where = [])
    {
        $set        = '';
        $conditions = '';

        if ($data) {
            foreach ($data as $key => $value) {
                $set .= "$key = $value";
            }
        }
        if ($where) {
            foreach ($where as $key => $value) {
                $conditions .= "$key = $value";
            }
            if (!$conditions) {
                $conditions .= "$key = $value";
            } else {
                $conditions .= "AND $key = $value";
            }
        }
        $sql = "UPDATE users SET $set WHERE $conditions;";
        return $this->db->query($sql);
    }


    public function delete( $where = [] )
     {
        $conditions = '';

        if ($where) {
            foreach ($where as $key => $value) {
                $conditions.= "$key = $value";
            }
            if (!$conditions) {
                $conditions.= "$key = $value";
            } else {
                $conditions.= "AND $key = $value";
            }
        }
        $sql = "DELETE FROM users WHERE $conditions;";
        return $this->db->query($sql);
     }


     public function find($where = []) 
     {
        $conditions = '';

        if ($where) {
            foreach ($where as $key => $value) {
                $conditions.= "$key = $value";
            }
            if (!$conditions) {
                $conditions.= "$key = $value";
            } else {
                $conditions.= "AND $key = $value";
            }
        }
        $sql = "SELECT * FROM users WHERE $conditions;";
        return $this->db->query($sql);
     }

     public function get ()
     {
        $sql = "SELECT * FROM $this->table;";
        $result =  $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
     }
}
