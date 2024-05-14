<?php

namespace App\Models;

use App\Functions\Connection;
use PDO;

/**
 * Interface ImpostoInterface.
 * 
 * Define métodos para manipulação de Imposto.
 */
interface ImpostoInterface {
    public function getAll();
    public function getById($id);
    public function insert($data);
	public function update($data);
    public function delete($id);
}

/**
 * Classe Imposto.
 * 
 * Esta classe representa o modelo para a entidade "Imposto".
 */
class Imposto implements ImpostoInterface {

    /**
     * Método para obter todas os impostos.
     * 
     * @return array Retorna um array contendo todas os impostos.
     */
    public function getAll() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM imposto");
        return $stmt->fetchAll();
    }

    /**
     * Método para obter um imposto pelo seu ID.
     * 
     * @param int $id O ID do imposto a ser obtido.
     * @return mixed Retorna o imposto se encontrado, ou false caso contrário.
     */
    public function getById($id) {
        $pdo = Connection::connect();
		$sql = "SELECT * FROM imposto WHERE id_imposto = :id_imposto";
        $stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id_imposto', $id, PDO::PARAM_INT);
        $stmt->execute();

		if ($stmt->rowCount() > 0) {
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			throw new \Exception("Nenhum imposto encontrado!");
		}
    }

    /**
     * Método para inserir uma novo imposto no banco de dados.
     * 
     * @param array $data Os dados do imposto a serem inseridos.
     * @return int|false Retorna o ID do imposto inserida se bem-sucedido, ou false caso contrário.
     */
    public function insert($data) {
        $pdo = Connection::connect();
        $sql = "INSERT INTO imposto (id_categoria, imposto, dt_vigencia, dt_expiracao, dt_criacao) VALUES (:id_categoria, :imposto, :dt_vigencia, :dt_expiracao, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_categoria', $data['id_categoria'], PDO::PARAM_STR);
        $stmt->bindValue(':dt_vigencia', $data['dt_vigencia'], PDO::PARAM_STR);
        $stmt->bindValue(':dt_expiracao', $data['dt_expiracao'], PDO::PARAM_STR);
        $stmt->bindValue(':imposto', $data['imposto'], PDO::PARAM_STR);
        $success = $stmt->execute();
        return $success ? $pdo->lastInsertId() : false;
    }

    /**
     * Método para atualizar uma imposto existente no banco de dados.
     * 
     * @param int $id O ID da imposto a ser atualizado.
     * @param array $data Os novos dados do imposto.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function update($data) {
        $pdo = Connection::connect();
        $sql = "UPDATE imposto SET imposto = :imposto, id_categoria = :id_categoria, dt_vigencia = :dt_vigencia, dt_expiracao = :dt_expiracao, dt_modificacao = CURRENT_TIMESTAMP WHERE id_imposto = :id_imposto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':imposto', $data['imposto'], PDO::PARAM_STR);
        $stmt->bindValue(':id_categoria', $data['id_categoria'], PDO::PARAM_STR);
        $stmt->bindValue(':dt_vigencia', $data['dt_vigencia'], PDO::PARAM_STR);
        $stmt->bindValue(':dt_expiracao', $data['dt_expiracao'], PDO::PARAM_STR);
		$stmt->bindValue(':id_imposto', $data['id_imposto'], PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }

    /**
     * Método para excluir um imposto do banco de dados.
     * 
     * @param int $id O ID do imposto a ser excluído.
     * @return int|false Retorna o número de linhas afetadas pela operação se bem-sucedida, ou false caso contrário.
     */
    public function delete($id) {
        $pdo = Connection::connect();
        $stmt = $pdo->prepare("DELETE FROM imposto WHERE id_imposto = :id_imposto");
        $stmt->bindValue(':id_imposto', $id, PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success ? $stmt->rowCount() : false;
    }
}
