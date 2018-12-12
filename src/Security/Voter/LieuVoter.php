<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

class LieuVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['edit', 'view', 'create'])
            && $subject instanceof \App\Entity\Lieu;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        /*if (!$user instanceof UserInterface) {
            return false;
        }*/

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'edit':
                // logic to determine if the user can EDIT
                // return true or false
                // Si on est pas connecté
                if (!$user instanceof UserInterface) {
                    return false;
                }

                // Si on est SUPER_ADMIN
                if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                    return true;
                }

                // Sinon, si on est le createur
                return $subject->getUserCreateur()->getId() == $user->getId();
                
                break;
            case 'view':
                // logic to determine if the user can VIEW
                return true;
                break;
            case 'create':
                // Vérifier que l'utilisateur est connecté
                if (!$user instanceof UserInterface) {
                    return false;
                }

                // Si on est SUPER_ADMIN
                if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                    return true;
                }

                return in_array(User::TYPE_GERANT_SALLE, $user->getType());
                
                break;
        }

        return false;
    }
}
