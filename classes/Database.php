<?php
DB::connect();
class DB
{
    public static function connect()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=smart_box', 'user1', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function query($query, $params = array())
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
}
