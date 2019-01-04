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

class InvitationAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $translator;
    private $recorder;

    private $mode = 1;

    const MODE_TOKEN = 0;
    const MODE_CODE = 1;

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
        if( 'app_login' === $request->attributes->get('_route')
            && $request->query->get('token') && $request->isMethod('GET')) {
                $this->mode = self::MODE_TOKEN;
                return true;
            }
        if('app_login' === $request->attributes->get('_route')
        && $request->isMethod('POST')) {
            $this->mode = self::MODE_CODE;
            return true;
        }
        return false;
    }

    public function getCredentials(Request $request)
    {
        if( $this->mode === self::MODE_TOKEN ) {
            $credentials = [
                'token' => $request->query->get('token'),
            ];
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['token']
            );
        } else {
            $credentials = [
                'code' => $request->request->get('code'),
                'csrf_token' => $request->request->get('_csrf_token'),
            ];
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['code']
            );
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        if( $this->mode === self::MODE_TOKEN ) {
            $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByToken($credentials['token']);
        } else {
            $token = new CsrfToken('authenticate', $credentials['csrf_token']);
            if (!$this->csrfTokenManager->isTokenValid($token)) {
                throw new InvalidCsrfTokenException();
            }
            $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByCode($credentials['code']);
        }

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

        if( $this->mode === self::MODE_TOKEN ) {
            $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByToken($credentials['token']);
        } else {
            $Invitation = $this->entityManager->getRepository(Invitation::class)->findOneByCode($credentials['code']);
        }

        if (!$Invitation) {
            return false;
        } else {
            return true;
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if( $this->mode === self::MODE_TOKEN ) {
            $this->recorder->start('login.token')->commit();
        } else {
            $this->recorder->start('login.code')->commit();
        }

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
