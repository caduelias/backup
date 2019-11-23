<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HistoricoService;

class Controller
{
    /**
     * @var HistoricoService
     */
    protected $service;

    /**
     * @var $climate
     */
    protected $climate;

    public function __construct(HistoricoService $service, $climate)
    {
        $this->service = $service;
        $this->climate = $climate;
        $this->climate->clear();
    } 
}