<?php

namespace Oro\Bundle\OrganizationBundle\Provider;

use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\OrganizationAwareUserInterface;
use Oro\Bundle\UserBundle\Entity\UserInterface;
use Oro\Bundle\ScopeBundle\Manager\AbstractScopeCriteriaProvider;

class ScopeOrganizationCriteriaProvider extends AbstractScopeCriteriaProvider
{
    const SCOPE_KEY = 'organization';

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaForCurrentScope()
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return [];
        }

        $loggedUser = $token->getUser();
        if ($loggedUser instanceof User) {
            return [self::SCOPE_KEY => $loggedUser->getCurrentOrganization()];
        } elseif ($loggedUser instanceof UserInterface && $loggedUser instanceof OrganizationAwareUserInterface) {
            return [self::SCOPE_KEY => $loggedUser->getOrganization()];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaField()
    {
        return static::SCOPE_KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteriaValueType()
    {
        return Organization::class;
    }
}
