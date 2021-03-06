<?php include("functions.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Fast-Service</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/functions.js"></script>
	<link rel="shortcut icon" type="image/x-png" href="../img/3.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
	<div>
		<nav>
			
			<a href="index.php"><img src="../img/3.png"></a>
			<ul>
				<li><a href="/">Início</a></li>
				<li><a href="ajuda.php">Ajuda</a></li>
				<?php if (isLogged() ){ ?>
				<li><a href="favoritos.php">Meus favoritos</a></li>
					<li><a href="anuncios.php">Meus anúncios</a></li>
					<li><a href="perfil.php">Minha conta</a></li>
					<li><a href="servico.php">Anunciar</a></li>
					<li><a href="logout.php" class="btn-login">Sair</a></li>
				<?php } else{ ?>
				<li><a href="register.php">Registrar-se</a></li>
				<li><a href="#janela" rel="modal" class="btn-login">Login</a></li>
			<?php } ?>
			</ul>
			
		</nav>
	</div>

	<br>
	<center>
		<div class="busca">
			<form action="">
				<input type="text" placeholder="  Estou procurando por..." required>
				<button type="submit"><i class="fas fa-search" ></i></button>
			</form>
				<ul class="icons-busca">
				    <li class="icons"> <a href=search.php?search=<?=md5(4);?> > <i class="fas fa-tshirt"></i>Moda e Beleza </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(7);?> > <i class="fas fa-volleyball-ball"></i>Esportes e Lazer </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(8);?> > <i class="fas fa-mortar-pestle"></i>Culinária </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(10);?> ><i class="fas fa-guitar"></i>Músicas e Hobbies </a></li>
				    <li class="icons"> <a href=search.php?search=todos><i class="fas fa-th-list"></i>Todas as Categorias </a></li>
				</ul>
		</div>

		<div class="search">
			<center>
				<?php
				$search = $_GET['search'];
				$dados = pdoExec("SELECT * FROM SERVICOS WHERE SRV_NOME LIKE '%$search%' ", []);
				$resultado = $dados -> fetchAll(); 
				foreach($resultado as $value):?>
				<br>
					<div class="products">
						<div class="foto"><img src="<?=$value['SRV_IMAGEM'];?>" style="width: 100%; height: 100%;"></div>
						<a href=desc_produto.php?desc=<?= md5($value['SRV_ID']);?>>
							<p><?= $value['SRV_NOME'];?><br>
							<?= "R$: ".$value['SRV_PRECO']; ?><br>
							<?= $value['SRV_LOCALIZACAO']; ?></p>
						</a>
					</div>
				<?php endforeach; ?>
				<?php if(!$dados->rowCount() > 0  ){
					$row = 1;
					$dados = pdoExec("SELECT * FROM SERVICOS WHERE md5(SRV_CATEGORIA)=?", [$search]);
					$resultado = $dados -> fetchAll(); 
					foreach($resultado as $value):?>
					<br>
						<div class="products">
							<div class="foto"><img src="<?=$value['SRV_IMAGEM'];?>" style="width: 100%; height: 100%;"></div>
							<a href=desc_produto.php?desc=<?= md5($value['SRV_ID']);?>>
								<p><?= $value['SRV_NOME'];?><br>
								<?= "R$: ".$value['SRV_PRECO']; ?><br>
								<?= $value['SRV_LOCALIZACAO']; ?></p>
							</a>
						</div>
				<?php endforeach; } ?> 
				<?php if($search=="todos"){
					$dados = pdoExec("SELECT * FROM SERVICOS", []);
					$resultado = $dados -> fetchAll(); 
					foreach($resultado as $value):?>
					<br>
						<div class="products">
							<div class="foto"><img src="../produtos/img/<?=$value['SRV_IMAGEM'];?>" style="width: 100%; height: 100%;"></div>
							<a href=desc_produto.php?desc=<?= md5($value['SRV_ID']);?>>
								<p><?= $value['SRV_NOME'];?><br>
								<?= "R$: ".$value['SRV_PRECO']; ?><br>
								<?= $value['SRV_LOCALIZACAO']; ?></p>
							</a>
						</div>
				<?php endforeach; } ?> 
			</center>
		</div>
	</center>

	<?php include("login.php");?>

	<footer class="rodape">©Copyright 2019</footer>

</body>
</html>