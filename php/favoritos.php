<?php include("functions.php"); if(!isLogged()){header('location: index.php'); exit();} ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Fast-Service</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/functions.js"></script>
	<link rel="shortcut icon" type="image/x-png" href="img/3.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
	<div>
		<nav>
			
			<a href="../index.php"><img src="../img/3.png"></a>
			<ul>
				<li><a href="/">Início</a></li>
				<li><a href="ajuda.php">Ajuda</a></li>
				<li><a href="favoritos.php">Meus favoritos</a></li>
				<li><a href="anuncios.php">Meus anúncios</a></li>
				<li><a href="perfil.php">Minha conta</a></li>
				<li><a href="servico.php">Anunciar</a></li>
				<li><a href="logout.php" class="btn-login">Sair</a></li>
			</ul>
			
		</nav>
	</div>

	<br>
	<center>
		<div class="busca">
			<form action="search.php" method="GET">
				<input type="text" placeholder="  Estou procurando por..." required>
				<button type="submit"><i class="fas fa-search" ></i></button>

				<ul class="icons-busca">
				     <li class="icons"> <a href=search.php?search=<?=md5(4);?> > <i class="fas fa-tshirt"></i>Moda e Beleza </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(7);?> > <i class="fas fa-volleyball-ball"></i>Esportes e Lazer </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(8);?> > <i class="fas fa-mortar-pestle"></i>Culinária </a></li>
				    <li class="icons"> <a href=search.php?search=<?=md5(10);?> ><i class="fas fa-guitar"></i>Músicas e Hobbies </a></li>
				    <li class="icons"> <a href=search.php?search=todos><i class="fas fa-th-list"></i>Todas as Categorias </a></li>
				</ul>
			</form>
		</div>

	<div class="search">
		<?php 
		$usuario = $_SESSION['userId']; 
		$dados = pdoExec("SELECT SERVICOS.* FROM SERVICOS INNER JOIN FAVORITOS ON FAVORITOS.FVR_SRV_ID = SERVICOS.SRV_ID INNER JOIN USUARIOS ON USUARIOS.USER_ID = FAVORITOS.FVR_USER_ID WHERE USUARIOS.USER_ID = ?", [$usuario]);
		$resultado = $dados -> fetchAll();
			foreach ($resultado as $value):?>
				<center><br>
					<div class="products">
						<div class="foto"><img src="<?=$value['SRV_IMAGEM'];?>" style="width: 100%; height: 100%;"></div>
						<a href=desc_produto.php?desc=<?= md5($value['SRV_ID']);?>>
							<p><?= $value['SRV_NOME'];?><br>
							<?= "R$: ".$value['SRV_PRECO']; ?><br>
							<?= $value['SRV_LOCALIZACAO']; ?></p>
						</a>
					</div>
				</center>	
			<?php endforeach; ?>
	</div>
	<?php include("login.php");?>
	<footer class="rodape">©Copyright 2019</footer>

</body>
</html>