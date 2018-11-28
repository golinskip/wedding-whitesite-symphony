<?php

namespace App\Controller\Admin;

use Sonata\MediaBundle\Controller\MediaAdminController as BaseMediaAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * MediaAdminController.
 *
 * Adds browser and upload actions to Media entity.
 * Adapt from original CoopTilleulsCKEditorSonataMediaBundle
 */
class MediaAdminController extends BaseMediaAdminController {

    /**
     * Alter create Media action.
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request = null) {

        // Prevent anonymous access
        $this->admin->checkAccess('create');

        // Handle create method in ckeditor
        if (!$request->get('provider') && $request->isMethod('get')) {

            // Alter the template use to create media
            $pool = $this->get('sonata.media.pool');
            return $this->render('@SonataMedia/MediaAdmin/select_provider.html.twig', [
                'providers' => $pool->getProvidersByContext(
                    $request->get('context', $pool->getDefaultContext())
                ),
                'action' => 'create',
            ]);

        }

        // If this is not the case just call the normal create media action
        return parent::createAction($request);

    }

    /**
     * Browse media actions.
     *
     * @throws AccessDeniedException|\Twig_Error
     * @return Response
     */
    public function browserAction() {

        // Prevent anonymous access
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        // Build datagrid of media
        $datagrid = $this->admin->getDatagrid();
        $datagrid->setValue('context', null, $this->admin->getPersistentParameter('context'));
        $datagrid->setValue('providerName', null, $this->admin->getPersistentParameter('provider'));
        $formats = [];
        foreach ($datagrid->getResults() as $media) {
            $formats[$media->getId()] = $this->get('sonata.media.pool')->getFormatNamesByContext($media->getContext());
        }

        // Build view
        $formView = $datagrid->getForm()->createView();
        $twig = $this->get('twig');
        $twig->getRuntime('Symfony\Component\Form\FormRenderer')->setTheme($formView, $this->admin->getFilterTheme());
        return $this->render('admin/media/browser.html.twig', array(
            'action'    => 'browser',
            'form'      => $formView,
            'datagrid'  => $datagrid,
            'formats'   => $formats,
            'base_template' => 'admin/media/layout.html.twig',
        ));

    }

    /**
     * Upload Media action.
     *
     * @throws AccessDeniedException
     * @return Response
     */
    public function uploadAction() {

        // Prevent non admin user to access this route
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        // Verify if required parameters are there
        $request = $this->getRequest();
        $provider = $request->get('provider');
        $file = $request->files->get('upload');
        if (!$request->isMethod('POST') || !$provider || null === $file) {
            throw $this->createNotFoundException();
        }

        // Create Media entity
        $mediaManager = $this->get('sonata.media.manager.media');
        $media = $mediaManager->create();
        $media->setBinaryContent($file);
        $context = $request->get('context', $this->get('sonata.media.pool')->getDefaultContext());
        $mediaManager->save($media, $context, $provider);
        $this->admin->createObjectSecurity($media);

        // Return success response
        return new JsonResponse([
            'uploaded'   => 1,
            'fileName'   => $media->getName(),
            'url'        => $this->get($media->getProviderName())->generatePublicUrl($media, 'reference')
        ]);

    }

}
