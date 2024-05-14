<?php

namespace App\Services;

use App\Models\Imposto;
use App\Models\ImpostoInterface;

/**
 * Classe ImpostoService.
 * 
 * Esta classe é responsável por fornecer serviços relacionados a Impostos.
 */
class ImpostoService {

	private $impostoModel;

	public function __construct(ImpostoInterface $impostoModel) {
		$this->impostoModel = $impostoModel;
	}

	public function get($id) {
		if ($id) {
			return $this->impostoModel->getById($id);
		}

		return $this->impostoModel->getAll();
	}

	public function post() {
		$data = $_POST;
		return $this->impostoModel->insert($data);
	}

	public function patch() {
		$data = $_REQUEST;
		return $this->impostoModel->update($data);
	}

	public function delete($id) {
		return $this->impostoModel->delete($id);
	}
}
