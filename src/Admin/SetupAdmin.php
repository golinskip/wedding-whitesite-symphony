<?php

// src/Admin/CustomViewAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class SetupAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'config';
    protected $baseRouteName = 'config';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list']);
    }
}