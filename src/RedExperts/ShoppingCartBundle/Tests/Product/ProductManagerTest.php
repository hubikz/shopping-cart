<?php

namespace RedExperts\ShoppingCartBundle\Tests\Product;

use Doctrine\ORM\EntityManager;
use RedExperts\ShoppingCartBundle\Entity\ProductRepository;
use RedExperts\ShoppingCartBundle\Product\ProductManager;

/**
 * @author blazej.balakowicz@allegro.pl
 */
class ProductManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_use_valid_repository_on_entity_manager()
    {
        $emMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $productRepositoryMock = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $emMock->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('RedExpertsShoppingCartBundle:Products'))
            ->will($this->returnValue($productRepositoryMock));

        $productManager = new ProductManager($emMock);
        $productManager->getAllProducts();
    }
}
 