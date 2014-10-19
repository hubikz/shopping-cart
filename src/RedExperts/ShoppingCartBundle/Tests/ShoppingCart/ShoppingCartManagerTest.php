<?php

namespace RedExperts\ShoppingCartBundle\Tests\ShoppingCart;

use Doctrine\ORM\EntityManager;
use RedExperts\ShoppingCartBundle\Entity\OrderLog;
use RedExperts\ShoppingCartBundle\Entity\Product;
use RedExperts\ShoppingCartBundle\ShoppingCart\ShoppingCartManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * @author blazej.balakowicz@allegro.pl
 */
class ShoppingCartManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function should_add_product_to_shopping_cart()
    {
        $session = new Session(new MockArraySessionStorage());
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product = new Product();
        $product->setName("Some name #1");
        $order = new OrderLog();
        $order->setProduct($product);

        $shoppingCartManager = new ShoppingCartManager($em, $session);
        $shoppingCartManager->add($order);

        $this->assertEquals([$product], $session->get(ShoppingCartManager::BASKET_NAME));
    }

    /**
     * @test
     */
    public function should_append_product_to_shopping_cart()
    {
        $session = new Session(new MockArraySessionStorage());
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product = new Product();
        $product->setName("Some name #1");

        $session->set(ShoppingCartManager::BASKET_NAME, [$product]);

        $order = new OrderLog();
        $order->setProduct($product);

        $shoppingCartManager = new ShoppingCartManager($em, $session);
        $shoppingCartManager->add($order);

        $this->assertEquals([$product, $product], $session->get(ShoppingCartManager::BASKET_NAME));
    }

    /**
     * @test
     */
    public function should_clear_shopping_cart()
    {
        $session = new Session(new MockArraySessionStorage());
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product = new Product();
        $product->setName("Some name #1");

        $session->set(ShoppingCartManager::BASKET_NAME, [$product]);

        $shoppingCartManager = new ShoppingCartManager($em, $session);
        $shoppingCartManager->clearShoppingCart();

        $this->assertEquals([], $shoppingCartManager->get());
    }

}
 