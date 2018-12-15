<?php 

namespace App\Menu;

use App\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserMenuBuilder
{
    private $user;
    private $factory;
    private $tokenStorage;

    public function __construct(FactoryInterface $factory, TokenStorage $tokenStorage)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
    }

    public function createMenu()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $menu = $this->factory->createItem('root');

        if (is_object($user)) {
            $parent = $menu->addChild('<i class="fas fa-user"></i>    ' . $user->getUsername(), ['uri' => '#']);
            $parent->setExtra('translation_domain', false); // Na pas traduire le pseudo
            
            $parent->addChild('Mon Compte', ['route' => 'user_show', 'routeParameters' => ['username' => $user->getUsername()]]);

            if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                // Ajout menu SUPER ADMIN
                $parent->addChild('Gerer utilisateur', ['route' => 'admin_user_index']);
            }
            if ($user->hasRole('ROLE_ADMIN')) {
                // Ajout menu ADMIN
                $parent->addChild('Gerer Utilisateur', ['route' => 'admin_user_index']);
            }
            
            $parent->addChild('logout', ['route' => 'fos_user_security_logout']);

        } else {
            $parent = $menu->addChild('<i class="fas fa-user"></i>', ['uri' => '#'] );
            $parent->addChild('S\'enregistrer', ['route' => 'fos_user_registration_register']);
            $parent->addChild('Se connecter', ['route' => 'fos_user_security_login']);
        }

        $menu->setChildrenAttribute('class', 'col-2');

        return $menu;
    }
}