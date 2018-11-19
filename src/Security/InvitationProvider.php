<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;
use App\Entity\Invitation;

class InvitationProvider implements UserProviderInterface {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function loadUserByUsername($username) {
        
        $Invitation = $this->em
            ->getRepository(Invitation::class)
            ->findOneByUrlName($username)
        ;
        
        if (!$Invitation) {
            throw new UsernameNotFoundException('No invitation found '.$username);
        }
        
        return $Invitation;
    }

    public function refreshUser(UserInterface  $user) {
        if (!$user instanceof Invitation) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return Invitation::class === $class;
    }
}