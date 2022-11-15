<?php
	require_once 'classe-pessoa.php';
	$p = new Pessoa("agenda","localhost","root","");
?>

<!DOCTYPE html>

<html lang="pt-br">
  <head>
    <title>Cadastro</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="estilo.css">
  </head>
  <body>
  	<?php
  		if (isset($_POST['nome']))// clicou em cadastrar ou atualizar
  		{
  			//-----EDITAR-----

  			if (isset($_GET['id_pessoa_up']) && !empty($_GET['id_pessoa_up'])) {
  				$id_pessoa_up = addslashes($_GET['id_pessoa_up']);
	  			$ds_nome = addslashes($_POST['nome']);
	  			$cd_sexo = addslashes($_POST['sexo']);
	  			$dt_nasc = addslashes($_POST['nascimento']);
	  			$nr_telefone = addslashes($_POST['tel']);
	  			$ds_email = addslashes($_POST['email']);

	  			if (!empty($ds_nome) && !empty($cd_sexo) && !empty($dt_nasc) && !empty($nr_telefone) && !empty($ds_email)) {
	  				//editar
	  				!$p->atualizarDados ($id_pessoa_up, $ds_nome, $cd_sexo, $dt_nasc, $nr_telefone, $ds_email);
	  				header("location: index.php");
	  			}
	  			else {
	  				?>
   					<div class="aviso">
   						<img src="aviso.png" width="30px" height="30px">
   						<h4>Preencha todos os campos!</h4>
   					</div>
   				<?php
	  			}
  			
  			//-----CADASTRAR------
  			}else{
  			$ds_nome = addslashes($_POST['nome']);
  			$cd_sexo = addslashes($_POST['sexo']);
  			$dt_nasc = addslashes($_POST['nascimento']);
  			$nr_telefone = addslashes($_POST['tel']);
  			$ds_email = addslashes($_POST['email']);

  			if (!empty($ds_nome) && !empty($cd_sexo) && !empty($dt_nasc) && !empty($nr_telefone) && !empty($ds_email)) {
  				//cadastrar
  				if (!$p->cadastrarPessoa ($ds_nome, $cd_sexo, $dt_nasc, $nr_telefone, $ds_email))
  				{
  					?>
   					<div class="aviso">
   						<img src="aviso.png" width="30px" height="30px">
   						<h4>E-mail já cadastrado!</h4>
   					</div>
   				<?php
  				}

  			}
  			else {
  				?>
   					<div class="aviso">
   						
   						<img src="aviso.png" width="30px" height="30px"><h4>Preencha todos os campos!</h4>
   					</div>
   				<?php
  			}
  			}

  		}

  	?>

  	<?php
  		if (isset($_GET['id_pessoa_up'])) {
  			$id_pessoa_up = addslashes($_GET['id_pessoa_up']);
  			$res = $p->buscarDadosPessoa($id_pessoa_up);
  		}
  	?>

   	<section id="esquerda">
   		<form method="POST">
   			<center><h2>Novo Contato</h2></center><br>

   			<label for="nome">Nome</label>
   			<input type="text" name="nome" id="nome" value="<?php if (isset($res)){echo $res['ds_nome'];}?>">

   			<label for="sexo">Gênero (M, F ou N)</label>
   			<input type="text" name="sexo" id="sexo" value="<?php if (isset($res)){echo $res['cd_sexo'];}?>">

   			<label for="nascimento">Data de nascimento</label>
   			<input type="date" name="nascimento" id="nascimento" value="<?php if (isset($res)){echo $res['dt_nasc'];}?>">

   			<label for="tel">Telefone com DDD (Apenas números)</label>
   			<input type="text" name="tel" id="tel" value="<?php if (isset($res)){echo $res['nr_telefone'];}?>">

   			<label for="email">E-mail</label>
   			<input type="email" name="email" id="email" value="<?php if (isset($res)){echo $res['ds_email'];}?>">

   			<input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>" class="btn">

   		</form>
   	</section>

   	<section id="direita">
		<table>

			<tr id="titulo">
   				<td>Nome</td>
   				<td>Gênero</td>
   				<td>Data de Nascimento</td>
   				<td>Telefone</td>
   				<td>E-mail</td>
   				<td>Ações</td>
   			</tr>

   		<?php
   			$dados = $p->buscarDados();
   			if (count($dados) > 0) {
   				for ($i=0; $i < count($dados); $i++) {

   					echo "<tr>";

   					foreach ($dados[$i] as $k => $v) 
   					{
   						if ($k != "id_pessoa") 
   						{
   							echo "<td>".$v."</td>";
   						}
   					}
   						?>
   						<td>
   							<a href="index.php?id_pessoa_up=<?php echo $dados[$i]['id_pessoa'];?>">Editar</a>
   							<a href="index.php?id_pessoa=<?php echo $dados[$i]['id_pessoa'];?>">Excluir</a>
   						</td>
   						<?php
   					echo "</tr>";

   				}
   			}
   			?>
   		</table>		
   	</section>

  </body>
</html>

<?php
	
	if (isset($_GET['id_pessoa'])) {
		$id_pessoa = addslashes($_GET['id_pessoa']);
		$p->excluirPessoa($id_pessoa);
		header("location: index.php");
	}

?>