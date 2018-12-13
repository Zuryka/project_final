<?php 

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use App\Entity;

class MainMenuBuilder
{
    private $factory;
    private $tokenStorage;
    private $autorisationChecker;

    public function __construct(FactoryInterface $factory, TokenStorage $tokenStorage, AuthorizationChecker $autorisationChecker)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
        $this->autorisationChecker = $autorisationChecker;
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
            if ($this->autorisationChecker->isGranted('editArtiste', $user))
            {
                $parent->addChild('Mon profil artiste', ['uri' => '#']);
            }
            if ($this->autorisationChecker->isGranted('create', new Entity\Formation))
            {
                $parent->addChild('Nouvelle formation', ['uri' => '#']);
            }
            if ($this->autorisationChecker->isGranted('create', new Entity\Evenement))
            {
                $parent->addChild('Nouvel évènement', ['route' => 'evenement_new']);
            }
            if ($this->autorisationChecker->isGranted('create', new Entity\Lieu))
            {
                $parent->addChild('Nouveau lieu', ['route' => 'lieu_new']);
            }
        } 

        

        return $menu;
    }
}