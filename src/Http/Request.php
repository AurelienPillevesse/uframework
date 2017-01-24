<?php

namespace Http;

class Request
{
	const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';

    private $parameters;

    public function __construct(array $query = array(), array $request = array()) {
    	$this->parameters = array_merge($query, $request);
    }

    public function getParameter($name, $default = null)
	{

	}

    public function getMethod() {
    	return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;
    }

    public function getUri() {
    	$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

    	if ($pos = strpos($uri, '?')) {
		    $uri = substr($uri, 0, $pos);
		}
		
    	return $uri;
    }

    public static function createFromGlobals() {
    	return new self($_GET, $_POST);
    }
}