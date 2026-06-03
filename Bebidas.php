<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("util/Conexao.php");
require_once("modelo/Bebida.php");
require_once("DAO/bebidasDAO.php");

$conexao   = Conexao::getConexao();
$bebidaDAO = new BebidasDAO($conexao);

/* ── PROCESSAR ENVIO DO FORMULÁRIO (POST) ─────────── */
if (isset($_POST['tipo'])) {

    $tipo      = trim($_POST['tipo'])      ?: '';
    $origem    = trim($_POST['origem'])    ?: '';
    $sabor     = trim($_POST['sabor'])     ?: '';
    $opcoes    = trim($_POST['opcoes'])    ?: '';
    $descricao = trim($_POST['descricao']) ?: '';
    $imagem    = trim($_POST['imagem'])    ?: '';

    $erros = ['tipo' => '', 'origem' => '', 'sabor' => '',
              'descricao' => '', 'imagem' => '', 'opcoes' => ''];
    $temErro = false;

    if ($tipo === '') {
        $erros['tipo'] = 'Selecione o tipo da bebida.';
        $temErro = true;
    }
    if ($tipo != 'A' && $origem === '') {
        $erros['origem'] = 'Informe a origem.';
        $temErro = true;
    }

      $apenasLetras = '/^[a-zA-ZÀ-ÿ\s]+$/u';// adicionado
    if ($origem !== '' && !preg_match($apenasLetras, $origem)) {
        $erros['origem'] = 'Este campo aceita apenas letras (sem números ou caracteres especiais).';
        $temErro = true;
    }

    if ($tipo != 'A' && $tipo != 'R' && $sabor === '') {
        $erros['sabor'] = 'Informe o sabor.';
        $temErro = true;
    }
    if ($opcoes === '') {
        $erros['opcoes'] = 'Selecione uma opção.';
        $temErro = true;
    }
    if ($imagem === '') {
        $erros['imagem'] = 'Informe a URL da imagem.';
        $temErro = true;
    }
    if ($descricao === '') {
        $erros['descricao'] = 'Informe a descrição.';
        $temErro = true;
    } elseif (strlen($descricao) > 360) {//adicionado
        $erros['descricao'] = 'A descrição deve ter no máximo 360 caracteres.';
        $temErro = true;
    }

    if (!$temErro) {
        $duplicata = $bebidaDAO->verificarDuplicata($tipo, $origem, $sabor);
        if ($duplicata > 0) {
            $erros['tipo'] = 'Já existe uma bebida com esse Tipo, Origem e Sabor.';
            $temErro = true;
        }
    }

    if (!$temErro) {
        // Sucesso: salva e redireciona limpo
        $bebidaDAO->inserir(new Bebida(0, $tipo, $origem, $sabor, $descricao, $imagem, $opcoes));
        header('Location: Bebidas.php');
        exit;
    } else {

        $_SESSION['form_erros']  = $erros;
        $_SESSION['form_dados']  = compact('tipo', 'origem', 'sabor', 'opcoes', 'descricao', 'imagem');
        header('Location: Bebidas.php');
        exit;
    }
}

/* ── RECUPERAR o conteudo mesmo que algumas info estejão incorretas  ─────────── */
$errosCampo = $_SESSION['form_erros'] ?? ['tipo'=>'','origem'=>'','sabor'=>'','descricao'=>'','imagem'=>'','opcoes'=>''];
$dadosForm  = $_SESSION['form_dados'] ?? ['tipo'=>'','origem'=>'','sabor'=>'','opcoes'=>'','descricao'=>'','imagem'=>''];
unset($_SESSION['form_erros'], $_SESSION['form_dados']);// limpa a pagina
// cria  o obj que o usuario ja tinha cadastrado antes 
$bebida = new Bebida(0,
    $dadosForm['tipo'],
    $dadosForm['origem'],
    $dadosForm['sabor'],
    $dadosForm['descricao'],
    $dadosForm['imagem'],
    $dadosForm['opcoes']
);

$temErroSessao = array_filter($errosCampo, fn($v) => $v !== '');// mantem só os campos que não estão vazios, util para saber se há algum erro para mostrar na tela.
// se tiver secaoAtiva mostra a tabela se não o mostra  formulario 
$secaoAtiva    = isset($_GET['ver']) && $_GET['ver'] === 'tabela' ? 'tabela' : 'form';
$mostrarTabela = isset($_GET['ver']) && $_GET['ver'] === 'tabela';

