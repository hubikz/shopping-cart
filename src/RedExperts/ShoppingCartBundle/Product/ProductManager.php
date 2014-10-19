<?php

namespace RedExperts\ShoppingCartBundle\Product;

use Doctrine\ORM\EntityManager;

/**
 * @author blazej.balakowicz@allegro.pl
 */
class ProductManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function getAllProducts()
    {
        return $this->entityManager->getRepository('RedExpertsShoppingCartBundle:Product')->findAll();
    }
}
 