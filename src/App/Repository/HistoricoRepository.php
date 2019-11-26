<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HistoricoEntity;
use App\Exception\DatabaseException;
use PDO;
use Exception;

class HistoricoRepository implements HistoricoInterfaceRepository
{
    /**
     * @var PDO
     */
    private $setInstance;
 
    public function __construct(
        PDO $setInstance
    )
    {
        $this->setInstance = $setInstance;
    }

    public function insert($entity)
    {
        try {
            $stmt = $this->setInstance->prepare("insert into historico(idhistorico, idcombustivel, valor, data) values (NULL, ?, ?, ?)");
            $stmt->bindParam(1, $entity->getIdCombustivel());
            $stmt->bindParam(2, $entity->getValor());
            $stmt->bindParam(3, $entity->getData());
            return $stmt->execute();
        } catch (DatabaseException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getAll(): array
    {
        $stmt = $this->setInstance->prepare("select * from historico ORDER BY idhistorico");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByCombustivel(int $idCombustivel): array
    {
        $stmt = $this->setInstance->prepare("select data, valor from historico where idcombustivel = ? ");
        $stmt->bindValue(1, $idCombustivel);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function getByCombustivel(int $idCombustivel): HistoricoEntity
    {
        $stmt = $this->setInstance->prepare("select valor from historico where idcombustivel = ? and valor <> 0 order by idhistorico desc limit 1 ");
        $stmt->bindValue(1, $idCombustivel);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, HistoricoEntity::class);
        $stmt->execute();
        return $stmt->fetch();
    }

    // public function getByData(string $data): HistoricoEntity
    //{
    //    return;
    //}
}