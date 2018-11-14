<?php
namespace App\Model\ParameterType;

/**
 * Description of String
 *
 * @author pawel
 */
class Text extends ParameterTypeEntity {

    const INPUT_TYPE_TEXTAREA = 'textarea';
    const INPUT_TYPE_TEXT = 'text';
    
    public static $inputTypeList = [
        self::INPUT_TYPE_TEXTAREA,
        self::INPUT_TYPE_TEXT,
    ];
    
    /**
    * Max długość
    */
    private $maxLength;
    
    /**
    * Czy może być pusty
    */
    private $nullable;
    
    /**
    * Rodzaj wejścia
    */
    private $inputType;
    
    public function getMaxLength(){
		return $this->maxLength;
	}

	public function setMaxLength($maxLength){
		$this->maxLength = $maxLength;
	}

	public function getNullable(){
		return $this->nullable;
	}

	public function setNullable($nullable){
		$this->nullable = $nullable;
	}

	public function getInputType(){
		return $this->inputType;
	}

	public function setInputType($inputType){
		$this->inputType = $inputType;
	}
    
    public function getDefault() {
        return "";
    }
    
    public function getVariableType() {
        return self::TYPE_STRING;
    }
}
