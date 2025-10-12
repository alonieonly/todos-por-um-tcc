<?php
require_once __DIR__ . '/../config/conex.php';
require_once __DIR__ . '/../service/EventosService.php';

class EventosController {
    private $eventoService;
    
    public function __construct() {
        $database = new Database();
        $pdo = $database->getConnection();
        $this->eventoService = new EventoService($pdo);
    }
    
    public function getEventos() {
        return $this->eventoService->getAllEventosAtivos();
    }
}
?>