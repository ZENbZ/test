<?php
require_once 'Connection.php';
require_once 'config.php';

Connection::set(DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

class QueryBuilder
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function insert(string $table, array $array)
    {
        $column = implode(', ', array_keys($array));
        $values = '"'.implode('", "', $array).'"';
        $request = "INSERT INTO $table ($column) VALUES ($values)";
        return $this->db->query($request);
    }

    public function search(array $searchValue)
    {
        $values = '+'.implode('* +', $searchValue).'*';
        $request = "SELECT id, title FROM `posts` WHERE id IN (SELECT postId FROM `comments` WHERE MATCH(body) AGAINST('$values' IN BOOLEAN MODE))";
        return $this->db->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select(array $searchValue, string $postId)
    {
        $values = '+'.implode('* +', $searchValue).'*';
        $request = "SELECT name, email, body  FROM `comments` WHERE MATCH(body) AGAINST('$values' IN BOOLEAN MODE) AND postId = $postId";
        return $this->db->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }
}
