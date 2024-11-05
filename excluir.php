<?php
include 'db.php'; // Conexão com o banco de dados

// Verificar se o tipo e o id foram passados na URL
if (isset($_GET['tipo']) && isset($_GET['id'])) {
    $tipo = $_GET['tipo']; // Tipo de dado (plano ou associado)
    $id = $_GET['id']; // ID do item a ser excluído

    if ($tipo == 'plano') {
        // Excluir plano: Verifique o nome correto da coluna no banco de dados
        $query = "DELETE FROM PLANO WHERE id = ?";  // Alterado para 'id' ou o nome correto da coluna
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
    } elseif ($tipo == 'associado') {
        // Excluir associado: Verifique o nome correto da coluna no banco de dados
        $query = "DELETE FROM ASSOCIADO WHERE id_associado = ?"; // Alterado para 'id_associado' (verifique também)
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
    }

    // Após excluir, redireciona para a página principal (index.php)
    header("Location: index.php");
    exit();  // Garante que o código após o redirecionamento não será executado
} else {
    // Se não houver 'tipo' ou 'id', redireciona para a página inicial
    header("Location: index.php");
    exit();  // Garante que o código após o redirecionamento não será executado
}
?>
