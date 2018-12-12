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
        $menu->addChild('FORMATIONS', ['uri' => '#']);
        $menu->addChild('LIEUX', ['route' => 'lieu_index']);

        if (is_object($user)) {
            // Ajout menu edition
            $parent = $menu->addChild('EDITION', ['uri' => '#']);
            $parent->addChild('Mon profil artiste', ['uri' => '#']);
            $parent->addChild('Nouvelle formation', ['uri' => '#']);
            $parent->addChild('Nouvel évènement', ['uri' => '#']);
            $parent->addChild('Nouveau lieu', ['route' => 'lieu_new']);
        } 

        return $menu;
    }
}