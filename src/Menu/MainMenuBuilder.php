<?php 

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MainMenuBuilder
{
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

        $menu->addChild('EVENEMENTS', ['route' => 'evenement_index']);
        $menu->addChild('ARTISTES', ['route' => 'user_index']);
        $menu->addChild('FORMATIONS', ['route' => 'user_index']);
        $menu->addChild('LIEUX', ['route' => 'lieu_index']);

        if (is_object($user)) {
            // Ajout menu SUPER ADMIN
            $parent = $menu->addChild('EDITION', ['route' => 'evenement_index']);
            
            $parent->addChild('logout', ['route' => 'fos_user_security_logout']);


        } 

        return $menu;
    }
}