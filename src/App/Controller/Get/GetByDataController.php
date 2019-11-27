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

        $this->climate->bleak();

        $dataFinal = $this->climate->input('Data Final: ');
        $dataFinal = $dataFinal->prompt();

        $validationService = new DateHandlerService();

        if ($validationService->isValidDate($dataInicial) == false) {
            $this->climate->red('Data Inicial informada é inválida!');
        }

        if ($validationService->isValidDate($dataFinal) == false) {
            $this->climate->red('Data Final informada é inválida!');
        }

        if ($dataFinal < $dataInicial || $dataInicial == $dataFinal) {
            throw new Exception('Data final não pode ser menor ou igual a data inicial!');
        } 

        $consultEtanol = $this->service->getByData(1, $dataInicial, $dataFinal);
        $consultGasolina = $this->service->getByData(2, $dataInicial, $dataFinal);

        if (!$consultEtanol || !$consultGasolina) {
            throw new Exception("Nenhum registro encontrado!");
        }

        $valorEtanol = floatval(array_column($consultEtanol, 'valor')[0]);
        $valorGasolina = floatval(array_column($consultGasolina, 'valor')[0]);

        $dataEtanol = $validationService->formatDate(array_column($consultEtanol, 'data')[0]);
        $dataGasolina = $validationService->formatDate(array_column($consultGasolina, 'data')[0]);
 
        $result = $this->service->calculateValues($valorEtanol, $valorGasolina);

        if($result){
            if ($result < 0.7) {
                $this->climate->out('Ultimo Valor cadastrado do Etanol entre essas datas foi: '. $valorEtanol . ' em ' . $dataEtanol );
                $this->climate->out('Ultimo Valor cadastrado da Gasolina entre essas datas foi: '. $valorGasolina . ' em ' . $dataGasolina);
                $this->climate->blue('O resultado da comparação entre essas datas é de: ' . $result);
                $this->climate->green('Opção viável era abastecer com Etanol!');
            } else if ($result >= 0.7) {
                $this->climate->out('Ultimo Valor cadastrado do Etanol entre essas datas foi: '. $valorEtanol . ' em ' . $dataEtanol );
                $this->climate->out('Ultimo Valor cadastrado da Gasolina entre essas datas foi: '. $valorGasolina . ' em ' . $dataGasolina);
                $this->climate->blue('O resultado da comparação entre essas datas é de: ' . $result);
                $this->climate->green('Opção viável era abastecer com Gasolina!');
            }
        }
    }
}