<?php

declare(strict_types=1);

namespace App\Controller\Post;

use App\Service\HistoricoService;
use Respect\Validation\Validator as validation;
use App\Entity\HistoricoEntity;
use Exception;

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

        $valor->accept(function($response) {
            
            $validate = validation::numeric()
                            ->positive()    
                            ->validate($response);
            if (!$validate) {
                $this->climate->red('Valor digitado é inválido');
            }
            return $validate;
         
        });

        $response = $valor->prompt();

        if ($option === 'Etanol') {
            $idCombustivel = 1;
        } else if ($option === 'Gasolina') {
            $idCombustivel = 2;
        }

        $data = date('Y-m-d H:i:s');  

        $historicoEntity = new HistoricoEntity();

        $historicoEntity->setData($data);
        $historicoEntity->setIdCombustivel($idCombustivel);
        $historicoEntity->setValor(floatval($response));

        try {
            $this->service->insert($historicoEntity);
        } catch(Exception $e){
            throw new Exception("Erro ao inserir!");
        }
        
        return  $this->climate->green('Valor registrado!');
    }
}