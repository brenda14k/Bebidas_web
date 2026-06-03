<?php
require_once("modelo/Bebida.php");

class BebidasDAO
{

    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }
//Inseri no bd 
    public function inserir(Bebida $bebida)
    {

        $sql = "INSERT INTO Bebidas
            (tipo, origem, sabor, imagem, descricao, opcoes)
            VALUES (?, ?, ?, ?, ?, ?)";

        $stm = $this->conexao->prepare($sql);

        return $stm->execute([
            $bebida->getTipo(),
            $bebida->getOrigem(),
            $bebida->getSabor(),
            $bebida->getImagem(),
            $bebida->getDescricao(),
            $bebida->getOpcoes()
        ]);
    }
 //lista todas as bebidas
   
    public function listar()
    {
        $sql = "SELECT * FROM Bebidas";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $dados = $stm->fetchAll(PDO::FETCH_ASSOC);

        $bebidas = [];
        foreach ($dados as $d) {
            $bebidas[] = new Bebida(
                $d['id'],
                $d['tipo'],

                $d['origem'],
                $d['sabor'],

                $d['descricao'],
                $d['imagem'],
                $d['opcoes']
            );
        }
        return $bebidas;
    }
//procura o tipo da bebida
  
    public function procurarPorTipo($tipo)
    {
        $sql = "SELECT * FROM Bebidas WHERE tipo = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$tipo]);
        return count($stm->fetchAll());
    }

    //verifica se é duplicado
   
    public function verificarDuplicata($tipo, $origem, $sabor)
    {
        $sql = "SELECT COUNT(*) as total FROM Bebidas
                WHERE tipo = ?  AND origem = ? AND sabor = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$tipo, $origem, $sabor]);
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return (int) $linha['total'];
    }
 //deleta 
   
    public function excluirPorId($id)
    {
        $sql = "DELETE FROM Bebidas WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        return $stm->execute([$id]);
    }
}