$bebidas = $bebidaDAO->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebidas pelo Mundo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body data-secao-ativa="<?= $secaoAtiva ?>">

    <nav class="navbar">
        <span class="navbar-brand"> Bebidas pelo Mundo</span>
        <div class="nav-dropdown">
            <button class="nav-dropdown-toggle">☰ Menu</button>
            <div class="nav-dropdown-menu">
                <a class="nav-dropdown-item" href="Bebidas.php">Cadastro</a>
                <a class="nav-dropdown-item" href="Bebidas.php?ver=tabela">Tabela</a>
                <a class="nav-dropdown-item" href="Card.php">Catálogo</a>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">

        <div id="secao-form" class="secao">

            <h2>Cadastrar Bebida</h2>

            <form action="" method="POST">

                <!-- TIPO -->
                <div class="campo-wrapper">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo">
                        <option value="">--- Selecione o tipo ---</option>
                        <option value="A"  <?= $bebida->getTipo() == 'A'  ? 'selected' : '' ?>>Água</option>
                        <option value="C"  <?= $bebida->getTipo() == 'C'  ? 'selected' : '' ?>>Café</option>
                        <option value="CH" <?= $bebida->getTipo() == 'CH' ? 'selected' : '' ?>>Chá</option>
                        <option value="BT" <?= $bebida->getTipo() == 'BT' ? 'selected' : '' ?>>Bubble Tea</option>
                        <option value="S"  <?= $bebida->getTipo() == 'S'  ? 'selected' : '' ?>>Suco</option>
                        <option value="V"  <?= $bebida->getTipo() == 'V'  ? 'selected' : '' ?>>Vinho</option>
                        <option value="R"  <?= $bebida->getTipo() == 'R'  ? 'selected' : '' ?>>Refrigerante</option>
                    </select>
                    <span class="msg-campo" data-campo="tipo"><?= $errosCampo['tipo'] ?></span>
                </div>

                <!-- ORIGEM -->
                <div class="campo-wrapper" id="campo-origem">
                    <label for="origem">Origem</label>
                    <input type="text" name="origem" id="origem"
                        placeholder="Ex: Brasil, Etiópia, Japão"
                        value="<?= htmlspecialchars($bebida->getOrigem()) ?>"> <!-- O htmlspecialchars()
Converte caracteres especiais em código seguro para HTML.-->
                    <span class="msg-campo" data-campo="origem"><?= $errosCampo['origem'] ?></span>
                </div>

                <!-- OPÇÕES -->
                <div class="campo-wrapper">
                    <label for="opcoes">Opções</label>
                    <select name="opcoes" id="opcoes" data-selected="<?= htmlspecialchars($bebida->getOpcoes()) ?>">
                        <option value="">Selecione</option>
                    </select>
                    <span class="msg-campo" data-campo="opcoes"><?= $errosCampo['opcoes'] ?></span>
                </div>

                <!-- SABOR -->
                <div class="campo-wrapper" id="campo-sabor">
                    <label for="sabor">Sabor</label>
                    <input type="text" name="sabor" id="sabor"
                        placeholder="Ex: Frutado, Amadeirado, Floral"
                        value="<?= htmlspecialchars($bebida->getSabor()) ?>">
                    <span class="msg-campo" data-campo="sabor"><?= $errosCampo['sabor'] ?></span>
                </div>

                <!-- IMAGEM -->
                <div class="campo-wrapper">
                    <label for="imagem">Imagem (URL — opcional)</label>
                    <input type="url" name="imagem" id="imagem"
                        value="<?= htmlspecialchars($bebida->getImagem()) ?>">
                    <span class="msg-campo" data-campo="imagem"><?= $errosCampo['imagem'] ?></span>
                </div>

                <!-- DESCRIÇÃO -->
                <div class="campo-wrapper">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao"><?= htmlspecialchars($bebida->getDescricao()) ?></textarea>
                    <span class="msg-campo" data-campo="descricao"><?= $errosCampo['descricao'] ?></span>
                </div>

                <button type="submit">Cadastrar</button>

            </form>

        </div><!-- /#secao-form -->

        <?php if ($mostrarTabela): ?>
            <div id="secao-tabela" class="secao">
                <h2>Bebidas Cadastradas</h2>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Origem</th>
                                <th>Sabor</th>
                                <th>Características</th>
                                <th>Descrição</th>
                                <th>Imagem</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bebidas as $b): ?>
                                <tr>
                                    <td class="col-id"><?= $b->getId() ?></td>
                                    <td><?= $b->getTipoDescricao() ?></td>
                                    <td><?= htmlspecialchars($b->getOrigem()) ?></td>
                                    <td><?= htmlspecialchars($b->getSabor()) ?></td>
                                    <td><?= $b->getOpcoesDescricao() ?></td>
                                    <td class="col-desc"><?= htmlspecialchars($b->getDescricao()) ?></td>
                                    <td class="col-img">
                                        <?= $b->getImagem()
                                            ? '<a href="' . htmlspecialchars($b->getImagem()) . '" target="_blank">Ver</a>'
                                            : '–' ?>
                                    </td>
                                    <td class="col-acao">
                                        <a class="btn-excluir"
                                            href="bebidaExcluir.php?id=<?= $b->getId() ?>"
                                            onclick="return confirm('Confirmar exclusão?')"
                                            title="Excluir">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /#secao-tabela -->
        <?php endif; ?>

    </div><!-- /.page-wrapper -->

    <script src="validacao.js"></script>
</body>

</html>