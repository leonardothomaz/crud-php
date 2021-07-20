<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

class Vaga
{
    /**
     * Identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Titulo da Vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga (Pode conter HTML)
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga esta ativa
     * @var string(s/n)
     */
    public $ativo;

    /**
     * Data de publicação da vaga 
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar uma nova vaga no banco
     * 
     * @return boolen
     */
    public function cadastrar()
    {
        $this->data = date('Y-m-d H:i:s');

        $obDatabase = new Database('vagas');
        $this->id = $obDatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('vagas'))
            ->update("id = {$this->id}", [
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'ativo' => $this->ativo,
                'data' => $this->data
            ]);

        return true;
    }

    public function excluir()
    {
        return (new Database('vagas'))->delete("id = {$this->id}");
    }

    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))
            ->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getVaga($id)
    {
        return (new Database('vagas'))
            ->select("id = {$id}")
            ->fetchObject(self::class);
    }
}
