<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoInterface;

/**
 * Classe PedidoService.
 * 
 * Esta classe é responsável por fornecer serviços relacionados a Pedidos.
 */
class PedidoService {

	private $pedidoModel;

	public function __construct(PedidoInterface $pedidoModel) {
		$this->pedidoModel = $pedidoModel;
	}

	public function get($id) {
		if ($id) {
			return $this->pedidoModel->getById($id);
		}

		return $this->pedidoModel->getAll();
	}


	public function post() {
		$json_data = file_get_contents('php://input');

		$data = json_decode($json_data, true);
	
		if ($data === null) {
			return false; 
		}

		return $this->pedidoModel->insert($data);
	}

	public function patch() {
		$data = $_REQUEST;
		return $this->pedidoModel->update($data);
	}

	public function delete($id) {
		return $this->pedidoModel->delete($id);
	}
}
