<?php

namespace MyBlog\Http;

class RequestFile
{
    private $name;
    private $type;
    private $tmp_name;
    private $error;
    private $size;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTmpName()
    {
        return $this->tmp_name;
    }

    public function setTmpName($tmp_name)
    {
        $this->tmp_name = $tmp_name;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}