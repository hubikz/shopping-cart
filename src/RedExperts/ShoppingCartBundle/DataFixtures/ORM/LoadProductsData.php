<?php

namespace RedExperts\ShoppingCartBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RedExperts\ShoppingCartBundle\Entity\Product;

class LoadProductsData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        foreach ($this->getProductsNames() as $productName) {
            $product = new Product();
            $product->setName($productName);

            $manager->persist($product);
        }
        $manager->flush();
    }

    private function getProductsNames()
    {
        return [
            'Product name #1',
            'Product name #2',
            'Product name #3',
        ];
    }
}
 