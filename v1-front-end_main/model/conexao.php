<?php
if (!class_exists("Conexao")) // Verifica se a conexão já foi realizada
{
    class Conexao
    {
        function Conectar()
        {
            try // Executa o bloco até encontrar um erro
            {
                // model/conexao.php
                // "caminho", "usuario", "senha"
                // Fatec: host=localhost:3307 senha="alunos"
                $servidor = "localhost";
                $usuario  = "root";
                $senha    = "";
                $banco    = "jooj";

                $conexao = new PDO("mysql:host=$servidor;dbname=$banco", "$usuario", "$senha");
                return $conexao;
            }
            catch(PDOException $erro) // Caso encontre um erro, armazena a mensagem em 'erro'
            {
                die("Erro na conexão: " . $erro->getMessage()); // Exibe mensagem do erro e encerra script
            }
        }
    }
}
// Execução da conexão (testes)
/*
$classe_con = new Conexao();
$con = $classe_con->Conectar();
*/
?>