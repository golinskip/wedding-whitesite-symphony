<?php
namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Entity\Config;

class ConfigService {

    private $em;

    private $config;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->load();
    }

    public function load() {
        $this->config = $this->em
            ->getRepository(Config::class)
            ->findAll();
    }

    public function getObject() {
        $arr = [];
        foreach($this->config as $configRow) {
            switch($configRow->getType()) {
                case \DateTime::class:
                    $val = new \DateTime($configRow->getValue());
                    break;
                default:
                    $val = $configRow->getValue();
                    settype($val, $configRow->getType());
            }   
            $arr[$configRow->getName()] = $val;
        }
        return (object)$arr;
    }

    public function createForm($formBuilder) {
        foreach($this->config as $configRow) {
            $options = $configRow->getFormOptions();
            if(!isset($options['label'])) {
                $options['label'] = $configRow->getDescription();
            }
            $formBuilder->add($configRow->getName(), $configRow->getFormType(), $options);
        }
        return $formBuilder->getForm();
    }

    public function updateObject(object $obj) {
        foreach($this->config as $configRow) {
            if(isset($obj->{$configRow->getName()})) {

                switch($configRow->getType()) {
                    case \DateTime::class:
                        $configRow->setValue($obj->{$configRow->getName()}->format('Y-m-d H:i:s'));
                        break;
                    default:
                        $configRow->setValue($obj->{$configRow->getName()});
                }                
                $this->em->persist($configRow);
            }
        }
        $this->em->flush();
        return true;
    }

    public function getConfig() {
        return $this->config;
    }

}