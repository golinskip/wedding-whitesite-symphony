<?php
namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use App\Entity\EventLog;
use App\Entity\EventLogDetail;
use App\Entity\User;
use App\Entity\Invitation;

class Recorder {
    
    protected $em;
    
    protected $context;
    
    protected $request;
    
    protected $eventLog;
    
    protected $eventLogDetails = array();

    public function __construct(EntityManagerInterface $em, TokenStorageInterface  $context, RequestStack $requestStack) {
        $this->em = $em;
        $this->context = $context;
        $this->request = $requestStack->getCurrentRequest();
    }
    
    public function start($tag) {
        $this->eventLog = new EventLog;
        $this->setUserAndEnv();
        $this->eventLog->setTag($tag);
        $this->eventLog->setDate(new \DateTime());
        $this->eventLog->setIp($this->request->getClientIp());
        $this->eventLog->setUserAgent($this->request->headers->get('User-Agent'));
        return $this;
    }
    
    public function record($variable, $value) {
        $eventLogDetail = new EventLogDetail();
        $eventLogDetail->setVariable($variable);
        $eventLogDetail->setValue($this->_parseValue($value));
        $eventLogDetail->setEventLog($this->eventLog);
        $this->eventLog->addEventLogDetail($eventLogDetail);
        $this->eventLogDetails[] = $eventLogDetail;
        return $this;
    }
    
    protected function _parseValue($value) {
        if(is_object($value) && get_class($value) == 'DateTime') {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
    
    public function commit() {
        foreach($this->eventLogDetails as $eventLogDetail) {
            $this->em->persist($eventLogDetail);
        }
        $this->em->persist($this->eventLog);
        $this->em->flush();
    }
    
    protected function setUserAndEnv() {
        $User = $this->getUser();
        switch(get_class($User)) {
            case User::class :
                $this->eventLog->setEnv(EventLog::ENV_ADMIN);
                $this->eventLog->setUser($User);
            break;
            case Invitation::class :
                $this->eventLog->setEnv(EventLog::ENV_PRIV);
                $this->eventLog->setInvitation($User);
            break;
            default:
                $this->eventLog->setEnv(EventLog::ENV_ANON);
        }
    }

    protected function getUser() {
        return $this->context->getToken()->getUser();
    }

}