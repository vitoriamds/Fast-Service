<?php 
session_start();
$conn = new PDO("mysql: host=localhost;dbname=FASTSERVICE", 'service', '049633');

function conexao(){
	global $conn;
	return $conn;
}

function pdoExec($prepare, $execute){
	$stmt = conexao()->prepare($prepare);
	$stmt -> execute($execute);
	return $stmt;
}
function rowCount($prepare, $execute = []){
	$stmt = pdoExec($prepare, $execute)->rowCount();
	return $stmt;
}

function addFavoritos($dados){
	$usuario = $_SESSION['userId'];
	$servico = $dados;
	$stmt = pdoExec("INSERT INTO FAVORITOS SET FVR_USER_ID=?, FVR_SRV_ID=? ", [$usuario, $servico]);
	header('location:'.$_SERVER['HTTP_REFERER']);
}

function delFavoritos($dados){
	$usuario = $_SESSION['userId'];
	$servico = $dados['id_servico'];
	pdoExec("DELETE FROM FAVORITOS WHERE FVR_USER_ID=? AND md5(FVR_SRV_ID)=?", [$usuario, $servico]);
	header('location:'.$_SERVER['HTTP_REFERER']);
}

function addServico($dados, $img){
	$nome = $dados['name'];
	$tipo = $dados['type'];
	$descricao = $dados['description'];
	$localizacao = $dados['location'];
	$preco = $dados['price'];
	$usuario = $dados['user_id'];
	
	if(!empty($dados)){
		pdoExec("INSERT INTO SERVICOS SET SRV_NOME=?, SRV_CATEGORIA=?, SRV_DESCRICAO=?, SRV_LOCALIZACAO=?, SRV_PRECO=?, SRV_USER_ID=?", [$nome, $tipo, $descricao, $localizacao, $preco, $usuario]);
		if (!empty($img["name"])) :
        	$caminho = "../produtos/img/";
			$count = count(array_filter($img['name']));
			$permite = ['image/jpeg', 'image/png', 'image/jpg'];
			$id_servico= 0;
			$conn = conexao();
			echo($count);
			for($i=0; $i< $count; $i++):
				$name = $img['name'][$i];
				$tmp = $img['tmp_name'][$i];
				$ext = @end(explode('.', $name));
				$newname = rand().".$ext";
				$diretorio = $caminho.$newname;
				move_uploaded_file($tmp, $diretorio);
				$data = pdoExec("SELECT * FROM SERVICOS WHERE SRV_NOME=? AND SRV_USER_ID=?", [$nome, $usuario]);
				if ($data -> rowCount() >0) :
					$resultado = $data -> fetchAll();
					foreach ($resultado as $value) :
						$id_servico = $value['SRV_ID'];
					endforeach;
				endif;
				$stmt = $conn -> prepare("INSERT INTO IMAGENS SET IMG_NOME=?, IMG_SRV_ID=?");
				$stmt -> execute([$diretorio, $id_servico]);
				$stmt = pdoExec("INSERT INTO MEDIA_AVALIACOES SET MDAV_TOTAL_PESSOAS=?, MDAV_QTD_ESTRELAS=?, MDAV_MEDIA=?, MDAV_SRV_ID=?", [0, 0, 0, $id_servico]);		
			endfor;
		endif;
		header('location: anuncios.php');
	}else{
		header('location: servico.php');
	}
}
function updateServico($dados, $img){
	$nome = $dados['name'];
	$descricao = $dados['description'];
	$localizacao = $dados['location'];
	$preco = $dados['price'];
	$id = $dados['id_servico'];
	$usuario = $_SESSION['userId'];
	if(!empty($dados)){
		$stmt =pdoExec("UPDATE SERVICOS SET SRV_NOME=?, SRV_DESCRICAO=?, SRV_LOCALIZACAO=?, SRV_PRECO=? WHERE SRV_ID=? AND SRV_USER_ID=?", [$nome, $descricao, $localizacao, $preco, $id, $usuario]);
		$caminho = "../produtos/img/";
		$count = count(array_filter($img['name']));
		$permite = ['image/jpeg', 'image/png', 'image/jpg'];
		$id_servico= 0;
		$conn = conexao();
		for($i=0; $i< $count; $i++){
			$name = $img['name'][$i];
			$tmp = $img['tmp_name'][$i];
			$ext = @end(explode('.', $name));
			$newname = rand().".$ext";
			$diretorio = $caminho.$newname;
			move_uploaded_file($tmp, $diretorio);
			if (!empty($_FILES['img'])) {
				$stmt = $conn -> prepare("INSERT INTO IMAGENS SET IMG_NOME=?, IMG_SRV_ID=?");
				$stmt -> execute([$diretorio, $dados['id_servico']]);
			}

		}
		$_SESSION["anuncio_sucesso"]=1;
		header('location: anuncios.php');
	}else{
		header('location:'.$_SERVER['HTTP_REFERER']);
	}
}
function deleteServico($dados){
	$id = $dados['id_servico'];
	$usuario = $_SESSION['userId'];
	pdoExec("DELETE FROM COMENTARIOS WHERE md5(CMT_SRV_ID)=?", [$id]);
	$stmt = pdoExec("SELECT * FROM IMAGENS WHERE md5(IMG_SRV_ID)=?", [$id]);
	$delete = $stmt -> fetchAll();
	foreach ($delete as $value) {
		unlink($value['IMG_NOME']);
	}
	pdoExec("DELETE FROM IMAGENS WHERE md5(IMG_SRV_ID)=?", [$id]);
	pdoExec("DELETE FROM SERVICOS WHERE md5(SRV_ID)=?",[$id]);
	header('location: anuncios.php');
}

