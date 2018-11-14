<?php
namespace App\Model\ParameterType;

/**
 * Description of Integer
 *
 * @author pawel
 */
class Number extends ParameterTypeEntity {
    
    /**
    * Wartość maksymalna
    */
    private $maxNum;
    
    /**
    * Wartość minimalna
    */
    private $minNum;
    
    /**
    * Znaki po przecinku
    */
    private $decimals;
    
    /**
    * Cena przez jaką mnoży się ilość i dodaje do kosztów
    */
    private $priceFactor;
    
    public function getMaxNum(){
		return $this->maxNum;
	}

	public function setMaxNum($maxNum){
		$this->maxNum = $maxNum;
	}

	public function getMinNum(){
		return $this->minNum;
	}

	public function setMinNum($minNum){
		$this->minNum = $minNum;
	}

	public function getDecimals(){
		return $this->decimals;
	}

	public function setDecimals($decimals){
		$this->decimals = $decimals;
	}

	public function getPriceFactor(){
		return $this->priceFactor;
	}

	public function setPriceFactor($priceFactor){
		$this->priceFactor = $priceFactor;
	}
    
    public function getVariableType() {
        return self::TYPE_STRING;
	}
	
	public function getDefault() {
		return 0;
	}
}
