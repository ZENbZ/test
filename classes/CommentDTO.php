<?php
class CommentDTO
{
    public int $id;
    public int $postId;
    public string $name;
    public string $email;
    public string $body;

    private static int $count = 0;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setPost($table)
    {
        $query = $this->db->insert($table, ['id' => $this->id, 'postId' => $this->postId, 'name' => $this->name, 'email' => $this->email, 'body' => $this->body]);
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
