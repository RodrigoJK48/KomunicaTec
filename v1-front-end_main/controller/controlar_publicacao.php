<?php // Arquivo controlador intermediário de recebimento de dados da view e envio de dados à model

require_once '../model/model_publicacao.php'; // Requer arquivo da classe

// Criar objeto da classe "Publicacao"
$publicacao = new Publicacao(); // Criar objeto de classe

// Verifica se há uma solicitação "POST"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["acao"]))
{
    // Verifica diferentes valores de "acao" via solicitação "GET"
    switch ($_REQUEST["acao"])
    {
        case 'publicar':
            /*echo $_POST["titulo"];
            echo '<div style="white-space: pre-line;">'; // "whitespace: pre-line" converte quebras de linha para HTML
            echo $_POST["descricao"];
            echo "</div>";
            echo "<br>" . $_POST["expiracao"] ?? null;
            echo "<br>" . $_POST["categoria"] ?? null;
            echo "<br>" . $_POST["link"] ?? null;*/
            
            // Recebendo dados do formulário
            $publicacao->titulo                       = $_POST["titulo"];
            $publicacao->descricao                    = $_POST["descricao"];
            //$publicacao->data_de_publicacao           = $_POST[""];
            //$publicacao->data_de_ultima_modificacao   = $_POST[""];
            //$publicacao->log_ultima_modificacao       = $_POST[""];
            $publicacao->data_de_expiracao            = $_POST["expiracao"];
            //$publicacao->id_categoria_fk              = $_POST[""];
            //$publicacao->id_cpf_fk                    = $_POST[""];
            $publicacao->publicar();
            echo "ok";
            break;
        
        default:
            echo "Ação não encontrada";
            break;
    }    
    
    // Exibição com formatação HTML (nota: Possui uma quebra de linha acima)
    /*
    <!-- Abaixo, "whitespace: pre-line" converte quebras de linha para HTML -->
    <div style="white-space: pre-line;">
    <?= $_POST["descricao"]; ?>
    </div>
    */
}
?>