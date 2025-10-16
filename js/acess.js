// Espera o documento carregar completamente
document.addEventListener('DOMContentLoaded', () => {

    const toggleButton = document.getElementById('btn-acessibilidade');
    const body = document.body;

    // Função para ativar/desativar o modo
    const toggleAcessibilidade = () => {
        // Alterna a classe no corpo do documento
        body.classList.toggle('acessibilidade-ativa');

        // Salva a preferência do usuário no localStorage
        if (body.classList.contains('acessibilidade-ativa')) {
            localStorage.setItem('modoAcessibilidade', 'ativo');
        } else {
            localStorage.removeItem('modoAcessibilidade');
        }
    };

    // Verifica se o modo de acessibilidade já estava ativo em uma visita anterior
    if (localStorage.getItem('modoAcessibilidade') === 'ativo') {
        body.classList.add('acessibilidade-ativa');
    }

    // Adiciona o evento de clique ao botão
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleAcessibilidade);
    }
});