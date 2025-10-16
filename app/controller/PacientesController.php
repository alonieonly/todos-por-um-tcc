<?php
require_once __DIR__ . '/../config/conex.php';
require_once __DIR__ . '/../service/PacientesService.php';

class PacientesController {
    private $pacientesService;
    
    public function __construct() {
        $database = new Database();
        $pdo = $database->getConnection();
        $this->pacientesService = new PacientesService($pdo);
    }
    
    public function getPacientes() {
        return $this->pacientesService->getAllPacientes();
    }
}
?>