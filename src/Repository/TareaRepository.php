<?php

namespace App\Repository;

use App\Entity\Tarea;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tarea>
 *
 * @method Tarea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarea[]    findAll()
 * @method Tarea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TareaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarea::class);
    }

    public function save(Tarea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tarea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function filtrar(Usuario $usuario,  ?string $filtro, ?string $orden)
    {
        $consulta = $this->createQueryBuilder("t");

        $tareas = $usuario->getTareas();
        $tareasIdes = [];
        if(count($tareas) == 0){
            return[];
        }
        foreach ($tareas as &$tarea){
            array_push($tareasIdes, $tarea->getId());
        }

        $consulta->andWhere($consulta->expr()->in("t.id",$tareasIdes));
        if ($filtro && $filtro != "1") {
            switch ($filtro) {
                case '2':
                    $consulta->andWhere("t.completada = 1");
                    break;
                case '3':
                    $consulta->andWhere("t.prioridad = 'alta'");
                    break;
                case '4':
                    $consulta->andWhere("t.prioridad = 'media'");
                    break;
                case '5':
                    $consulta->andWhere("t.prioridad = 'baja'");
                    break;
            }
        }

        if ($orden) {
            switch ($orden) {
                case '1':
                    $consulta->orderBy('t.fechaCreacion', 'DESC');
                    break;
                case '2':
                    $consulta->orderBy('t.recordatorio', 'DESC');
                    break;
                case '3':
                    $consulta->orderBy('t.titulo', 'ASC');
                    break;
            }
        }
        
        return $consulta->getQuery()->getResult();
    }

    //    /**
    //     * @return Tarea[] Returns an array of Tarea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tarea
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
