<?php

namespace App\Functions;

use Dotenv\Dotenv;

/**
 * Classe Connection.
 * 
 * Esta classe fornece métodos para estabelecer conexão com o banco de dados.
 */
class Connection {

	/**
	 * Método estático para estabelecer uma conexão com o banco de dados.
	 * 
	 * @return PDO|false Retorna um objeto PDO representando a conexão com o banco de dados em caso de sucesso.
	 *                   Retorna false em caso de falha na conexão.
	 */
	public static function connect() {
		$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
		$dotenv->load();
		
        $DBDRIVE = $_ENV['DBDRIVE'];
        $DBHOST = $_ENV['DBHOST'];
        $DBNAME = $_ENV['DBNAME'];
        $DBUSER = $_ENV['DBUSER'];
        $DBPASS = $_ENV['DBPASS'];

        try {
            $pdo = new \PDO($DBDRIVE . ':host=' . $DBHOST . ';dbname=' . $DBNAME, $DBUSER, $DBPASS);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            return $pdo;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
	}
}
