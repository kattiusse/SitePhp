<?php
// Iniciando sessão
session_start();


// Verifica de sessão id existe
if (empty($_SESSION['auth']['id'])) {
    // Redireciona para a página de login
    header('Location: ../templates/login.php');
}

$config = [
    'url' => 'http://localhost/adega' 
];