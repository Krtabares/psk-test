<?php 
require_once __DIR__.'/../../vendor/autoload.php';
use App\Validators\Empresa ;
use App\Repos\EmpresaRepo;
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if($_SERVER['REQUEST_METHOD'] !== 'PUT' || !$id) exit;

$data = json_decode(file_get_contents('php://input'), true);

if($err = Empresa::validate($data)) {
    http_response_code(400);
    echo json_encode(['errors' => $err]);
    exit;
}

(new EmpresaRepo())->update($id, $data);

echo json_encode(['message' => 'ok']);
 
