<?php
// models/Evento.php
class Evento {
    public $id_evento;
    public $titulo;
    public $descricao;
    public $endereco;
    public $cidade;
    public $estado;
    public $cep;
    public $data_evento;
    public $hora_evento;
    public $valor_inscricao;
    public $imagem_url;
    public $id_campanha;
    public $id_administrador;
    public $status;
    public $max_participantes;
    public $participantes_inscritos;
    public $data_criacao;
    public $data_atualizacao;
    
    // Apenas getters/setters se necessário, sem lógica de negócio
    public function getDataFormatada() {
        return date('d/m/Y', strtotime($this->data_evento));
    }
    
    public function getValorFormatado() {
        return 'R$ ' . number_format($this->valor_inscricao, 2, ',', '.');
    }
}
?>