<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $message): void
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }

    public function getDirectListOf(int $userId)
    {
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//        $queryBuilder
//            ->select('u')
//            ->from(User::class, 'u')
//            ->where('u.id')
//            ->join(
//                '(' .
//                $queryBuilder->select('m.user_recive AS userId')
//                    ->from(Message::class, 'm')
//                    ->where('m.user_sender = :userId')
//                    ->getDQL() .
//                ' UNION ' .
//                $queryBuilder->select('m.user_sender AS userId')
//                    ->from('Message', 'm')
//                    ->where('m.user_recive = :userId')
//                    ->getDQL() .
//                ')',
//                'ur',
//                'WITH',
//                'u.id = ur.userId'
//            )
//            ->setParameter('userId', $userId);
//
//        return $queryBuilder->getQuery()->getResult();


//        $sql = "SELECT u.name,u.name  FROM App\Entity\User u
//        JOIN (
//            SELECT user_recive_id AS userId FROM message WHERE user_sender_id = :userId
//            UNION
//            SELECT user_sender_id AS userId FROM message WHERE user_recive_id = :userId
//        ) ur
//        ON u.id = ur.userId";
//
//        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createQuery($sql);
//        $query->setParameter('userId', $userId);
//
//        return $query->getResult();


//        $inner = $conn->createQueryBuilder();
//        $inner->select('id')
//            ->from('users');
//
//        $outer = $conn->createQueryBuilder();
//        $outer->select('*')
//            ->from('(' . $outer->importSubQuery($inner) . ')', 'q');
//       // JOINing sub-queries:
//$outer = $conn->createQueryBuilder();
//$outer->select('*')
//    ->from('users', 'u')
//    ->join('q', '(' . $outer->importSubQuery($inner) . ')', 'u', 'q.id = u.id');
////Using sub-queries in the IN clause:
//$outer = $conn->createQueryBuilder();
//$outer->select('*')
//    ->from('users')
//    ->where('id IN(' . $outer->importSubQuery($in)


//        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createNativeQuery($sql, new ResultSetMapping());
//
//        $query->setParameter('userId', $userId);
//      return  $query->getResult();


    }

    public function selectMessage(User $user_sender): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $query = $queryBuilder
            ->select('m')
            ->from(Message::class, 'm')
            ->where('m.user_sender = :user_sender')
            ->setParameter('user_sender', $user_sender)
            ->getQuery();
        return $query->getResult();
    }

    /**
     * @return Message[]
     */
    public function getMessagesBySenderId(int $senderId): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('message')
            ->from(Message::class, 'message')
            ->where('message.user_sender = :userId')
            ->setParameter('userId', $senderId)
            ->getQuery();

        return $query->getResult();
    }

    public function getMessagesByReceiverId(int $receiverId): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('message')
            ->from(Message::class, 'message')
            ->where('message.user_recive = :userId')
            ->setParameter('userId', $receiverId)
            ->getQuery();

        return $query->getResult();
    }


    public function getMessagesBetweenTwoUsers(int $user1Id, int $user2Id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('message')
            ->from(Message::class, 'message')
            ->where(
                $queryBuilder->expr()->orX(  // (Z AND W) OR (Z AND J)
                    $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('message.user_sender', ':user1Id'),
                        $queryBuilder->expr()->eq('message.user_recive', ':user2Id'),
                    ),
                    $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('message.user_recive', ':user1Id'),
                        $queryBuilder->expr()->eq('message.user_sender', ':user2Id'),
                    )
                )
            )
            ->setParameter('user1Id', $user1Id)
            ->setParameter('user2Id', $user2Id)
            ->getQuery();

        return $query->getResult();
    }







//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}



//
//SELECT * user WHERE user.id IN (
//    SELECT message.user_recive_id
//        FROM   message
//        WHERE  message.user_sender_id = 14
//        UNION
//        SELECT message.user_sender_id
//        FROM   message
//        WHERE  message.user_recive_id = 14
//)