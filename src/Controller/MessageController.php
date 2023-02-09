<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class MessageController extends AbstractController
{
    const ATTRIBUTES_TO_SERIALIZE = ['id', 'content', 'createdAt', 'mine'];

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ParticipantRepository
     */
    private $participantRepository;
    /**
     * @var PublisherInterface
     */
    private $publisher;

    public function __construct(EntityManagerInterface $entityManager,
                                MessageRepository $messageRepository,
                                UserRepository $userRepository,
                                ParticipantRepository $participantRepository,
                                PublisherInterface $publisher)
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
        $this->participantRepository = $participantRepository;
        $this->publisher = $publisher;
    }


    /**
     * @Route("message/{conversationId}", name="getMessages", methods={"GET"})
     * @param Request $request
     * @param int $conversationId
     * @return Response
     */
    public function index(Request $request, int $conversationId)
    {
        $conversation = $this->entityManager->getRepository(Conversation::class)->find($conversationId);

        //$this->denyAccessUnlessGranted('view', $conversation);

        $messages = $this->messageRepository->findMessageByConversationId(
            $conversation
        );

        if ($messages) {
            $httpJsonStatus = Response::HTTP_OK;

            /**
             * @var $message Message
             */
            array_map(function ($message){
                $message->setMine(
                    $message->getUserId() === $this->getUser()
                        ? true : false
                );
            }, $messages);

            $httpJsonData = $messages;
        } else {
            $httpJsonStatus = Response::HTTP_NOT_FOUND;
            $httpJsonData = ["status" => "Not Found"];
        }

       return $this->json($httpJsonData, $httpJsonStatus, [],[
           'attributes' => self::ATTRIBUTES_TO_SERIALIZE
       ]);
    }

    /**
     * @Route("/message/new/{conversationId}", name="newMessage", methods={"POST"})
     * @param Request $request
     * @param int $conversationId
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws Exception
     */
    public function newMessage(Request $request, int $conversationId, SerializerInterface $serializer)
    {
        $user = $this->getUser();

        $recipent = $this->participantRepository->findParticipantByConverstionIdAndUserId(
            $conversationId,
            $user->getId()
        );

        $content = $request->get('content', null);
        $message = new Message();
        $message->setContent($content);
        $message->setUserId($user);

        $conversation->addMessage($message);
        $conversation->setLastMessageId($message);

        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($message);
            $this->entityManager->persist($conversation);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
        $message->setMine(false);
        $messageSerialized = $serializer->serialize($message, 'json', [
            'attributes' => ['id', 'content', 'createdAt', 'mine', 'conversation' => ['id']]
        ]);
        $update = new Update(
            [
                sprintf("/conversation/%s", $conversation->getId()),
                sprintf("/conversation/%s", $recipent->getUser()->getEmail()),
            ],
            $messageSerialized,
            [
                sprintf("/%s", $recipent->getUser()->getEmail())
            ]
        );

        $this->publisher->__invoke($update);

        $message->setMine(true);
        return $this->json($message, Response::HTTP_CREATED, [], [
            'attributes' => self::ATTRIBUTES_TO_SERIALIZE
        ]);
    }
}
