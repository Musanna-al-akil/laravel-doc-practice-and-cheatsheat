<?php

namespace App\Exceptions;

use Exception;


class InvalidOrderException extends Exception
{
   
    public function __construct( $message, public readonly int $order_id, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    public function context():array
    {
        return ['order_id' => $this->order_id];
    }
}
