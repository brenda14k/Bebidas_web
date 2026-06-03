<?php
class Bebida
{
    private int $id;
    private string $tipo;
    private string $origem;
    private string $sabor;


    private string $descricao;
    private string $imagem;
    private string $opcoes;
// salva o valor recebido no atributo do objeto
    public function __construct($id, $tipo, $origem, $sabor, $descricao, $imagem, $opcoes)
    {
        $this->id = $id;
        $this->tipo = $tipo;

        $this->origem = $origem;
        $this->sabor = $sabor;

        $this->descricao = $descricao;
        $this->imagem = $imagem;
        $this->opcoes = $opcoes ?? '';
    }

    public function getTipoDescricao()
    {

        if ($this->tipo == "C")
            return "Café";
        else if ($this->tipo == "CH")
            return "Chá";
        else if ($this->tipo == "BT")
            return "Bubble Tea";
        else if ($this->tipo == "S")
            return "Suco";
        else if ($this->tipo == "V")
            return "Vinho";
        else if ($this->tipo == "R")
            return "Refrigerante";
        else if ($this->tipo == "A")
            return "Agua";
    }



    public function getOpcoesDescricao()
    {
        if ($this->opcoes == 'CA')
            return 'Com Açúcar';

        else if ($this->opcoes == 'SA')
            return 'Sem Açúcar';

        else if ($this->opcoes == 'AD')
            return 'Com Adoçante';

        else if ($this->opcoes == 'AM')
            return 'Água Mineral';

        else if ($this->opcoes == 'AG')
            return 'Água com Gás';

        else if ($this->opcoes == 'AL')
            return 'Água Saborizada Limão';

        else if ($this->opcoes == 'AR')
            return 'Água Saborizada Laranja';

        else if ($this->opcoes == 'CC')
            return 'Coca-Cola';

        else if ($this->opcoes == 'CZ')
            return 'Coca-Cola Zero';

        else if ($this->opcoes == 'PP')
            return 'Pepsi';

        else if ($this->opcoes == 'PB')
            return 'Pepsi Black';

        else if ($this->opcoes == 'GU')
            return 'Guaraná';

        else if ($this->opcoes == 'GZ')
            return 'Guaraná Zero';

        else if ($this->opcoes == 'FL')
            return 'Fanta Laranja';

        else if ($this->opcoes == 'FU')
            return 'Fanta Uva';

        else if ($this->opcoes == 'BPB')
            return 'Popping Boba';

        else if ($this->opcoes == 'BPT')
            return 'Pérolas de Tapioca';

        else if ($this->opcoes == 'BG')
            return 'Gelatina';

        else if ($this->opcoes == 'VS')
            return 'Suave';

        else if ($this->opcoes == 'VDM')
            return 'Demi-Sec';

        else if ($this->opcoes == 'VSC')
            return 'Seco';

        return 'Não informado';
    }


    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of origem
     */
    public function getOrigem(): string
    {
        return $this->origem;
    }

    /**
     * Set the value of origem
     */
    public function setOrigem(string $origem): self
    {
        $this->origem = $origem;

        return $this;
    }

    /**
     * Get the value of sabor
     */
    public function getSabor(): string
    {
        return $this->sabor;
    }

    /**
     * Set the value of sabor
     */
    public function setSabor(string $sabor): self
    {
        $this->sabor = $sabor;

        return $this;
    }



    /**
     * Get the value of descricao
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of imagem
     */
    public function getImagem(): string
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     */
    public function setImagem(string $imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }




    /**
     * Get the value of opcoes
     */
    public function getOpcoes(): string
    {
        return $this->opcoes;
    }

    /**
     * Set the value of opcoes
     */
    public function setOpcoes(string $opcoes): self
    {
        $this->opcoes = $opcoes;

        return $this;
    }
}