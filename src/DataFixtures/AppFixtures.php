<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\Config;
use App\Entity\Page;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $configArray = $this->wedding_pl();
        foreach($configArray as $row) {
            $newConfig = new Config();
            $newConfig->setDescription($row[0]);
            $newConfig->setName($row[1]);
            $newConfig->setType($row[2]);
            $newConfig->setFormType($row[3]);
            $newConfig->setDefaultValue($row[4]);
            $newConfig->setValue($row[4]);
            $newConfig->setConfigGroup($row[5]);
            if(isset($row[6])) {
                $newConfig->setFormOptions($row[6]);
            }
            $manager->persist($newConfig);
        }
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

    private function wedding_pl() {

        $groups = [
            1 => 'Ślub',
            2 => 'Strona'
        ];

        $configArray = [
            ['Data i godzina ślubu', 'event_date', \DateTime::class, DateTimePickerType::class, date('Y-m-d 12:00:00', strtotime('+1 year')), $groups[1]],
            ['Imię i nazwisko Państwa Młodych', 'page_title', 'string', TextType::class, '', $groups[1], ['required' => false]],
            ['Logowanie na pasku tytułu', 'navbar_show_login', 'bool', CheckboxType::class, '', $groups[2], ['required' => false]],
        ];

        return $configArray;
    }
}
