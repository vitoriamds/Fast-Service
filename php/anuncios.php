<?php include("functions.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Fast-Service</title>
	
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../demo-files/demo.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/functions.js"></script>
	<link rel="shortcut icon" type="image/x-png" href="img/3.png">
	<link rel="stylesheet" href="../fontawesome/css/all.css">
</head>
<body>
	<div>
		<nav>
			
			<a href="index.php"><img src="../img/3.png"></a>
			<ul>
				<li><a href="/">Início</a></li>
				<li><a href="sobre.php">Sobre</a></li>
				<li><a href="ajuda.php">Ajuda</a></li>
				<?php if (isLogged() ){ ?>
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

				<button type="submit"><i class="icon icon-search" ></i></button>

				<ul class="icons-busca">
				    <li class="icons"> <a href=""><i class="fas fa-tshirt"></i>Moda e Beleza </a></li>
				    <li class="icons"> <a href=""><i class="fas fa-volleyball-ball"></i>Esportes e Lazer </a></li>
				    <li class="icons"> <a href=""><i class="fas fa-mortar-pestle"></i>Culinária </a></li>
				    <li class="icons"> <a href=""><i class="fas fa-guitar"></i>Músicas e Hobbies </a></li>
				    <li class="icons"> <a href=""><i class="fas fa-th-list"></i>Todas as Categorias </a></li>
				</ul>
			</form>
		</div>

	<div class="search">
		<?php 
		$usuario = $_SESSION['userId']; 
		$stmt = conexao();
		$dados = $stmt -> prepare("SELECT * FROM SERVICOS WHERE SRV_USER_ID=?" );
		$dados -> execute([$usuario]);
		$resultado = $dados -> fetchAll(); 
		foreach($resultado as $value):?>
			<div style="width: 50%; margin: auto;">
				<center>
					<br><p style="margin-top: 140px;"><h2><?= $value['SRV_NOME'];?></h2></p><hr><br>
					<h3>Preço</h3>
					<p><?= "R$: ".$value['SRV_PRECO'];?></p><hr><br>
					<h3>Descrição</h3>
					<p><?= $value['SRV_DESCRICAO'];?></p>
					<p>Lorem ipsum é um texto utilizado para preencher o espaço de texto em publicações (jornais, revistas, e websites) e testar aspectos visuais(cores, fontes), com a finalidade de verificar o layout, tipografia e formatação antes de utilizar conteúdo real.</p><br><hr><br>
					<h3>Localização</h3>
					<p><?= $value['SRV_LOCALIZACAO'];?></p><hr>
					<form action="add_comentario.php" method="GET" style="margin-top: 80px;">
						<p>Comentários</p>
						<?php
						$id = $value['SRV_ID'];
						$conn = conexao();
						$stmt = $conn -> prepare("SELECT * FROM COMENTARIOS WHERE CMT_SRV_ID=?");
						$stmt -> execute([$id]);
						$dados = $stmt->fetchAll();
						foreach ($dados as $value) {?>
							<p><?= $value['CMT_COMENTAIO'];?></p>
						<?php } ?>
						
						<textarea name="comentario" placeholder="Digite aqui" style="resize: none; width: 80%; height: 80px;"></textarea><br>
						<input type="hidden" value=<?=$id;?>>
						<button type="submit">Comentar</button>
					</form>
				</center>	
			</div>
		<?php endforeach; ?>
	</div>

	</center>
	<div class="window" id="janela">
			<center>
				<a href="#" class="fechar">X</a>
				<h4>Login</h4>
				<hr>
				<form action="login2.php" method="POST">
					<p>Usuário</p><br>
					<input type="text" name="username" placeholder="Digite aqui"><br>
					<p>Senha</p><br>
					<input type="password" name="password" placeholder="Digite aqui"><br>
					<button type="submit">Entrar</button><br>
					<a href="#">Esqueceu sua senha?</a>
				</form>
			</center>
		</div>

	<div id="mascara">
		
	</div>

	<footer class="rodape">©Copyright 2019</footer>

</body>
</html>