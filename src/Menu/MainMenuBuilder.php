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
        
        $menu->setChildrenAttribute('class', 'col-12 px-0');

        if (is_object($user)) {
            // Ajout menu edition
            $parent = $menu->addChild('EDITION', ['uri' => '#'], array('attributes' => array('class' => 'col-2 text-center')));
            $parent->setAttributes(array('class' => 'col-2 text-center'));

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

            $parent = $menu->addChild($user->getUsername(), ['uri' => '#'], array('attributes' => array('class' => 'col-2 text-center')));
            $parent->setExtra('translation_domain', false); // Na pas traduire le pseudo
            $parent->setAttributes(array('class' => 'col-2 text-center'));
            
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
            $menu->addChild('register', ['route' => 'fos_user_registration_register'], array('attributes' => array('class' => 'col-2 text-center')));
            $menu->addChild('login', ['route' => 'fos_user_security_login'], array('attributes' => array('class' => 'col-2 text-center')));

            $menu['register']->setAttributes(array('class' => 'col-2 text-center'));
            $menu['login']->setAttributes(array('class' => 'col-2 text-center'));
        }

        return $menu;
    }
}