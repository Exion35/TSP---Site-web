<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Room;
use App\Entity\Region;
use App\Entity\Owner;
use App\Entity\User;
use App\Entity\Comment;


use App\Repository\RoomRepository;
use App\Repository\RegionRepository;
use App\Repository\OwnerRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CommentFormType;
use App\Repository\ReservationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GeneralController extends AbstractController
{
    

    /**
     * @Route("/", name="annonces_index")
     */

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findAll();
        $regions = $em->getRepository(Region::class)->findAll();

        return $this->render('general/index.html.twig',[
            'rooms' => $rooms,
            'regions' => $regions,
            ]);

    }

    /**
     * Finds and displays a C&C entity.
     * @Route("/{id}", name="room_show0", requirements={ "id": "\d+"}, methods={"GET","POST"})
     */
    public function showAction(Room $room, Request $request): Response
    {
        $comment = new Comment();
        $comment->setRoom($room);
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('general/show.html.twig',[
            'room' => $room,
            'comments' => $room->getComments(),
            'comment_form' => $form->createView(),
        ]);
    }

    /**
     * Register to the website.
     *
     * @Route("/signup", name="signup")
     */
    public function signupAction(): Response
    {
        return $this->render('general/signup.html.twig');
    }


    /**
     * Admin panel.
     *
     * @Route("/admin", name="admin", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin(OwnerRepository $ownerRepository, RegionRepository $regionRepository, RoomRepository $roomRepository, UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        return $this->render('general/admin.html.twig',[
            'owners' => $ownerRepository->findAll(),
            'regions' => $regionRepository->findAll(),
            'rooms' => $roomRepository->findAll(),
            'users' => $userRepository->findAll(),
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * Shop.
     *
     * @Route("/shop", name="shop")
     * @IsGranted("ROLE_USER")
     */
    public function shopAction(SessionInterface $session, RoomRepository $roomRepository): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'room' => $roomRepository->find($id),
                'quantity' => $quantity,
            ];
        }

        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findAll();

        return $this->render('general/shop.html.twig',[
            'rooms' => $rooms,
            'items' => $panierWithData,
        ]);
    }

    


}
