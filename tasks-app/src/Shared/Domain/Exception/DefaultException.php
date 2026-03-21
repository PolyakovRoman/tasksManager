<?php

namespace App\Shared\Domain\Exception;

class DefaultException extends \Exception
{
    private $data;

    public function __construct(array $data, $code = 0, Throwable $previous = null) {
        $this->data = $data;
        $message = json_encode($data);
        parent::__construct($message, $code, $previous);
    }

    public function getData() {
        return $this->data;
    }
}