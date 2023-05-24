<?php

namespace App\Repository;

use App\Entity\Export;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Export>
 *
 * @method Export|null find($id, $lockMode = null, $lockVersion = null)
 * @method Export|null findOneBy(array $criteria, array $orderBy = null)
 * @method Export[]    findAll()
 * @method Export[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Export::class);
    }

    public function save(Export $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Export $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getPaginatedExportsByMonth(int $page): array
    {
        //min and max
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT MIN(YEAR(date)) AS minYear, MAX(YEAR(date)) AS maxYear FROM export';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $result = $resultSet->fetchAllAssociative();

        $minYear = (int)$result[0]['minYear'];
        $maxYear =(int)$result[0]['maxYear'];

        $minMonth = 1;
        $maxMonth = 12;

        //get all data
        $sql = 'SELECT * FROM export';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $exports = $resultSet->fetchAllAssociative();

     





        $monthCounts = array_fill($minYear, $maxYear - $minYear + 1, array_fill($minMonth, $maxMonth, 0));

        $qb = $this->createQueryBuilder('i')
            ->orderBy('i.date', 'ASC');

        $exports = $qb->getQuery()->getResult();

  


        foreach ($exports as $export) {
            $year = (int) $export->getDate()->format('Y');
            $month = (int) $export->getDate()->format('n');

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

        $exportPages =[];
        foreach ($monthCounts as $year => $yearCounts){
            $currentYear = $year;


            foreach($yearCounts as $month =>$monthCount){
                if ($monthCount > 0) {
                    $startDate = new DateTime(sprintf('%s-%02d-01 00:00:00', $year, $month));
                    $endDate = clone $startDate;
                    $endDate->modify('last day of this month');
                    $exportResults = $this->createQueryBuilder('i')
                        ->andWhere('YEAR(i.date) = :year AND MONTH(i.date) = :month')
                        ->setParameter('year', $year)
                        ->setParameter('month', $month)
                        ->orderBy('i.date', 'DESC')
                        ->getQuery()
                        ->getResult();

                    

                    $exportPages[]=$exportResults;
                }
            }

        }

        

        $totalPage = count($exportPages);

        if ($page < 1 || $page > $totalPage) {
//            throw new NotFoundHttpException(sprintf('Page "%s" does not exist.', $page));
            return [
                'error' => "max page out of".$page,
                'message'=> "No content found for this page",
                'size'=>"$totalPage"
            ];
        }


        $pagination = [
            'page' => $page,
            'total_pages' => count($exportPages),
            'exports' => $exportPages[$page-1]
        ];



        return $pagination;
    }

//    /**
//     * @return Export[] Returns an array of Export objects
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

//    public function findOneBySomeField($value): ?Export
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
