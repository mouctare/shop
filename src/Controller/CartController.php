<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManger;
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManger = $entityManger;
    }
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart)
    {
    //   $cartComplete = [];
      
    //   if ($cart->get()) {
    //     foreach($cart->get() as $id => $quantity){
          
    //         $cartComplete[] = [
    //             'product' => $this->entityManger->getRepository(Product::class)->find($id),
    //             'quantity' => $quantity
    //         ];
    //        }  
     // Ce code est délocalisé dans Cart.php
    //}
     

  return $this->render('cart/index.html.twig', [
            'cart' =>  $cart->getFull()
           
        ]);
    }

  
    /**
     * 
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }
}
