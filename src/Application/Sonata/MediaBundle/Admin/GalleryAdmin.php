<?php

namespace App\Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Sonata\MediaBundle\Admin\GalleryAdmin as BaseGalleryAdmin;

class GalleryAdmin extends BaseGalleryAdmin
{
}
