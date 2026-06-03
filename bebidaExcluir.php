<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("util/Conexao.php");
require_once("DAO/bebidasDAO.php");

$conn = Conexao::getConexao();
$bebidaDAO = new bebidasDAO($conn);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    if ($bebidaDAO->excluirPorId($id)) {

        header("Location: Bebidas.php?ver=tabela");
        exit;
    } else {

        echo "Erro ao excluir!";
    }
} else {

    echo "ID inválido!";
}
