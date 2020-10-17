<?php
// Dados de de acesso ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adega";

// Cria conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
// Erro na conexão
if ($conn->connect_error) {
  die("Falha ao realizar a conexão com o banco de dados: " . $conn->connect_error);
}