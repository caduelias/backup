<?php

declare(strict_types=1);

namespace App\Controller\Get;

use App\Service\HistoricoService;

class GetAllHistoricoController
{
    private $service;

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