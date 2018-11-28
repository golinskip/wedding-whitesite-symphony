<?php
namespace App\DependencyInjection\Compiler;

use App\Controller\Admin\MediaAdminController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
/**
 * Class ReplaceServicesPass.
 */
class ReplaceServicesPass implements CompilerPassInterface {
    /**
     * During compiler build replace needed class.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {
        // Replace class use for MediaAdminController
        $container->getDefinition('sonata.media.admin.media')->setArgument(2, MediaAdminController::class);
    }
}