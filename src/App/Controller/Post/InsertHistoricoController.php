<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\Service\HistoricoService;

use App\Entity\HistoricoEntity;

class InsertHistoricoController
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
        $valor = "";

        $options  = [
            '1' =>  'Etanol',
            '2' =>  'Gasolina'
        ];

        $input = $this->climate->radio('Selecione uma opção:', $options);
        $option = $input->prompt();

        $this->climate->bleak();

        $valor = $this->climate->input('Digite um valor:');

        $valor = $valor->prompt();

        if ($option === 'Etanol'){
            $idCombustivel = 1;
        }

        if ($option === 'Gasolina'){
            $idCombustivel = 2;
        }

        $data = date('Y-m-d H:i:s');  

        $historicoEntity = new HistoricoEntity();

        $historicoEntity->setData($data);
        $historicoEntity->setIdCombustivel($idCombustivel);
        $historicoEntity->setValor(floatval($valor));

        return $this->service->insert($historicoEntity);
    }
    
}