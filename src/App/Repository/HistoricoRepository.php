<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HistoricoEntity;
use PDO;

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

    public function insert(): HistoricoEntity
    {
        return new HistoricoEntity();
    }

    public function getAll(): array
    {
        $stmt = $this->setInstance->prepare("select * from historico ORDER BY idhistorico");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByCombustivel(int $idCombustivel): array
    {
        $stmt = $this->setInstance->prepare("select data, valor, comparacao from historico where idcombustivel = ? ");
        $stmt->bindValue(1, $idCombustivel);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, HistoricoEntity::class);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByCombustivel(int $idCombustivel): HistoricoEntity
    {
        $stmt = $this->setInstance->prepare("select MAX(data), valor from historico where idcombustivel = ? GROUP BY valor ");
        $stmt->bindValue(1, $idCombustivel);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, HistoricoEntity::class);
        $stmt->execute();
        return $stmt->fetch();
    }
}