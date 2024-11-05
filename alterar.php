<?php
include 'db.php'; 

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : ''; 

$query_planos = "SELECT * FROM PLANO";
$planos = $pdo->query($query_planos)->fetchAll(PDO::FETCH_ASSOC);

$query_associados = "SELECT * FROM ASSOCIADO";
$associados = $pdo->query($query_associados)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($tipo == 'plano') {
        $id = $_POST['id'];
        $numero = $_POST['numero'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];

        $query = "UPDATE PLANO SET Numero = ?, Descricao = ?, Valor = ? WHERE Numero = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$numero, $descricao, $valor, $id]);

        header("Location: index.php");
        exit();
    }

    if ($tipo == 'associado') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $plano = $_POST['plano'];

        $query = "UPDATE ASSOCIADO SET Nome = ?, Cidade = ?, Plano = ? WHERE Nome = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome, $cidade, $plano, $id]);

        header("Location: index.php");
        exit();
    }
}

if (isset($_GET['excluir']) && isset($_GET['idExcluir'])) {
    $tipoExcluir = $_GET['tipoExcluir'];
    $idExcluir = $_GET['idExcluir'];

    if ($tipoExcluir == 'plano') {
        $query = "DELETE FROM PLANO WHERE Numero = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idExcluir]);
    } elseif ($tipoExcluir == 'associado') {
        // Excluindo o associado com base no campo 'Nome'
        $query = "DELETE FROM ASSOCIADO WHERE Nome = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idExcluir]);
    }

    header("Location: index.php");
    exit();
}

$registro = null;
if ($tipo == 'plano' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM PLANO WHERE Numero = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($tipo == 'associado' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM ASSOCIADO WHERE Nome = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Alterar Dados</h1>

        <a href="index.php"><button>Voltar para a Página Inicial</button></a>

        <br><br>

        <h2>Escolha o tipo de registro para alterar:</h2>
        <a href="alterar.php?tipo=plano"><button>Alterar Planos</button></a>
        <a href="alterar.php?tipo=associado"><button>Alterar Associados</button></a>

        <br><br>

        <?php if ($tipo == 'plano'): ?>
            <h2>Alterar Plano</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($planos as $plano): ?>
                        <tr>
                            <td><?php echo $plano['Numero']; ?></td>
                            <td><?php echo $plano['Descricao']; ?></td>
                            <td><?php echo $plano['Valor']; ?></td>
                            <td>
                                <!-- Botões de Ação (Alterar e Excluir) -->
                                <form action="alterar.php" method="get" style="display:inline;">
                                    <input type="hidden" name="tipo" value="plano">
                                    <input type="hidden" name="id" value="<?php echo $plano['Numero']; ?>">
                                    <button type="submit">Alterar</button>
                                </form>
                                <form action="alterar.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esse plano?');">
                                    <input type="hidden" name="excluir" value="true">
                                    <input type="hidden" name="tipoExcluir" value="plano">
                                    <input type="hidden" name="idExcluir" value="<?php echo $plano['Numero']; ?>">
                                    <button type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (isset($registro)): ?>
                <h3>Alterar Plano</h3>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $registro['Numero']; ?>">
                    <label for="numero">Número do Plano:</label>
                    <input type="text" name="numero" id="numero" value="<?php echo $registro['Numero']; ?>" required>

                    <label for="descricao">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" value="<?php echo $registro['Descricao']; ?>" required>

                    <label for="valor">Valor:</label>
                    <input type="text" name="valor" id="valor" value="<?php echo $registro['Valor']; ?>" required>

                    <button type="submit">Alterar</button>
                </form>
            <?php endif; ?>

        <?php elseif ($tipo == 'associado'): ?>
            <h2>Alterar Associado</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>Plano</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($associados as $associado): ?>
                        <tr>
                            <td><?php echo $associado['Nome']; ?></td>
                            <td><?php echo $associado['Cidade']; ?></td>
                            <td><?php echo $associado['Plano']; ?></td>
                            <td>
                                <!-- Botões de Ação (Alterar e Excluir) -->
                                <form action="alterar.php" method="get" style="display:inline;">
                                    <input type="hidden" name="tipo" value="associado">
                                    <input type="hidden" name="id" value="<?php echo $associado['Nome']; ?>">
                                    <button type="submit">Alterar</button>
                                </form>
                                <form action="alterar.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esse associado?');">
                                    <input type="hidden" name="excluir" value="true">
                                    <input type="hidden" name="tipoExcluir" value="associado">
                                    <input type="hidden" name="idExcluir" value="<?php echo $associado['Nome']; ?>">
                                    <button type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (isset($registro)): ?>
                <h3>Alterar Associado</h3>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $registro['Nome']; ?>">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $registro['Nome']; ?>" required>

                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" value="<?php echo $registro['Cidade']; ?>" required>

                    <label for="plano">Plano:</label>
                    <select name="plano" id="plano" required>
                        <?php foreach ($planos as $plano): ?>
                            <option value="<?php echo $plano['Numero']; ?>" <?php echo ($plano['Numero'] == $registro['Plano']) ? 'selected' : ''; ?>>
                                <?php echo $plano['Numero'] . ' - ' . $plano['Descricao']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit">Alterar</button>
                </form>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</body>
</html>
