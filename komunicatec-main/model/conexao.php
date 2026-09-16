<?php // Arquivo de conexão com o banco de dados

if (!class_exists("Conexao")) // Verifica se a conexão já foi realizada
{
    class Conexao
    {
        function Conectar()
        {
            try // Executa o bloco até encontrar um erro
            {
                // "caminho", "usuario", "senha"
                // Fatec: host=localhost:3307 senha="alunos"
                $servidor = "localhost";
                $usuario  = "root";
                $senha    = "";
                $banco    = "komunicatec";

                $conexao = new PDO
                (
                    "mysql:host=$servidor;dbname=$banco",
                    "$usuario",
                    "$senha"
                );
                
                return $conexao;
            }
            catch(PDOException $erro) // Caso encontre um erro, armazena a mensagem em 'erro'
            {
                die("Erro na conexão: " . $erro->getMessage()); // Exibe mensagem do erro e encerra script
            }
        }
    }
}
// Execução da conexão (Ctrl + C)
/*
include_once __DIR__ . '/conexao.php'; // "__DIR__" permite referenciar pelo diretório que o arquivo foi chamado
$classe_con = new Conexao(); // Cria novo objeto de conexão
$con = $classe_con->Conectar(); // Executa método para conectar banco de dados
*/
?>