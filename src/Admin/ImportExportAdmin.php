<?php

// src/Admin/CustomViewAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ImportExportAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'import-export';
    protected $baseRouteName = 'import-export';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list']);
    }
}