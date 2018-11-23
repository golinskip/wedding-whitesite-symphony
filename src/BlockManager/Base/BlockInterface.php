<?php

namespace App\BlockManager\Base;

interface BlockInterface
{
    public function getView($class);
    public function getForm($class);
    public function getFormClass();
    public function createObject();
}