<?php 

namespace Validator\DB;

use mysqli;

class Database 
{
    public static function connect() {
        // Database credentials
        $hostname = 'localhost';
        $username = 'root';
        $password = 'password';
        $database = 'validator';
        
        // Attempt database connection
        $con = new mysqli($hostname, $username, $password, $database);

        // Check connection
        if ($con->connect_errno) {
            // If connection fails, handle the error gracefully
            die("Connection failed: " . $con->connect_error);
        }

        // Set charset for proper character encoding
        $con->set_charset('utf8');

        // Return the database connection object
        return $con;
    }
}
