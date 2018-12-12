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
            $parent = $menu->addChild($user->getUsername(), ['uri' => '#']);
            $parent->setExtra('translation_domain', false); // Na pas traduire le pseudo
            
            $parent->addChild('mon_compte', ['route' => 'user_show', 'routeParameters' => ['username' => $user->getUsername()]]);
            $parent->addChild('logout', ['route' => 'fos_user_security_logout']);
            
            if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                // Ajout menu SUPER ADMIN
                $menu->addChild('Gerer utilisateur', ['route' => 'admin_user_index']);
            }
            if ($user->hasRole('ROLE_ADMIN')) {
                // Ajout menu ADMIN
                $menu->addChild('Gerer utilisateur', ['route' => 'admin_user_index']);
                
                
            }
        } else {
            $menu->addChild('register', ['route' => 'fos_user_registration_register']);
            $menu->addChild('login', ['route' => 'fos_user_security_login']);
        }

       

        return $menu;
    }
}