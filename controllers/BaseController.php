<?php

require "./core/Validator.php";
class BaseController
{
    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }
}
