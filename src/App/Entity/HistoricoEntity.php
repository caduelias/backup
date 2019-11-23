<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

class HistoricoEntity
{
    private $idhistorico;

    private $idcombustivel;

    private $valor;

    private $comparacao;

    private $data;

    /**
     * @return int
     */
    public function getIdHistorico(): int
    {
        return $this->idhistorico;
    }

    /**
     * @var int $idhistorico
     */
    public function setIdHistorico(int $idhistorico): void
    {
        $this->idhistorico = $idhistorico;
    }

    /**
     * @return int
     */
    public function getIdCombustivel(): int
    {
        return $this->idcombustivel;
    }

    /**
     * @var int $idcombustivel
     */
    public function setIdCombustivel(int $idcombustivel): void
    {
        $this->idcombustivel = $idcombustivel;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @var float $valor
     */
    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return float
     */
    public function getComparacao(): float
    {
        return $this->comparacao;
    }

    /**
     * @var float $comparacao
     */
    public function setComparacao(float $comparacao)
    {
        $this->comparacao = $comparacao;
    }

    /**
     * @return DateTime
     */
    public function getData(): DateTime
    {
        return $this->data;
    }

    /**
     * @var DateTime $data
     */
    public function setData(DateTime $data): void
    {
        $this->data = $data;
    }
}