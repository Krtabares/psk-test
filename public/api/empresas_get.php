<?php
require_once __DIR__.'/../../vendor/autoload.php';
use App\Repos\EmpresaRepo;
header('Content-Type: application/json');
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if($_SERVER['REQUEST_METHOD'] !== 'GET' || !$id) exit;
echo json_encode((new EmpresaRepo())->getById($id));