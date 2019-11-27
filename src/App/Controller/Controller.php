<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DateHandlerService;
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

    protected $validationData;

    public function __construct(HistoricoService $service, DateHandlerService $validationData, $climate)
    {
        $this->service = $service;
        $this->validationData = $validationData;
        $this->climate = $climate;
        $this->climate->clear();
    } 
}