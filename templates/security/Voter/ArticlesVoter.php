<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticlesVoter extends Voter
{
    const ADD = 'ARTICLE_ADD';
    const EDIT = 'ARTICLE_EDIT';
    const DELETE = 'ARTICLE_DELETE';


    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $article): bool
    {
        return in_array($attribute, [self::ADD, self::EDIT, self::DELETE])
            && $article instanceof Article;
    }

    protected function voteOnAttribute($attribute, $article, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::ADD:
                return $this->canAdd();
            case self::EDIT:
                return $this->canEdit();
            case self::DELETE:
                return $this->canDelete();
        }

        return false;
    }

    private function canAdd(): bool
    {
        return $this->security->isGranted('ROLE_ARTICLE_ADMIN');
    }

    private function canEdit(): bool
    {
        return $this->security->isGranted('ROLE_ARTICLE_ADMIN');
    }

    private function canDelete(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }
}
