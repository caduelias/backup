<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Repository\Database\Mysql;
use App\Repository\HistoricoRepository;
use App\Service\HistoricoService;
use App\Controller\Get\GetAllHistoricoController;
use App\Controller\Get\GetByCombustivelController;
use App\Controller\Post\InsertHistoricoController;

$climate = new League\CLImate\CLImate;

$conn = new Mysql(json_decode(file_get_contents("./config/conn.json")));

$progress = $climate->progress()->total(100);

for ($i = 0; $i <= 100; $i++) {
  $progress->current($i);
  usleep(2000);
}

$repository = new HistoricoRepository($conn);

$controllers = [
    '1'   => GetAllHistoricoController::class,
    '2'   => InsertHistoricoController::class,
    '3'   => GetByCombustivelController::class

];

$service = [
  '1'   => $historicoService = new HistoricoService($repository),
  '2'   => $historicoService = new HistoricoService($repository),
  '3'   => $historicoService = new HistoricoService($repository)

];

while(true){

    $climate->clear();

    $climate->comment('GasBack');

    $padding = $climate->padding(10);

    $padding->label('Visualizar todos os itens')->result('[1]');
    $padding->label('Inserir valor Gasolina/Etanol')->result('[2]');
    $padding->label('Buscar valor Gasolina/Etanol')->result('[3]');

    $input = $climate->input('Selecione opção do menu');
    $input->accept([1,2,3,4,5,6,7,8,9]);

    $nameController = $input->prompt();    

    $controller = new $controllers[$nameController]($service[$nameController], $climate);
    $controller();

    $inputMenu = $climate->input('Pressione <Enter> para retornar menu');
    $inputMenu->prompt();

}
