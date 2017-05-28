<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 25.05.17
 * Time: 14:07
 */

namespace Models;
use Helpers\DbHelper;
use PDO;


class Comment
{
    public
        $id,
        $text,
        $created_at,
        $user,
        $comments,
        $comments_count,
        $rating = [
            'plus'=>[],
            'minus'=>[]
        ];


    public function __construct(array $data=[])
    {
        // подключение к БД
        $db = new DbHelper();
        if($data) {
            $this->id = $data['id'] ?? null;
            $this->text = $data['text'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            if(isset($data['user_id'])) {
                $this->user = $db->getUserById($data['user_id']);
            }
            if(isset($data['id'])) {
                $this->comments = $db->getComments(null, $data['id'], 2);
                $this->comments_count = $db->getCountComments(null, $data['id']);
                $this->rating = $db->getRatingComment($data['id']);
            }
        }
    }

    public function isMy(User $user){
        if ($user == $this->user)
            return true;
        return false;
    }

}