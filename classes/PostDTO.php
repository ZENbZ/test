<?php
class PostDTO
{
    public int $id;
    public int $userId;
    public string $title;
    public string $body;

    private static int $count = 0;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setPost($table)
    {
        $query = $this->db->insert($table, ['id' => $this->id, 'userId' => $this->userId, 'title' => $this->title, 'body' => $this->body]);
        if ($query)
            self::$count++;
        else 
            return $query;
    }

    public static function getCount()
    {
        return self::$count;
    }
}
