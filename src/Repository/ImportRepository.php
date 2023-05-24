<?php

namespace App\Repository;

use App\Entity\Import;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Import>
 *
 * @method Import|null find($id, $lockMode = null, $lockVersion = null)
 * @method Import|null findOneBy(array $criteria, array $orderBy = null)
 * @method Import[]    findAll()
 * @method Import[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Import::class);
    }

    public function save(Import $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Import $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function findMinYear($qb)
    {
        $qb->select('MIN(DATE_FORMAT(i.date, "%Y")) AS minYear');
        $query = $qb->getQuery();
        $result = $query->getSingleResult();

        return $result['minYear'];
    }

    public function findMaxYear($qb)
    {
        $qb->select('MAX(DATE_FORMAT(i.date, "%Y")) AS maxYear');
        $query = $qb->getQuery();
        $result = $query->getSingleResult();

        return $result['maxYear'];
    }



    
    public function getPaginatedImportsByMonth(int $page): array
    {
        //min and max
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT MIN(YEAR(date)) AS minYear, MAX(YEAR(date)) AS maxYear FROM import';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $result = $resultSet->fetchAllAssociative();

        $minYear = (int)$result[0]['minYear'];
        $maxYear =(int)$result[0]['maxYear'];

        $minMonth = 1;
        $maxMonth = 12;

        //get all data
        $sql = 'SELECT * FROM import';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $imports = $resultSet->fetchAllAssociative();





        $monthCounts = array_fill($minYear, $maxYear - $minYear + 1, array_fill($minMonth, $maxMonth, 0));

        $qb = $this->createQueryBuilder('i')
            ->orderBy('i.date', 'ASC');

        $imports = $qb->getQuery()->getResult();



        foreach ($imports as $import) {
            $year = (int) $import->getDate()->format('Y');
            $month = (int) $import->getDate()->format('n');

            $monthCounts[$year][$month]++;
        }



        $monthCounts = array_filter($monthCounts, function ($yearCounts) {
            return array_sum($yearCounts) > 0;
        });

        $reversedArray = array_reverse($monthCounts, true);


        foreach ($reversedArray as &$innerArray) {
            $innerArray = array_reverse($innerArray, true);
        }


        $monthCounts=$reversedArray;


        $importPages =[];
        foreach ($monthCounts as $year => $yearCounts){
            $currentYear = $year;

        

            foreach($yearCounts as $month =>$monthCount){
                if ($monthCount > 0) {
                    $startDate = new DateTime(sprintf('%s-%02d-01 00:00:00', $year, $month));
                    $endDate = clone $startDate;
                    $endDate->modify('last day of this month');
                    $importResults = $this->createQueryBuilder('i')
                        ->andWhere('YEAR(i.date) = :year AND MONTH(i.date) = :month')
                        ->setParameter('year', $year)
                        ->setParameter('month', $month)
                        ->orderBy('i.date', 'DESC')
                        ->getQuery()
                        ->getResult();

                    $importPages[]=$importResults;
                }
            }

        }

        $totalPage = count($importPages);

        if ($page < 1 || $page > $totalPage) {
//            throw new NotFoundHttpException(sprintf('Page "%s" does not exist.', $page));
            return [
                'error' => "max page",
                'message'=> "No content found for this page"
            ];
        }


        $pagination = [
            'page' => $page,
            'total_pages' => count($importPages),
            'imports' => $importPages[$page-1]
        ];



        return $pagination;
    }




//    /**
//     * @return Import[] Returns an array of Import objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Import
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
