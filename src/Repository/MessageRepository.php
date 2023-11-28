<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function showUser(int $user_sender)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('message')
            ->from(Message::class, 'message')
            ->where('message.user_sender = :userId')
            ->setParameter('userId', $user_sender)
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
            ->setParameter('user1Id',$user1Id)
            ->setParameter('user2Id',$user2Id)
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
