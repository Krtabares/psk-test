<?php 
require_once __DIR__.'/../../vendor/autoload.php';
use App\Validators\Empresa ;
use App\Repos\EmpresaRepo;
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

$data = json_decode(file_get_contents('php://input'), true);

if($err = Empresa::validate($data)) {
    http_response_code(400);
    echo json_encode(['errors' => $err]);
    exit;
}
(new EmpresaRepo())->create($data);

echo json_encode(['message' => 'ok']);
 
