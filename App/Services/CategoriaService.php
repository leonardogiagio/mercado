<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\CategoriaInterface;

/**
 * Classe CategoriaService.
 * 
 * Esta classe é responsável por fornecer serviços relacionados a categorias.
 */
class CategoriaService {

	private $categoriaModel;

	public function __construct(CategoriaInterface $categoriaModel) {
		$this->categoriaModel = $categoriaModel;
	}

	public function get($id) {
		if ($id) {
			return $this->categoriaModel->getById($id);
		}

		return $this->categoriaModel->getAll();
	}


	public function post() {
		$data = $_POST;
		return $this->categoriaModel->insert($data);
	}

	public function patch() {
		$data = $_REQUEST;
		return $this->categoriaModel->update($data);
	}

	public function delete($id) {
		return $this->categoriaModel->delete($id);
	}
}
