<?php
namespace App\Service\Trait;

trait LoggedUserTrait
{
    /**
     * Get Current logged vermittler user
     *
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getCurrentUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The Security Bundle is not registered in your application.');
        }
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }
        return $user;
    }

    /**
     * Get vermittler id of current user
     *
     * @return int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getVermittlerId()
    {
        $user = $this->getCurrentUser();
      //  $vermittler =  $user->getVermittler();

        return 1000;// $vermittler->getId();
    }
}