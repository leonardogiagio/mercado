<?php

namespace App\Models;

use App\Functions\Connection;
use PDO;

/**
 * Interface PedidoInterface.
 * 
 * Define métodos para manipulação de Pedido.
 */
interface PedidoInterface {
    public function getAll();
    public function getById($id);
    public function insert($data);
	public function update($data);
    public function delete($id);
}

/**
 * Classe Pedido.
 * 
 * Esta classe representa o modelo para a entidade "Pedido".
 */
class Pedido implements PedidoInterface {

    /**
     * Método para obter todas as Pedidos.
     * 
     * @return array Retorna um array contendo todas as Pedidos.
     */
    public function getAll() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM pedido");
        return $stmt->fetchAll();
    }

    /**
     * Método para obter uma pedido pelo seu ID.
     * 
     * @param int $id O ID da pedido a ser obtido.
     * @return mixed Retorna a pedido se encontrado, ou false caso contrário.
     */
    public function getById($id) {
        $pdo = Connection::connect();
		$sql = "SELECT * FROM pedido WHERE id_pedido = :id_pedido";
        $stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $stmt->execute();

		if ($stmt->rowCount() > 0) {
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			throw new \Exception("Nenhum pedido encontrado!");
		}
    }

    /**
     * Método para inserir uma nova pedido no banco de dados.
     * 
     * @param array $data Os dados da pedido a serem inseridos.
     * @return int|false Retorna o ID da pedido inserida se bem-sucedido, ou false caso contrário.
     */
    public function insert($data) {
        $pdo = Connection::connect();
        $sql = "INSERT INTO pedido (total, dt_pedido) VALUES (:total, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':total', $data['total'], PDO::PARAM_STR);
        $success = $stmt->execute();
        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Método para atualizar uma pedido existente no banco de dados.
     * 
     * @param int $id O ID da pedido a ser atualizado.
     * @param array $data Os novos dados da pedido.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function update($data) {
 
    }

    /**
     * Método para excluir uma pedido do banco de dados.
     * 
     * @param int $id O ID da pedido a ser excluído.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function delete($id) {
        $pdo = Connection::connect();
        $stmt = $pdo->prepare("DELETE FROM pedido WHERE id_pedido = :id_pedido");
        $stmt->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }
}
