<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ConversationController extends AbstractController
{

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, ConversationRepository $conversationRepository)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->conversationRepository = $conversationRepository;
    }
    #[Route('/conversation', name: 'app_conversation', methods:'POST')]

    private $userRepository;

    private $entityManager;

    private $conversationRepository;

    
    public function index(Request $request)
    {
        $otherUser = $request->get('otherUser',default:0);
        $otherUser = $this->userRepository->find($otherUser);

        if (is_null($otherUser)) {
            throw new \Exception("User was not found");
        }

        // cannot create a conversation with myself
        if ($otherUser->getId() === $this->getUser()->getUserIdentifier()) {
            throw new \Exception("That's deep but you cannot create a conversation with yourself");
        }

        // Check if conversation exists
        $conversation = $this->conversationRepository->findConversationByParticipants(
            $otherUser->getId(),
            $this->getUser()->getUserIdentifier() //GetID
        );


        if (count($conversation)) {
            throw new \Exception("The conversation already exists");
        }

        $conversation = new Conversation();

        $participant = new Participant();
        $participant->setUser($this->getUser());
        $participant->setConversationId($conversation);


        $otherParticipant = new Participant();
        $otherParticipant->setUserId($this->getUser());
        $otherParticipant->setConversationId($conversation);

        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($conversation);
            $this->entityManager->persist($participant);
            $this->entityManager->persist($otherParticipant);

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }


        return $this->json([
            'id' => $conversation->getId()
        ], Response::HTTP_CREATED, [], []);
        
    }

  
}
