<?php

Class Test
{

    private $test = "テスト";

    function __construct($a="てすと"){
        $this->test = $a;
    }

    public function test() {
        echo $this->test;
    }
}
