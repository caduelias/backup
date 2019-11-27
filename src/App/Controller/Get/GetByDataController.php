<?php

declare(strict_types=1);

namespace App\Controller\Get;

use App\Service\DateHandlerService;
use App\Service\HistoricoService;
use Exception;

class GetByDataController
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
        $dataInicial = "";
        $dataFinal = "";

        $this->climate->green('Digite no Formato: 0000-00-00');
        $dataInicial = $this->climate->input('Data Inicial: ');
        $dataInicial = $dataInicial->prompt();

        $dataFinal = $this->climate->input('Data Final: ');
        $dataFinal = $dataFinal->prompt();

        $validationService = new DateHandlerService();

        if ($validationService->isValidDate($dataInicial) == false) {
            $this->climate->red('Data Inicial informada é inválida!');
        }

        if ($validationService->isValidDate($dataFinal) == false) {
            $this->climate->red('Data Final informada é inválida!');
            exit;
        }

        if ($dataFinal < $dataInicial || $dataInicial === $dataFinal) {
            throw new Exception('Data final não pode ser menor ou igual a data inicial!');
        } 

        try {
            $consultEtanol = $this->service->getByData(1, $dataInicial, $dataFinal);
            $consultGasolina = $this->service->getByData(2, $dataInicial, $dataFinal);
        } catch (Exception $e){
            throw new Exception("Erro ao buscar");
        }

        if(!$consultGasolina || !$consultEtanol) {
            $this->climate->animation('404')->enterFrom('top');
        }
       
        $valorEtanol = floatval($consultEtanol->valor);
        $valorGasolina = floatval($consultGasolina->valor);

        $dataEtanol = $validationService->formatDate($consultEtanol->data);
        $dataGasolina = $validationService->formatDate($consultGasolina->data);

        $result = $this->service->calculateValues($valorEtanol, $valorGasolina);

        if($result){
            if ($result < 0.7) {
                $this->climate->out('Ultimo Valor cadastrado do Etanol entre essas datas foi: '. $valorEtanol . ' em ' . $dataEtanol );
                $this->climate->out('Ultimo Valor cadastrado da Gasolina entre essas datas foi :'. $valorGasolina . ' em ' . $dataGasolina);
                $this->climate->blue('O resultado da comparação entre essas datas é de: ' . $result);
                $this->climate->green('Opção viável era abastecer com Etanol!');
            } else if ($result >= 0.7) {
                $this->climate->out('Ultimo Valor cadastrado do Etanol entre essas datas foi: '. $valorEtanol . ' em ' . $dataEtanol );
                $this->climate->out('Ultimo Valor cadastrado da Gasolina entre essas datas foi: '. $valorGasolina . ' em ' . $dataGasolina);
                $this->climate->blue('O resultado da comparação entre essas datas é de: ' . $result);
                $this->climate->green('Opção viável era abastecer com Gasolina!');
            }
        }

        exit;
        var_dump($consultEtanol, $consultGasolina);
        exit;
        if ($option === 'Etanol'){
            $param = 1;
        } 

        if ($option === 'Gasolina'){
            $param = 2;
        }

        $idCombustivel = $param;

        $consult = $this->service->getAllByCombustivel($idCombustivel);

        if (!$consult) {
            $this->climate->animation('404')->enterFrom('top');
        }
         
        return $this->climate->table($consult);

    }

}