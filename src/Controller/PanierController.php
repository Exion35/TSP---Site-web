<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index", methods={"GET"})
     */
    public function index(SessionInterface $session, RoomRepository $roomRepository): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = array();
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'room' => $roomRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        
        $total = 0;

        foreach($panierWithData as $item){
            if ($item['room']->getOnSale()){
                $totalItem = ($item['room']->getPrice()-5)*$item['quantity'];
            }
            else{
                $totalItem = $item['room']->getPrice()*$item['quantity'];
            }
            $total += $totalItem;
        }

        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/add/{id}", name="panier_add")
     */
    public function add($id, SessionInterface $session){

        $panier = $session->get('panier',[]);
        $panier[$id] = 1;

        $session->set('panier',$panier);
        return $this->redirectToRoute('shop', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/remove/{id}", name="panier_remove")
     */
    public function remove($id, SessionInterface $session){

        $panier = $session->get('panier',[]);
        
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
