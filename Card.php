<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("util/Conexao.php");
require_once("modelo/Bebida.php");
require_once("DAO/bebidasDAO.php");

$conexao = Conexao::getConexao();
$bebidaDAO = new BebidasDAO($conexao);
$bebidas = $bebidaDAO->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Bebidas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar">

        <span class="navbar-brand">
             Bebidas pelo Mundo
        </span>

        <div class="nav-dropdown">

            <button class="nav-dropdown-toggle">
                ☰ Menu
            </button>

            <div class="nav-dropdown-menu">

                <a class="nav-dropdown-item" href="Bebidas.php">
                    Cadastro
                </a>

                <a class="nav-dropdown-item" href="Bebidas.php?ver=tabela">
                    Tabela
                </a>

                <a class="nav-dropdown-item" href="Card.php">
                    Catálogo
                </a>

            </div>

        </div>

    </nav>

    <div class="cards-wrapper">

        <h2>Catálogo de Bebidas</h2>
<!--verifica se está vazio -->
        <?php if (empty($bebidas)): ?>

            <p class="cards-empty">
                Nenhuma bebida cadastrada ainda.
            </p>

        <?php else: ?>

            <div class="cards-grid">
<!--gera um card para cada bebida presente no array bebidas-->
                <?php foreach ($bebidas as $b): ?>

                    <div class="card-flip">

                        <div class="card-inner">

                            <!-- Frente -->
                            <div class="card-front">

                                <?php if ($b->getImagem()): ?>
                                    <img
                                        class="card-img"
                                        src="<?= htmlspecialchars($b->getImagem()) ?>"
                                        alt="<?= htmlspecialchars($b->getTipoDescricao()) ?>">
                                <?php endif; ?>

                                <div class="card-info">

                                    <div class="card-tipo">
                                        <?= $b->getTipoDescricao() ?>
                                    </div>

                                    <div class="card-origem">
                                        <?= htmlspecialchars($b->getOrigem()) ?>
                                    </div>

                                </div>

                            </div>

                            <!-- Verso -->
                            <div class="card-back">

                                <div class="back-title">
                                    <?= $b->getTipoDescricao() ?>
                                </div>
                                 <!-- controla as informaçoes que aparecem no verso -->
                                <?php if ($b->getTipo() != 'A'): ?>
                                    <div class="back-row">
                                        <span class="back-label">Origem</span>
                                        <span class="back-value">
                                            <?= htmlspecialchars($b->getOrigem()) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($b->getTipo() != 'A' && $b->getTipo() != 'R'): ?>
                                    <div class="back-row">
                                        <span class="back-label">Sabor</span>
                                        <span class="back-value">
                                            <?= htmlspecialchars($b->getSabor()) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="back-row">
                                    <span class="back-label">Características</span>
                                    <span class="back-value">
                                        <?= htmlspecialchars($b->getOpcoesDescricao()) ?>
                                    </span>
                                </div>

                                <div class="back-desc">
                                    <?= htmlspecialchars($b->getDescricao()) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>
 <!--controla o abri e fechar do menu-->
    <script>
        const toggle = document.querySelector('.nav-dropdown-toggle');
        const dropdown = document.querySelector('.nav-dropdown');

        if (toggle && dropdown) {

            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            });

            document.addEventListener('click', function() {
                dropdown.classList.remove('open');
            });
        }
    </script>

</body>

</html>