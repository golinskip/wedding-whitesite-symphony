<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * MediaAdminExtension class.
 *
 * Adds browser and upload routes to the Media Admin.
 */
class MediaAdminExtension extends AbstractAdminExtension
{
    /**
     * Declare browser and upload routes for Media entity
     *
     * @param AdminInterface $admin
     * @param RouteCollection $collection
     */
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection) {
        $collection->add('browser', 'browser');
        $collection->add('upload', 'upload');
    }

}
