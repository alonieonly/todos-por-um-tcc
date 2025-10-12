<?php
// app/controller/EventosController.php
require_once __DIR__ . '/../config/conex.php';
require_once __DIR__ . '/../service/EventosService.php';
require_once __DIR__ . '/../service/VaquinhaService.php';

class HomeController {
    private $eventoService;
    private $vaquinhaService;

    public function __construct() {
        $database = new Database();
        $pdo = $database->getConnection();
        $this->eventoService = new EventoService($pdo);
        $this->vaquinhaService = new VaquinhaService($pdo);
    }

    public function index() {
        return [
            'eventos' => $this->eventoService->getAllEventosAtivos(),
            'vaquinhas' => $this->vaquinhaService->getAllVaquinhasAtivas()
        ];
    }
    
}
?>