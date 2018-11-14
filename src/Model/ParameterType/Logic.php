<?php
namespace App\Model\ParameterType;

class Logic extends ParameterTypeEntity {

    const LAYOUT_BUTTON = 'button';
    const LAYOUT_CHECKBOX = 'checkbox';
    const LAYOUT_DROPDOWN = 'dropdown';
    const LAYOUT_RADIOBUTTON = 'radio';
    
    const VALUE_TRUE = 'true';
    const VALUE_FALSE = 'false';
    
    public static $layoutList = [
        self::LAYOUT_BUTTON,
        self::LAYOUT_RADIOBUTTON,
        self::LAYOUT_DROPDOWN,
    ];
    
    /**
     * Domyślna wartość
     * @var integer
     */
    private $default;
    
    /**
     * Modyfikator ceny, gdy prawdziwe
     * @var float 
     */
    private $truePrice = 0;
    
    /**
     * Modyfikator ceny, gdy fałszywe
     * @var float
     */
    private $falsePrice = 0;
    
    /**
     * Sposób wyboru: przycisk, checkbox, combobox
     * @var string
     */
    private $layout;
   
    public function getTruePrice() {
        return $this->truePrice;
    }

    public function getFalsePrice() {
        return $this->falsePrice;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setTruePrice($truePrice) {
        $this->truePrice = $truePrice;
        return $this;
    }

    public function setFalsePrice($falsePrice) {
        $this->falsePrice = $falsePrice;
        return $this;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }
        
    public function getDefault() {
        return $this->default;
    }

    public function setDefault($default) {
        $this->default = $default;
        return $this;
    }
    
    public function __construct() {
        $this->default = self::VALUE_FALSE;
        $this->truePrice = 0;
        $this->falsePrice = 0;
        $this->layout = self::$layoutList[0];
    }
    
    public function getVariableType() {
        return self::TYPE_STRING;
    }
}