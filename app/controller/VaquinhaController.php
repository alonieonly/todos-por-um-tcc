<?php
require_once __DIR__ . '/../config/conex.php';
require_once __DIR__ . '/../service/VaquinhaService.php';

class VaquinhaController {
    private $vaquinhaService;
    
    public function __construct() {
        $database = new Database();
        $pdo = $database->getConnection();
        $this->vaquinhaService = new VaquinhaService($pdo);
    }
    
    public function getVaquinhas() {
        return $this->vaquinhaService->getAllVaquinhasAtivas();
    }
}
?>