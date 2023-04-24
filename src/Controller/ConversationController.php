<?php
//CONVERSATION KONTROLER
namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Participant;
use App\Repository\ConversationRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\WebLink\Link;

class ConversationController extends AbstractController
{

    private $userRepository;

    private $entityManager;
    private $conversationRepository;
    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $entityManager,
                                ConversationRepository $conversationRepository)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->conversationRepository = $conversationRepository;
    }

    #[Route('/conversation', name:'app_conversation', methods:'POST')]

    public function index(Request $request)
    {
        if ($this->getUser() === null) {
            $this->addFlash("Not login", 'info');
            return $this->redirectToRoute('app_login');
        }

        $otherUserIdFromQuery = (int) $request->query->get('otherUser');
        $otherUser = $this->userRepository->find($otherUserIdFromQuery);

        if (is_null($otherUser)) {

            $this->addFlash("Error","You don't have friends");
            //return $this->redirectToRoute('home');
            //throw new \Exception("User was not found");
        }
        // cannot create a conversation with myself
        //if ($otherUser->getId() === $this->getUser()->getUserIdentifier()) {
           // throw new Exception("That's deep but you cannot create a conversation with yourself");
        //}

        $conversation = $this->conversationRepository->findConversationByParticipants(
            1,
            $this->getUser()->getId() //GetID
        );


        if (count($conversation)) {
            throw new Exception("The conversation already exists");
        }

        $conversation = new Conversation();

        $participant = new Participant();
        $participant->setUserId($this->getUser());
        $participant->setConversationId($conversation->getId()); //$conversation

        //dump($participant);
        $otherParticipant = new Participant();
        $otherParticipant->setUserId($otherUser);
        $otherParticipant->setConversationId($conversation->getId()); //$conversation

        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($conversation);
            $this->entityManager->persist($participant);
            $this->entityManager->persist($otherParticipant);

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }


        return $this->json([
            'id' => $conversation->getId()
        ], Response::HTTP_CREATED, [], []);
    }

    /**
     * @Route("/getConv", name="getConversations", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getConversation(Request $request){
        $conversations = $this->conversationRepository->findConversationsByUser($this->getUser()->getId());

        $hubUrl = $this->getParameter('mercure.default_hub');

        $this->addLink($request, new Link('mercure', $hubUrl));
        return $this->json($conversations);
    }

  
}
