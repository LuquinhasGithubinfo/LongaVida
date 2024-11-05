<?php
include 'db.php'; // Conexão com o banco de dados

// Consulta de Planos
$planos_query = $pdo->query("SELECT * FROM PLANO");
$planos = $planos_query->fetchAll(PDO::FETCH_ASSOC);

// Consulta de Associados
$associados_query = $pdo->query("SELECT * FROM ASSOCIADO");
$associados = $associados_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Planos e Associados</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link para o seu arquivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Gestão de Planos e Associados</h1>

        <!-- Botões para Inserir, Alterar -->
        <div class="action-buttons">
            <a href="inserir.php?tipo=plano"><button class="action-btn">Inserir Novo Plano</button></a>
            <a href="inserir.php?tipo=associado"><button class="action-btn">Inserir Novo Associado</button></a>
            <a href="alterar.php"><button class="action-btn">Alterar</button></a>
        </div>

        <h2>Planos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Plano</th>
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
                    <td>R$ <?php echo number_format($plano['Valor'], 2, ',', '.'); ?></td>
                    <td>
                        <!-- Botões de Ação -->
                        <form action="alterar.php" method="get" style="display:inline;">
                            <input type="hidden" name="tipo" value="plano">
                            <input type="hidden" name="id" value="<?php echo $plano['id_plano']; ?>"> <!-- Alterado para 'id_plano' -->
                            <button type="submit" class="action-btn">Alterar</button>
                        </form>
                        <form action="excluir.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                            <input type="hidden" name="tipo" value="plano">
                            <input type="hidden" name="id" value="<?php echo $plano['id_plano']; ?>"> <!-- Alterado para 'id_plano' -->
                            <button type="submit" class="action-btn">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Associados</h2>
        <table class="table">
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
                        <!-- Botões de Ação -->
                        <form action="alterar.php" method="get" style="display:inline;">
                            <input type="hidden" name="tipo" value="associado">
                            <input type="hidden" name="id" value="<?php echo $associado['id_associado']; ?>"> <!-- Alterado para 'id_associado' -->
                            <button type="submit" class="action-btn">Alterar</button>
                        </form>
                        <form action="excluir.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                            <input type="hidden" name="tipo" value="associado">
                            <input type="hidden" name="id" value="<?php echo $associado['id_associado']; ?>"> <!-- Alterado para 'id_associado' -->
                            <button type="submit" class="action-btn">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
