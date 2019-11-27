<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HistoricoService;

class OperacaoController
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
        $valorEta = $this->service->getByCombustivel(1);

        if (!$valorEta) {
            $this->climate->animation('404')->enterFrom('top');
        }
     
        $valorGas = $this->service->getByCombustivel(2);

        if (!$valorGas) {
            $this->climate->animation('hello')->enterFrom('top');
        }

        $valorEta = floatval($valorEta->valor);
        $valorGas = floatval($valorGas->valor);
     
        $comparacao = $this->service->calculateValues($valorEta, $valorGas);

        if($comparacao){
            if ($comparacao < 0.7) {
                $this->climate->backgroundLightGreen()->out('Abasteça com Etanol!');
                $this->climate->blue('Comparação:' . $comparacao);
            } 
            
            if ($comparacao >= 0.7) {
                $this->climate->backgroundLightBlue()->out('Abasteça com Gasolina!');
                $this->climate->green('Comparação:' . $comparacao);
            }
        }
      
        return;

    }
}