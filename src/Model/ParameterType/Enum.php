<?php
namespace App\Model\ParameterType;

/**
 * Description of Enum
 *
 * @author pawel
 */
class Enum extends ParameterTypeEntity{
    
    const LAYOUT_DROPDOWN = 'dropdown';
    const LAYOUT_RADIOBUTTON = 'radio';
    
    public static $layoutList = [
        self::LAYOUT_RADIOBUTTON,
        self::LAYOUT_DROPDOWN,
    ];
    
    /**
    * Tablica rekordów
    */
    private $enumRecord;
    
    /**
    * Pokaż limit
    */
    private $showLimits;
    
    /**
     * Sposób wyboru: radio, combobox
     * @var string
     */
    private $layout;
    
    /**
    * Pokaż elementy z przekroczonym limitem
    */
    private $showDisabled;
    
    /**
    * Multiwybór
    */
    private $multichoice;

	public function getShowLimits(){
		return $this->showLimits;
	}

	public function setShowLimits($showLimits){
		$this->showLimits = $showLimits;
        return $this;
	}

	public function getShowDisabled(){
		return $this->showDisabled;
	}

	public function setShowDisabled($showDisabled){
		$this->showDisabled = $showDisabled;
        return $this;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }

    public function getMultichoice() {
        return $this->multichoice;
    }

    public function setMultichoice($multichoice) {
        $this->multichoice = $multichoice;
        return $this;
    }
	
    
    public function __construct() {
        $this->showDisabled = false;
        $this->showLimits = false;
        $this->multichoice = false;
        $this->layout = self::$layoutList[0];
        $this->enumRecord = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add enumRecord
     *
     * @param \InvitationBundle\Entity\ParameterType\EnumRecord $enumRecord
     *
     * @return Enum
     */
    public function addEnumRecord(\InvitationBundle\Entity\ParameterType\EnumRecord $enumRecord)
    {
        $this->enumRecord[] = $enumRecord;

        return $this;
    }

    /**
     * Remove enumRecord
     *
     * @param \InvitationBundle\Entity\ParameterType\EnumRecord $enumRecord
     */
    public function removeEnumRecord(\InvitationBundle\Entity\ParameterType\EnumRecord $enumRecord)
    {
        $this->enumRecord->removeElement($enumRecord);
    }

    /**
     * Get enumRecord
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnumRecord()
    {
        return $this->enumRecord;
    }
    
    public function getDefault() {
        $defaultArray = [];
        foreach($this->getEnumRecord() as $EnumRecord) {
            if($EnumRecord->getDefault()) {
                if(!$this->getMultichoice()) {
                    return $EnumRecord->getName();
                }
                $defaultArray[] = $EnumRecord->getName();
            }
        }
        return empty($defaultArray)?null:$defaultArray;
    }
    
    public function getVariableType() {
        if($this->getMultichoice()) {
            return self::TYPE_ARRAY;
        } else {
            return self::TYPE_STRING;
        }
    }
}
