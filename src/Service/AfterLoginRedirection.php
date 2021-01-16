<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AfterLoginRedirection
 *
 * @package App\Service
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface {
private $router;

/**
     * AfterLoginRedirection constructor.
     *
     * @paramRouterInterface $router
     */
public function __construct(RouterInterface$router)
    {
        $this->router = $router;
    }

/**
     * @paramRequest        $request
     *
     * @paramTokenInterface $token
     *
     * @return RedirectResponse
     */
public function onAuthenticationSuccess(Request $request, TokenInterface$token)
    {
$roles = $token->getRoles();

$rolesTab= array_map(function ($role) {
return $role->getRole();
        }, $roles);

if (in_array('ROLE_ADMIN', $rolesTab, true)) {
// c'est un aministrateur : on le redirigerversl'espace admin
$redirection = new RedirectResponse($this->router->generate('ins'));
        } else {
// c'est un utilisaeur lambda : on le redirigerversl'accueil
$redirection = new RedirectResponse($this->router->generate('repas_index'));
        }

return $redirection;
    }
}
