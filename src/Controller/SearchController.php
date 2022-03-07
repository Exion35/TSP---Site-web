<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchRoomType;
use App\Repository\RoomRepository;

class SearchController extends AbstractController{

/**
 * @Route("room/search", name="search_room")
 * 
 */

 public function searchRoom(Request $request, RoomRepository $roomRepository){
    $rooms = [];
    $searchRoomForm = $this->createForm(SearchRoomType::class);

    if ($searchRoomForm->handleRequest($request)->isSubmitted() && $searchRoomForm->isValid()) {
        $criteria = $searchRoomForm->getData();
        $rooms = $roomRepository->searchRoom($criteria);
    }

    return $this->render('search/room.html.twig',[
        'search_form' => $searchRoomForm->createView(),
        'rooms' => $rooms,
    ]);
 }

}