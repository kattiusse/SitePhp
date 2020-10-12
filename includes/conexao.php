<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adega";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Falha ao realizar a conexão com o banco de dados: " . $conn->connect_error);
}