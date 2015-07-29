<?php
namespace App;

use Slim\Slim;

class App extends Slim
{
	static function jsonGetAttr($json, $attribute) {
		return isset($json->data->attributes->$attribute) ? $json->data->attributes->$attribute : false;
	}
	
	static function jsonApiError($error_uid, $link, $status, $code, $title, $detail) {
		$error = new \Neomerx\JsonApi\Document\Error(
			$error_uid,
			new \Neomerx\JsonApi\Schema\Link($link),
			$status,
			$code,
			$title,
			$detail,
			[], //
			[]
		);
		
		echo \Neomerx\JsonApi\Encoder\Encoder::instance([])->error($error) . PHP_EOL;
	}
}
