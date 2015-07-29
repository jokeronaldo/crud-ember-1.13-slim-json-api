<?php

//use Jenssegers\Mongodb\Model as Eloquent; // Mongodb model class
use \Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
	const CREATED_AT = 'usr_created_at';
	const UPDATED_AT = 'usr_updated_at';
	
    protected $table = 'user';
	protected $primaryKey = 'usr_id';
	//protected $collection = 'user'; // Mongodb
}