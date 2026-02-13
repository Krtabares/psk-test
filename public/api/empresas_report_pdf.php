<?php
require_once __DIR__.'/../../vendor/autoload.php';
use App\Repos\EmpresaRepo;
use App\pdf\EmpresaReport;
$empresas = (new EmpresaRepo())->getAll($_GET['search'] ?? '');
EmpresaReport::generate($empresas);