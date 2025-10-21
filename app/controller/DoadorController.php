<?php
require_once __DIR__ . '/../config/conex.php';
require_once __DIR__ . '/../service/DoadorService.php';

class DoadorController {
    private $doadorService;
    
    public function __construct() {
        $database = new Database();
        $pdo = $database->getConnection();
        $this->doadorService = new DoadorService($pdo);
    }
    
    public function addDoador($dados) {
        return $this->doadorService->cadastrarDoador($dados);
    }
    
    public function canLogin($dados) {
        return $this->doadorService->cadastrarDoador();
    }
}
?>