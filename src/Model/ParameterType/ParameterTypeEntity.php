<?php
namespace App\Model\ParameterType;

abstract class ParameterTypeEntity {
    const TYPE_STRING = 'string';
    const TYPE_ARRAY = 'array';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_NULL = 'null';
    
    public abstract function getVariableType();
    public abstract function getDefault();
}