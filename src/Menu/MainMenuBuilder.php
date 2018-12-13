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

        $menu->addChild('EVENEMENTS', ['route' => 'evenement_index'], array('attributes' => array('class' => 'col-2 text-center')));
        $menu->addChild('ARTISTES', ['route' => 'user_index'], array('attributes' => array('class' => 'col-2 text-center')));
        $menu->addChild('FORMATIONS', ['route' => 'formation_index'], array('attributes' => array('class' => 'col-2 text-center')));
        $menu->addChild('LIEUX', ['route' => 'lieu_index'], array('attributes' => array('class' => 'col-2 text-center')));
        
        $menu['EVENEMENTS']->setAttributes(array('class' => 'col-2 text-center'));
        $menu['ARTISTES']->setAttributes(array('class' => 'col-2 text-center'));
        $menu['FORMATIONS']->setAttributes(array('class' => 'col-2 text-center'));
        $menu['LIEUX']->setAttributes(array('class' => 'col-2 text-center'));
        
        $menu->setChildrenAttribute('class', 'col-8');

        if (is_object($user)) {
            // Ajout menu edition
            $parent = $menu->addChild('EDITION', ['uri' => '#']);

            if ($this->autorisationChecker->isGranted('editArtiste', $user))
            {
                $parent->addChild('Mon profil artiste', ['uri' => '#']);
            }
            if ($this->autorisationChecker->isGranted('create', new Entity\Formation))
            {

            // if ($this->autorisationChecker->isGranted('createArtiste', $user))
            // {
                $parent->addChild('Mon profil artiste', ['route' => 'user_artiste_edit', 'routeParameters' => ['username' => $user->getUsername()]]);
            // }
            // if ($this->autorisationChecker->isGranted('create', $lieu))
            // {

                $parent->addChild('Nouvelle formation', ['route' => 'formation_new']);
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