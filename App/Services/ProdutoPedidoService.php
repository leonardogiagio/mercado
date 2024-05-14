<?php

namespace App\Services;

use App\Models\ProdutoPedido;
use App\Models\ProdutoPedidoInterface;

/**
 * Classe ProdutoPedidoService.
 * 
 * Esta classe é responsável por fornecer serviços relacionados a ProdutoPedidos.
 */
class ProdutoPedidoService {

	private $produtoPedido;

	public function __construct(ProdutoPedidoInterface $produtoPedido) {
		$this->produtoPedido = $produtoPedido;
	}

	public function get($id) {
		if ($id) {
			return $this->produtoPedido->getById($id);
		}

		return $this->produtoPedido->getAll();
	}


	public function post() {
		$json_data = file_get_contents('php://input');

		$data = json_decode($json_data, true);
	
		if ($data === null) {
			return false; 
		}
		return $this->produtoPedido->insert($data);
	}

	public function patch() {
		$data = $_REQUEST;
		return $this->produtoPedido->update($data);
	}

	public function delete($id) {
		return $this->produtoPedido->delete($id);
	}
}
