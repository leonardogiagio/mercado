<?php

use PHPUnit\Framework\TestCase;
use App\Services\ProdutoService;
use App\Models\Produto;

class ProdutoServiceTest extends TestCase {
	private $produtoModelMock;

	private $produtoService;

	protected function setUp(): void {
		parent::setUp();

		$this->produtoModelMock = $this->createMock(Produto::class);

		$this->produtoService = new ProdutoService($this->produtoModelMock);
	}

	public function testGetAllProdutos(): void {
		$this->produtoModelMock->expects($this->once())
			->method('getAll')
			->willReturn(['produto1', 'produto2']);

		$result = $this->produtoService->getAllProdutos();

		$this->assertEquals(['produto1', 'produto2'], $result);
	}


	public function testGetProdutoById(): void {
		$id = 1;
		$produtoMock = ['id_produto' => $id, 'nome' => 'Produto Teste'];

		$this->produtoModelMock->expects($this->once())
			->method('getById')
			->with($id)
			->willReturn($produtoMock);

		$result = $this->produtoService->get($id);

		$this->assertEquals($produtoMock, $result);
	}


	public function testDeleteProduto(): void {
		$produtoId = 1;

		$linhasAfetadas = 1;

		$this->produtoModelMock->expects($this->once())
			->method('delete')
			->with($produtoId) // Verifica se o ID do produto a ser excluído é o esperado
			->willReturn($linhasAfetadas);

		$result = $this->produtoService->delete($produtoId);
		$this->assertEquals($linhasAfetadas, $result);
	}
}
