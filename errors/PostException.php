<?php

class PostException extends Exception
{

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        // 全てを正しく確実に代入する
        parent::__construct(json_encode($message), $code, $previous);
    }

    public function getArrayMessage($assoc = false) {
        return json_decode($this->getMessage(), $assoc);
    }
}
