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
            $idCombustivel = $entity->getIdCombustivel();
            $valor = $entity->getValor();
            $data = $entity->getData();
            $stmt = $this->setInstance->prepare("insert into historico(idhistorico, idcombustivel, valor, data) values (NULL, ?, ?, ?)");
            $stmt->bindParam(1, $idCombustivel);
            $stmt->bindParam(2, $valor);
            $stmt->bindParam(3, $data);
            $stmt->execute();
        } catch(Exception $e) {
            throw new DatabaseException("Erro ao inserir");
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->setInstance->prepare("select * from historico ORDER BY idhistorico");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            throw new DatabaseException("Erro ao buscar");
        }
       
    }

    public function getAllByCombustivel(int $idCombustivel): array
    {
        try {
            $stmt = $this->setInstance->prepare("select data, valor from historico where idcombustivel = ? ");
            $stmt->bindParam(1, $idCombustivel);
            $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            throw new DatabaseException("Erro ao buscar");
        }
    }  

    public function getByCombustivel(int $idCombustivel): HistoricoEntity
    {
        try {
            $stmt = $this->setInstance->prepare("select valor from historico where idcombustivel = ? and valor <> 0 order by idhistorico desc limit 1 ");
            $stmt->bindParam(1, $idCombustivel);
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, HistoricoEntity::class);
            $stmt->execute();
            return $stmt->fetch();
        } catch(Exception $e) {
            throw new DatabaseException("Erro ao buscar por combustivel");
        }

    }

    public function getByData(int $idCombustivel, string $datainicial, string $datafinal): ?array
    {
        try {
            $stmt = $this->setInstance->prepare("select data, valor from historico where idcombustivel = :idcombustivel and data >= :datainicial and data <= :datafinal and valor <> 0 order by idhistorico desc limit 1");
            $stmt->bindValue(':idcombustivel', $idCombustivel);
            $stmt->bindValue(':datainicial', $datainicial);
            $stmt->bindValue(':datafinal', $datafinal);
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, HistoricoEntity::class);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(Exception $e) {
            throw new DatabaseException("Erro ao buscar por data");
        }
       
    }
}