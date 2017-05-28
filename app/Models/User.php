<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 25.05.17
 * Time: 14:07
 */

namespace Models;


class User
{
    public
        $name,
        $email;
    private
        $id,
        $password;


    public function __construct(array $data=[])
    {
        if($data) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->password = $data['password'] ?? null;
        }
    }

    public function getId()
    {
        return $this->id;
    }

}