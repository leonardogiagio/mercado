<?php

namespace App\Models;

use App\Functions\Connection;
use PDO;

/**
 * Interface ProdutoPedidoInterface.
 * 
 * Define métodos para manipulação de ProdutoPedido.
 */
interface ProdutoPedidoInterface {
    public function getAll();
    public function getById($id);
    public function insert($data);
	public function update($data);
    public function delete($id);
}

/**
 * Classe ProdutoPedido.
 * 
 * Esta classe representa o modelo para a entidade "ProdutoPedido".
 */
class ProdutoPedido implements ProdutoPedidoInterface {

    /**
     * Método para obter todas as ProdutoPedido.
     * 
     * @return array Retorna um array contendo todas as ProdutoPedido.
     */
    public function getAll() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM produto_pedido");
        return $stmt->fetchAll();
    }

    /**
     * Método para obter uma ProdutoPedido pelo seu ID.
     * 
     * @param int $id O ID da ProdutoPedido a ser obtido.
     * @return mixed Retorna a ProdutoPedido se encontrado, ou false caso contrário.
     */
    public function getById($id) {
        $pdo = Connection::connect();
		$sql = "SELECT 
					pp.id_produto as id_produto,
					pp.id_pedido as id_pedido,
					p.nome as nome,
					p.descricao as descricao,
					pp.quantidade as quantidade,
					p.preco as preco,
					p.imagem as imagem
				FROM produto_pedido pp
				JOIN produto p ON p.id_produto = pp.id_produto 
				WHERE pp.id_pedido = :id_pedido";
        $stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $stmt->execute();

		if ($stmt->rowCount() > 0) {
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			throw new \Exception("Nenhuma ProdutoPedido encontrado!");
		}
    }

    /**
     * Método para inserir uma nova ProdutoPedido no banco de dados.
     * 
     * @param array $data Os dados da ProdutoPedido a serem inseridos.
     * @return int|false Retorna o ID da ProdutoPedido inserida se bem-sucedido, ou false caso contrário.
     */
    public function insert($data) {
        $pdo = Connection::connect();
        $sql = "INSERT INTO produto_pedido (id_pedido, id_produto, quantidade) VALUES (:id_pedido, :id_produto, :quantidade)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_pedido', $data['id_pedido'], PDO::PARAM_STR);
        $stmt->bindValue(':id_produto', $data['id_produto'], PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $data['quantidade'], PDO::PARAM_STR);
        $success = $stmt->execute();
        return $success ? $data['id_pedido'] : false;
    }

    /**
     * Método para atualizar uma ProdutoPedido existente no banco de dados.
     * 
     * @param int $id O ID da ProdutoPedido a ser atualizado.
     * @param array $data Os novos dados da ProdutoPedido.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function update($data) {

    }

    /**
     * Método para excluir uma ProdutoPedido do banco de dados.
     * 
     * @param int $id O ID da ProdutoPedido a ser excluído.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function delete($id) {
        $pdo = Connection::connect();
        $stmt = $pdo->prepare("DELETE FROM produto_pedido WHERE id_pedido = :id_pedido");
        $stmt->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }
}
