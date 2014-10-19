<?php

namespace RedExperts\ShoppingCartBundle\ShoppingCart;

use Doctrine\ORM\EntityManager;
use RedExperts\ShoppingCartBundle\Entity\OrderLog;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author blazej.balakowicz@allegro.pl
 */
class ShoppingCartManager
{
    const BASKET_NAME = 'basket';
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Session
     */
    private $session;

    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function clearShoppingCart()
    {
        $this->getSession()->set(self::BASKET_NAME, []);
    }

    public function get()
    {
        return $this->getSession()->get(self::BASKET_NAME, []);
    }

    public function add(OrderLog $order)
    {
        $session = $this->getSession();
        $order->setSessionId($session->getId());
        $order->setCreatedAt(new \DateTime());

        //save in session here
        $shoppingCart = $this->get();
        $shoppingCart[] = $order->getProduct();
        $session->set(self::BASKET_NAME, $shoppingCart);

        $this->em->persist($order);
        $this->em->flush();
    }

    private function getSession()
    {
        return $this->session;
    }
}
 