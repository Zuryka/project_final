<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['editArtiste', 'viewArtiste', 'createArtiste'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        // if (!$user instanceof UserInterface) {
        //     return false;
        // }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            
            case 'editArtiste':
            case 'createArtiste':
            // Vérifier que l'utilisateur est connecté
            if (!$user instanceof UserInterface) {
                return false;
            }
            
            // Si on est SUPER_ADMIN
            if ($user->hasRole('ROLE_SUPER_ADMIN')) {
                return true;
            }
            
            return in_array(User::TYPE_ARTISTE, $user->getType());
            break;

            case 'viewArtiste':
                // logic to determine if the user can VIEW
                return true;
                break;
        }

        return false;
    }
}
