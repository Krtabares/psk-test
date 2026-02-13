<?php
require_once __DIR__.'/../../vendor/autoload.php';
use App\Repos\EmpresaRepo;
header('Content-Type: application/json');
$empresaRepo = new EmpresaRepo();
$empresas = $empresaRepo->getAll( isset($_GET['search']) ? $_GET['search'] : '');
echo json_encode($empresas);