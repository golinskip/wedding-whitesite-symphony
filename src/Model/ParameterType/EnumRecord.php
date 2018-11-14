<?php
namespace App\Model\ParameterType;

use Doctrine\ORM\Event\LifecycleEventArgs;
/**
 * Description of Enum
 *
 * @author pawel
 */
class EnumRecord {
    
    /**
    * Nazwa
    */
    private $name;
    
    /**
    * Modyfikator kosztów dla tego wyboru
    */
    private $priceModifier;
    
    /**
    * Górny limit osób, które wybiorą tę opcję
    */
    private $limit;
    
    /**
    * Domyślna wartość
    */
    private $default;
    
    public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
        return $this;
	}

	public function getPriceModifier(){
		return $this->priceModifier;
	}

	public function setPriceModifier($priceModifier){
		$this->priceModifier = $priceModifier;
        return $this;
	}

	public function getLimit(){
		return $this->limit;
	}

	public function setLimit($limit){
		$this->limit = $limit;
        return $this;
	}

	public function getDefault(){
		return $this->default;
	}

	public function setDefault($default){
		$this->default = $default;
        return $this;
	}
    
    
    public function __construct() {
        $this->setPriceModifier(0);
        $this->setLimit(0);
    }
}
