<?php

namespace App\Security;

use App\Entity\Invitation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Translation\TranslatorInterface;
use App\Services\Recorder;

class InvitationTokenAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $translator;
    private $recorder;

    public function __construct(    EntityManagerInterface $entityManager, 
                                    RouterInterface $router, 
                                    CsrfTokenManagerInterface $csrfTokenManager, 
                                    TranslatorInterface $translator,
                                    Recorder $recorder)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->translator = $translator;
        $this->recorder = $recorder;
    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->request->get('token') && $request->isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'token' => $request->request->get('token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['token']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $CsrfToken = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($CsrfToken)) {
            throw new InvalidCsrfTokenException();
        }

        $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByToken($credentials['token']);

        if (!$Invitation) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException(
                $this->translator->trans('login.msg.invalid_code')
            );
        }

        return $Invitation;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
        $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByToken($credentials['token']);

        if (!$Invitation) {
            return false;
        } else {
            return true;
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $this->recorder->start('login.code')->commit();

        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->router->generate('private_index'));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }
}
