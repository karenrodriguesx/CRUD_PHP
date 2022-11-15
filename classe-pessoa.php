<?php

Class Pessoa {

	private $pdo;
	
	//conexão com o Banco de Dados
	public function __construct($dbname, $host, $user, $senha) {

		try {
			$this -> pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
		} 
		catch (PDOException $e) {
			echo "Erro com banco de dados: ".$e->getMessage();
			exit();
		}
		catch (Exception $e) {
			echo "Erro genérico: ".$e->getMessage();
			exit();
		}
		
	}

	//função para buscar os dados e colocar na tabela
		public function buscarDados () {
			$res = array();
			$cmd = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY ds_nome");
			$res = $cmd->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}

		//CADASTRAR
		public function cadastrarPessoa ($ds_nome, $cd_sexo, $dt_nasc, $nr_telefone, $ds_email){
			//verificar se o e-mail já está cadastrado
			$cmd = $this->pdo->prepare("SELECT id_pessoa from tb_pessoa WHERE ds_email = :e");
			$cmd->bindValue(":e",$ds_email);
			$cmd->execute();

			if ($cmd->rowCount() > 0) {
				return false;
			} else {
				$cmd = $this->pdo->prepare("INSERT INTO tb_pessoa (ds_nome, cd_sexo, dt_nasc, nr_telefone, ds_email) VALUES (:nome, :sx, :nasc, :tel, :e)");
				$cmd->bindValue(":nome", $ds_nome);
				$cmd->bindValue(":sx", $cd_sexo);
				$cmd->bindValue(":nasc", $dt_nasc);
				$cmd->bindValue(":tel", $nr_telefone);
				$cmd->bindValue(":e", $ds_email);

				$cmd->execute();

				return true;
			}
		}

		//EXCLUIR
		public function excluirPessoa ($id_pessoa){
			$cmd = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE id_pessoa = :id_pessoa");
			$cmd->bindValue(":id_pessoa",$id_pessoa);
			$cmd->execute();
		}

		//EDITAR

		//BUSCAR DADOS
		public function buscarDadosPessoa($id_pessoa){
			$res = array();

			$cmd = $this->pdo->prepare("SELECT * FROM tb_pessoa WHERE id_pessoa = :id_pessoa");
			$cmd->bindValue(":id_pessoa", $id_pessoa);
			$cmd->execute();

			$res = $cmd->fetch(PDO::FETCH_ASSOC);

			return $res;
		}
		//ATUALIZAR DADOS
		public function atualizarDados($id_pessoa, $ds_nome, $cd_sexo, $dt_nasc, $nr_telefone, $ds_email){
			
			$cmd = $this->pdo->prepare("UPDATE tb_pessoa SET ds_nome = :nome, cd_sexo = :sx, dt_nasc = :nasc, nr_telefone = :tel, ds_email = :e WHERE id_pessoa = :id_pessoa");

			$cmd->bindValue(":nome", $ds_nome);
			$cmd->bindValue(":sx", $cd_sexo);
			$cmd->bindValue(":nasc", $dt_nasc);
			$cmd->bindValue(":tel", $nr_telefone);
			$cmd->bindValue(":e", $ds_email);
			$cmd->bindValue(":id_pessoa", $id_pessoa);

			$cmd->execute();

		
		}

}
?>