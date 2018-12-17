<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\UserBundle\Model\UserManagerInterface;
use App\Entity\Config;
use App\Entity\Page;

class AppFixtures extends Fixture
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        // Create our user and set details
        $user = $this->userManager->createUser();
        $user->setUsername('pawel');
        $user->setEmail('pawel@whitesite.eu');
        $user->setPlainPassword('pawel');

        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        
        // Update the user
        $this->userManager->updateUser($user, true);

        // Default pages
        $privatePage = new Page();
        $privatePage->setIsPublic(false);
        $privatePage->setIsRoot(true);
        $privatePage->setTitle("Private Home");
        $privatePage->setIsEnabled(true);
        $privatePage->setIsInMenu(false);
        $manager->persist($privatePage);

        $publicPage = new Page();
        $publicPage->setIsPublic(true);
        $publicPage->setIsRoot(true);
        $publicPage->setTitle("Public Home");
        $publicPage->setIsEnabled(true);
        $publicPage->setIsInMenu(false);
        $manager->persist($publicPage);

        $manager->flush();
    }
}