function addUser($data){
	$name = $data['name'];
	$username = $data['username'];
	$password = $data['password1'];
	$email = $data['email'];
	$fone = $data['fone'];
	$stmt = rowCount("SELECT * FROM USUARIOS WHERE USER_USUARIO=?", [$username]) > 0;

	if ($stmt) {
		$_SESSION['user_exist'] = 1;
		header('location: register.php');
 		exit();
	}
	$stmt = rowCount("SELECT * FROM USUARIOS WHERE USER_EMAIL=?", [$email]) > 0;
	if ($stmt) {
		$_SESSION['email_exist'] = 1;
		header('location: register.php');
		exit();
	}
	else{
	    $_SESSION['add_user'] = 1;
		pdoExec("INSERT INTO USUARIOS SET USER_NOME = ?, USER_USUARIO =?, USER_SENHA=?, USER_EMAIL=?, USER_TELEFONE=?", [$name, $username, $password, $email, $fone]);
		header('location: ../index.php');
	}
}

function login($data){
	$username = $data['username'];
	$password = md5($data['password']);
	$stmt = pdoExec("SELECT * FROM USUARIOS WHERE USER_USUARIO=?", [$username]);

	if ($stmt->rowCount() > 0) {
		$dados = $stmt -> fetch();
		if ($dados['USER_USUARIO']==$username && $dados['USER_SENHA']!=$password) {
			$_SESSION['password_incorrect'] = 1;
			header('location: ../index.php?i='.$password);
			exit();
		}
		else{
			$_SESSION['userId'] = $dados['USER_ID'];
			$_SESSION['userName'] = $dados['USER_NOME'];
			$_SESSION['userEmail'] = $dados['USER_EMAIL'];
			$_SESSION['userFone'] = $dados['USER_TELEFONE'];
			$_SESSION['userLogin'] = $dados['USER_USUARIO'];
			$_SESSION['userIMG'] = $dados['USER_IMAGEM'];
			header('location: ../index.php');
		}
	}
	else{
		$_SESSION['user_invalid'] = 1;
		header('location: ../index.php');
		exit();
	}
}

function isLogged(){
	if (isset($_SESSION['userName'])) {
		return true;
	}
	else{
		return false;
	}
}

function logout(){
	session_destroy();
	header('location: /');
}

function addComentario($data){
	$comentario = $data['comentario'];
	$usuario = $_SESSION['userId'];
	$servico = $data['id_servico'];
	$stmt = pdoExec("INSERT INTO COMENTARIOS SET CMT_COMENTARIO = ?, CMT_USER_ID = ?, CMT_SRV_ID=? ", [$comentario, $usuario, $servico]);
	header('location:'.$_SERVER['HTTP_REFERER']);

}
