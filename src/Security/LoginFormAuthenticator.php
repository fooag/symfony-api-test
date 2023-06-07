<?php
declare(strict_types=1);

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\BrokerSessionService;
use Container2jgZiGj\getBrokerSessionServiceService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class LoginFormAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private RouterInterface $router,
        private BrokerSessionService $brokerSessionService
    ) {
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login' && $request->isMethod(Request::METHOD_POST);
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        //todo refactor code from documentation to be prepared for unit tests
        return new Passport(
            new UserBadge($email, function($userIdentifier) {
                $user = $this->userRepository->findOneBy([
                    'email' => $userIdentifier
                ]);
                if (!$user) {
                    throw new UserNotFoundException();
                }
                return $user;
            }),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge(
                    'authenticate',
                    $request->request->get('_csrf_token')
                )
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if($this->brokerSessionService->getBrokerByLogin() === null) {
            $this->processAuthenticationFailure($request, new UserNotFoundException('Broker does not exist'));
        }

        return new RedirectResponse(
            $this->router->generate('api_foo')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return $this->processAuthenticationFailure($request, $exception);
    }

    private function processAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse(
            $this->router->generate('app_login')
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            $this->router->generate('app_login')
        );
    }
}
