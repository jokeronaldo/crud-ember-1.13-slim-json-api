<?php

use \Neomerx\JsonApi\Schema\SchemaProvider;

class UserSchema extends SchemaProvider
{
    protected $resourceType = 'users';
    protected $selfSubUrl  = '/users/';
	
    public function getId($user)
    {
        return $user->usr_id;
    }
    public function getAttributes($user)
    {
        return [
            'name' => $user->usr_name,
            'email'  => $user->usr_email,
        ];
    }
}