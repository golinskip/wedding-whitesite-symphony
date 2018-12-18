<?php

// src/Admin/CustomViewAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ImportExportGiftsAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'import-export-gifts';
    protected $baseRouteName = 'import-export-gifts';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list']);
    }
}