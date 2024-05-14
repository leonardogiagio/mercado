<?php

namespace App\Services;

use App\Models\Produto;
use App\Models\ProdutoInterface;

/**
 * Classe ProdutoService.
 * 
 * Esta classe é responsável por fornecer serviços relacionados a produtos.
 */
class ProdutoService {

	private $produtoModel;

	public function __construct(ProdutoInterface $produtoModel) {
		$this->produtoModel = $produtoModel;
	}


	public function getAllProdutos() {
		return $this->produtoModel->getAll();
	}


	public function get($id) {
		if ($id) {
			return $this->produtoModel->getById($id);
		}

		return $this->produtoModel->getAll();
	}

	public function post() {
		$data = $_POST;
		return $this->produtoModel->insert($data);
	}

	public function patch() {
		$data = $_REQUEST;
		return $this->produtoModel->update($data);
	}

	public function delete($id) {
		return $this->produtoModel->delete($id);
	}
}
