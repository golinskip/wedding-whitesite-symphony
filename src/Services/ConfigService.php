<?php
namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Entity\Config;
use Symfony\Component\Yaml\Yaml;
use App\Services\ConfigConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Doctrine\ORM\EntityManagerInterface;

class ConfigService {

    private $em;

    private $values;

    private $configYaml;

    private $configObject;

    /**
     * Creating object with config
     *
     * @return void
     */
    public function createObject() {
        $arr = [];
        $notExistedObjs = [];
        foreach($this->configYaml['vars'] as $name => $configRow) {
            // Create config if not exists in database
            $currentConfigObj = null;
            foreach($this->values as $configObj) {
                if($configObj->getName() == $name) {
                    $currentConfigObj = $configObj;
                    break;
                }
            }
            if($currentConfigObj === null) {
                $currentConfigObj = new Config;
                if(isset($configRow['default'])) {
                    $currentConfigObj->setValue((string)$configRow['default']);
                }
                $currentConfigObj->setName($name);
                $notExistedObjs[] = $currentConfigObj;
            }
            switch($configRow['type']) {
                case \DateTime::class:
                    $val = new \DateTime($currentConfigObj->getValue());
                    break;
                default:
                    $val = $currentConfigObj->getValue();
                    settype($val, $configRow['type']);
            }   
            $arr[$name] = $val;
        }
        if($notExistedObjs !== []) {
            foreach ($notExistedObjs as &$obj) {
                $this->em->persist($obj);
            }
            $this->em->flush();
        }
        $this->configObject = (object)$arr;
        return $this->configObject;
    }

    /**
     * Returns object with configs
     *
     * @return object
     */
    public function getObject() {
        if($this->configObject == null) {
            return $this->createObject();
        }
        return $this->configObject;
    }

    /**
     * Returns config
     *
     * @param [type] $formBuilder
     * @return void
     */
    public function createForm($formBuilder) {
        foreach($this->configYaml['vars'] as $name => $configRow) {
            $options = $configRow['form_options'] ?? [];
            if(!isset($options['label'])) {
                $options['label'] = $configRow['label'];
            }
            $formBuilder->add($name, $configRow['form_type'], $options);
        }
        return $formBuilder->getForm();
    }

    /**
     * Save variables to database
     *
     * @param object $obj
     * @return void
     */
    public function updateObject(object $obj) {
        foreach($this->configYaml['vars'] as $name => $configRow) {
            $currentConfigObj = null;
            foreach($this->values as $configObj) {
                if($configObj->getName() == $name) {
                    $currentConfigObj = $configObj;
                    break;
                }
            }
            if(isset($obj->{$name})) {
                switch($configRow['type']) {
                    case \DateTime::class:
                        $currentConfigObj->setValue($obj->{$name}->format('Y-m-d H:i:s'));
                        break;
                    default:
                        $currentConfigObj->setValue($obj->{$name});
                } 
                $this->em->persist($currentConfigObj);
            }
        }
        $this->em->flush();
        return true;
    }

    /**
     * Return current config
     *
     * @return void
     */
    public function getConfig() {
        return $this->configObject;
    }

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->load();
    }

    /**
     * Load data
     *
     * @return void
     */
    public function load() {
        $this->values = $this->em
            ->getRepository(Config::class)
            ->findAll();
        $this->loadConfigYaml();
    }

    /**
     * Load configuration from yaml file
     *
     * @return void
     */
    public function loadConfigYaml() {
        $configFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.yaml';
        $config = Yaml::parse(
            file_get_contents($configFile)
        );
        
        $processor = new Processor();
        $configConfiguration = new ConfigConfiguration();
        $processedConfiguration = $processor->processConfiguration(
            $configConfiguration,
            $config
        );
        $this->configYaml = $processedConfiguration;
    }

}