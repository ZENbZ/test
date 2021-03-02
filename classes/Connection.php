<?php
class Connection
{
    private static $hostname;
    private static $database;
    private static $username;
    private static $password;
    
    public static function set($hostname, $database, $username, $password)
    {   
        self::$hostname = $hostname;
        self::$database = $database;
        self::$username = $username;
        self::$password = $password;
    }

    public static function make()
    {
        return new PDO("mysql:host=".self::$hostname.";dbname=".self::$database, self::$username, self::$password);
    }
}
