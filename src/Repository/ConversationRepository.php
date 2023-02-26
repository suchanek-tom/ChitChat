<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conversation>
 *
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    public function add(Conversation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conversation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Conversation[] Returns an array of Conversation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Conversation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findConversationByParticipants(int $otherUserId, int $myId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->select($qb->expr()->count('p.conversation_id'))
            ->innerJoin('c.participants', 'p')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->eq('p.user_id', ':me'),
                    $qb->expr()->eq('p.user_id', ':otherUser')
                )
            )
            ->groupBy('p.conversation_id')
            ->having(
                $qb->expr()->eq(
                    $qb->expr()->count('p.conversation_id'),
                    2
                )
            )
            ->setParameters([
                'me' => $myId,
                'otherUser' => $otherUserId
            ])
        ;

        return $qb->getQuery()->getResult();
    }

     public function findConversationsByUser(int $userId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->
            select('otherUser.email', 'c.id as conversationId', 'lm.content', 'lm.createdAt')
            ->innerJoin('c.participants', 'p', Join::WITH, $qb->expr()->neq('p.user', ':user'))
            ->innerJoin('c.participants', 'me', Join::WITH, $qb->expr()->eq('me.user', ':user'))
            ->leftJoin('c.lastMessage', 'lm')
            ->innerJoin('me.user', 'meUser')
            ->innerJoin('p.user', 'otherUser')
            ->where('meUser.id = :user')
            ->setParameter('user', $userId)
            ->orderBy('lm.createdAt', 'DESC')
        ;
        
        return $qb->getQuery()->getOneOrNullResult();
    }
}
