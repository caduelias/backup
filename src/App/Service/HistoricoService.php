<?php

declare(strict_types=1);

namespace App\Service;

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

    public function insert()
    {
        return $this->repository->insert();
    }
    
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getAllByCombustivel(int $idCombustivel): array
    {
        return $this->getAllByCombustivel($idCombustivel);
    }

    public function getByCombustivel(int $idCombustivel): HistoricoEntity
    {
        return $this->getByCombustivel($idCombustivel);
    }
}