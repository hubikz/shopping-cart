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

        $shoppingCartManager = $this->get('red_experts_shopping_cart.shopping_cart_manager');
        if ($form->isValid()) {
            $shoppingCartManager->add($form->getData());
            return $this->redirect($this->generateUrl("products_list"));
        }

        return [
            'products' => $products,
            'shoppingCart' => $shoppingCartManager->get(),
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
