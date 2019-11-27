<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\HistoricoEntity;
use App\Repository\HistoricoRepository;

class HistoricoService
{
    /**
     * @var HistoricoRepository
     */
    private $repository;

    public function __construct(HistoricoRepository $repository)
    { 
        $this->repository = $repository;
    }

    public function insert($historicoEntity)
    {
        $this->repository->insert($historicoEntity);
    }
    
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getAllByCombustivel(int $idCombustivel): array
    {
        return $this->repository->getAllByCombustivel($idCombustivel);
    }

    public function getByCombustivel(int $idCombustivel): ?HistoricoEntity
    {
        return $this->repository->getByCombustivel($idCombustivel);
    }

    public function getByData(int $idCombustivel, string $datainicial, string $datafinal): ?HistoricoEntity
    {
        return $this->repository->getByData($idCombustivel, $datainicial, $datafinal);
    }

    public function calculateValues(float $valorEta, float $valorGas): float
    {  
        $comparacao = ($valorEta / $valorGas);

        return $comparacao;
    }
}