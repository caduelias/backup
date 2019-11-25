<?php

declare(strict_types=1);

namespace App\Controller\Get;
 
use App\Service\HistoricoService;

class GetAllHistoricoController
{
    /**
     * @var HistoricoService
     */
    private $service;

    /**
     * @var $climate
     */
    private $climate;

    public function __construct(
        HistoricoService $service,
        $climate
    )
    {
        $this->service = $service;
        $this->climate = $climate;
    }

    public function __invoke()
    {
        $this->climate->table($this->service->getAll());
    }
}