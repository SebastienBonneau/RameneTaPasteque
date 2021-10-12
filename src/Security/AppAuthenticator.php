<?php

namespace App\Security;

use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    // On ajoute cette variable de type ParticipantRepository pour pouvoir :
    //- lui appliquer la méthode qui permet de se connecter avec pseudo ou email et
    // qui a été définie dans ParticipantRepository
    //- l'injecter en paramètre dans le constructeur
    private ParticipantRepository $participantRepository;

    // injection de la dépendance ParticipantRepository
    public function __construct(UrlGeneratorInterface $urlGenerator, ParticipantRepository $participantRepository)
    {   // on instancie la variable de type ParticipantRepository
        $this->participantRepository = $participantRepository;
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): PassportInterface
    {
        // On crée la variable $identifier qui récupère ce que l'on trouve
        // dans la base de données
        $identifier = $request->request->get('identifiant');

        // récupération les infos de l'user en session
        $request->getSession()->set(Security::LAST_USERNAME, $identifier);

        return new Passport(
            new UserBadge($identifier, function($identifier) {
                // return le résultat de la méthode qui permet de se connecter avec
                // pseudo ou email (et qui est définie dans ParticipantRepository
                return $this->participantRepository->loadUserByIdentifier($identifier);
            }),

            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
