<?php

namespace App\Models;

use App\Functions\Connection;
use PDO;

/**
 * Interface ProdutoInterface.
 * 
 * Define métodos para manipulação de produtos.
 */
interface ProdutoInterface {
	public function getAll();
	public function getById($id);
	public function insert($data);
	public function update($data);
	public function delete($id);
}

/**
 * Classe Produto.
 * 
 * Esta classe representa o modelo para a entidade "Produto".
 */
class Produto implements ProdutoInterface {

	/**
	 * Método para obter todos os produtos.
	 * 
	 * @return array Retorna um array contendo todos os produtos.
	 */
	public function getAll() {
		$pdo = Connection::connect();
		$stmt = $pdo->query("SELECT 
								p.*,
								i.imposto as imposto 
							FROM produto p
							JOIN imposto i ON i.id_categoria = p.id_categoria");
		return $stmt->fetchAll();
	}

	/**
	 * Método para obter um produto pelo seu ID.
	 * 
	 * @param int $id O ID do produto a ser obtido.
	 * @return mixed Retorna o produto se encontrado, ou false caso contrário.
	 */
	public function getById($id) {
		$pdo = Connection::connect();
		$sql = "SELECT * FROM produto WHERE id_produto = :id_produto";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			throw new \Exception("Nenhum produto encontrado!");
		}
	}

	/**
	 * Método para inserir um novo produto no banco de dados.
	 * 
	 * @param array $data Os dados do produto a serem inseridos.
	 * @return int|false Retorna o ID do produto inserido se bem-sucedido, ou false caso contrário.
	 */
	public function insert($data) {
		$pdo = Connection::connect();

		if (isset($_FILES['imagem'])) {
			$uploadDir = '../public/assets/images/produtos/';
			$fileName = basename($_FILES['imagem']['name']);
			$uploadFile = $uploadDir . $fileName;
			$urlInsert = '/assets/images/produtos/'.$fileName;
			if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
				$sql = "INSERT INTO produto (id_categoria, nome, descricao, preco, imagem) VALUES (:id_categoria, :nome, :descricao, :preco, :imagem)";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':id_categoria', $data['id_categoria'], PDO::PARAM_INT);
				$stmt->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
				$stmt->bindValue(':descricao', $data['descricao'], PDO::PARAM_STR);
				$stmt->bindValue(':preco', $data['preco'], PDO::PARAM_STR);
				$stmt->bindValue(':imagem', $urlInsert, PDO::PARAM_STR);
				$success = $stmt->execute();
				return $success ? $pdo->lastInsertId() : false;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/**
	 * Método para atualizar um produto existente no banco de dados.
	 * 
	 * @param int $id O ID do produto a ser atualizado.
	 * @param array $data Os novos dados do produto.
	 * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
	 */
	public function update($data) {
		$pdo = Connection::connect();
		$sql = "UPDATE produto SET id_categoria = :id_categoria, nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id_produto = :id_produto";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_categoria', $data['id_categoria'], PDO::PARAM_INT);
		$stmt->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
		$stmt->bindValue(':descricao', $data['descricao'], PDO::PARAM_STR);
		$stmt->bindValue(':preco', $data['preco'], PDO::PARAM_STR);
		$stmt->bindValue(':imagem', $data['imagem'], PDO::PARAM_STR);
		$stmt->bindValue(':id_produto', $data['id_produto'], PDO::PARAM_INT);
		$success = $stmt->execute();
		return $success ? $stmt->rowCount() : false;
	}

	/**
	 * Método para excluir um produto do banco de dados.
	 * 
	 * @param int $id O ID do produto a ser excluído.
	 * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
	 */
	public function delete($id) {
		$pdo = Connection::connect();
		$stmt = $pdo->prepare("DELETE FROM produto WHERE id_produto = :id_produto");
		$stmt->bindValue(':id_produto', $id, PDO::PARAM_INT);
		$success = $stmt->execute();
		return $success ? $stmt->rowCount() : false;
	}
}
