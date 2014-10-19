<?php

namespace RedExperts\ShoppingCartBundle\Controller;

use RedExperts\ShoppingCartBundle\Entity\OrderLog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="products_list")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $products = $this->get('red_experts_shopping_cart.product_manager')->getAllProducts();

        $order = new OrderLog();
        $form = $this->createFormBuilder($order)
            ->setAction("/")
            ->add('product', 'entity', [
                'class' => 'RedExpertsShoppingCartBundle:Product',
                'choices' => $products,
                'property' => 'name',
                'expanded' => true,
            ])
            ->add('save', 'submit', array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        $session = $request->getSession();
        $shoppingCart = $session->get('basket', []);

        if ($form->isValid()) {
            /** @var OrderLog $orderLog */
            $orderLog = $form->getData();
            $orderLog->setSessionId($request->getSession()->getId());
            $orderLog->setCreatedAt(new \DateTime());

            //save in session here
            $shoppingCart[] = $orderLog->getProduct();
            $session->set('basket', $shoppingCart);

            $em = $this->get('doctrine.orm.default_entity_manager');
            $em->persist($orderLog);
            $em->flush();

            return $this->redirect($this->generateUrl("products_list"));
        }

        return [
            'products' => $products,
            'shoppingCart' => $shoppingCart,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/clear-cart", name="clear_cart")
     */
    public function clearCartAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('basket', []);

        return $this->redirect($this->generateUrl("products_list"));
    }
}
