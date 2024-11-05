<?php
include 'db.php';

// Verificar o tipo de inserção (plano ou associado)
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
} else {
    // Se não houver tipo, redireciona para a página inicial
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($tipo == 'plano') {
        // Inserir plano
        $numero = $_POST['numero'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];

        $query = "INSERT INTO PLANO (Numero, Descricao, Valor) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$numero, $descricao, $valor]);

        header("Location: index.php"); // Redireciona de volta para a página principal
        exit();

    } elseif ($tipo == 'associado') {
        // Inserir associado
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $plano = $_POST['plano'];

        $query = "INSERT INTO ASSOCIADO (Nome, Cidade, Plano) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome, $cidade, $plano]);

        header("Location: index.php"); // Redireciona de volta para a página principal
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Novo <?php echo ucfirst($tipo); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Inserir Novo <?php echo ucfirst($tipo); ?></h1>

        <form method="POST">
            <?php if ($tipo == 'plano'): ?>
                <label for="numero">Número do Plano:</label>
                <input type="text" name="numero" id="numero" required>

                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" id="descricao" required>

                <label for="valor">Valor:</label>
                <input type="text" name="valor" id="valor" required>

            <?php elseif ($tipo == 'associado'): ?>
                <label for="nome">Nome do Associado:</label>
                <input type="text" name="nome" id="nome" required>

                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" required>

                <label for="plano">Plano:</label>
                <select name="plano" id="plano" required>
                    <!-- Preencher com os planos existentes -->
                    <?php
                    $planos_query = $pdo->query("SELECT * FROM PLANO");
                    $planos = $planos_query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($planos as $plano):
                    ?>
                        <option value="<?php echo $plano['Numero']; ?>"><?php echo $plano['Descricao']; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <button type="submit">Inserir</button>
        </form>
        <a href="index.php">Voltar para a página principal</a>
    </div>
</body>
</html>
