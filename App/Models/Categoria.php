<?php

namespace App\Models;

use App\Functions\Connection;
use PDO;

/**
 * Interface CategoriaInterface.
 * 
 * Define métodos para manipulação de categoria.
 */
interface CategoriaInterface {
    public function getAll();
    public function getById($id);
    public function insert($data);
	public function update($data);
    public function delete($id);
}

/**
 * Classe Categoria.
 * 
 * Esta classe representa o modelo para a entidade "Categoria".
 */
class Categoria implements CategoriaInterface {

    /**
     * Método para obter todas as categorias.
     * 
     * @return array Retorna um array contendo todas as categorias.
     */
    public function getAll() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM categoria");
        return $stmt->fetchAll();
    }

    /**
     * Método para obter uma categoria pelo seu ID.
     * 
     * @param int $id O ID da categoria a ser obtido.
     * @return mixed Retorna a categoria se encontrado, ou false caso contrário.
     */
    public function getById($id) {
        $pdo = Connection::connect();
		$sql = "SELECT * FROM categoria WHERE id_categoria = :id_categoria";
        $stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_categoria', $id, PDO::PARAM_INT);
        $stmt->execute();

		if ($stmt->rowCount() > 0) {
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			throw new \Exception("Nenhuma categoria encontrado!");
		}
    }

    /**
     * Método para inserir uma nova categoria no banco de dados.
     * 
     * @param array $data Os dados da categoria a serem inseridos.
     * @return int|false Retorna o ID da categoria inserida se bem-sucedido, ou false caso contrário.
     */
    public function insert($data) {
        $pdo = Connection::connect();
        $sql = "INSERT INTO categoria (nome, descricao, dt_criacao) VALUES (:nome, :descricao, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $data['descricao'], PDO::PARAM_STR);
        $success = $stmt->execute();
        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Método para atualizar uma categoria existente no banco de dados.
     * 
     * @param int $id O ID da categoria a ser atualizado.
     * @param array $data Os novos dados da categoria.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function update($data) {
        $pdo = Connection::connect();
        $sql = "UPDATE categoria SET nome = :nome, descricao = :descricao, dt_modificacao = CURRENT_TIMESTAMP WHERE id_categoria = :id_categoria";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $data['descricao'], PDO::PARAM_STR);
		$stmt->bindValue(':id_categoria', $data['id_categoria'], PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }

    /**
     * Método para excluir uma categoria do banco de dados.
     * 
     * @param int $id O ID da categoria a ser excluído.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function delete($id) {
        $pdo = Connection::connect();
        $stmt = $pdo->prepare("DELETE FROM categoria WHERE id_categoria = :id_categoria");
        $stmt->bindValue(':id_categoria', $id, PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }
}
