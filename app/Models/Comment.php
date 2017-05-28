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
            //получение пользователя (объекта User) написавшего текущий комментарий
            if(isset($data['user_id'])) {
                $this->user = $db->getUserById($data['user_id']);
            }
            if(isset($data['id'])) {
                //получение двух последних вложенных комментариев
                $this->comments = $db->getComments(null, $data['id'], 2);
                //получение количества всех вложенных комментариев
                $this->comments_count = $db->getCountComments(null, $data['id']);
                //получение данных об оценках текущего комментария
                $this->rating = $db->getRatingComment($data['id']);
            }
        }
    }

    /*Проверка принадлежности текущего комментария к переданному пользователю*/
    public function isMy(User $user){
        if ($user == $this->user)
            return true;
        return false;
    }

}