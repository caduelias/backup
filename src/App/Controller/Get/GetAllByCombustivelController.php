<?php

declare(strict_types=1);

namespace App\Controller\Get;

use App\Service\HistoricoService;

class GetAllByCombustivelController
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
        $input = "";

        $options  = [
            '1' =>  'Etanol',
            '2' =>  'Gasolina'
        ];

        $input = $this->climate->radio('Buscar Histórico: ', $options);
        $option = $input->prompt();

        if ($option === 'Etanol'){
            $param = 1;
        } 

        if ($option === 'Gasolina'){
            $param = 2;
        }

        $idCombustivel = $param;

        $consult = $this->service->getAllByCombustivel($idCombustivel);

        if (!$consult) {
            $this->climate->animation('hello')->enterFrom('top');
        }
         
        return $this->climate->table($consult);

    }

}