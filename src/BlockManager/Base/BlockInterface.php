<?php

namespace App\BlockManager\Base;

interface BlockInterface
{
    public function getTwigTemplate();
    public function getFormClass();
    public function createObject();
}