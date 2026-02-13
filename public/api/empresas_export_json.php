<?php 
require_once __DIR__.'/../../vendor/autoload.php';
use App\Repos\EmpresaRepo;
use FontLib\Table\Type\head;

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="empresas.json"');
echo json_encode((new EmpresaRepo())->getAll( isset($_GET['search']) ? $_GET['search'] : ''));