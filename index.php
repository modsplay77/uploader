<?php 

session_start();

?>

<html>
	<head>
		
      <meta name="description" content="Formulario">
      <meta charset="utf-8"/>
      <title>Formulario PHP</title>
      <script type="text/javascript"> </script>
      <link rel="stylesheet" href="CSS/estilos.css" type="text/css"/>
	   <script defer src="CSS/iconos/js/all.js"></script>
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

	
	<body>
		
		
	<div id="contenedor">
		<div class="log">Login</div>
		
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			
			
			<div id="user" class="campo">
			<i class="fas fa-user icon"></i>
			<input class="input" type="text" name="user" value="<?php if (isset($_POST['user'])) echo $_POST['user']; ?>" placeholder="Usuario" autofocus >
					</div>
			<div id="pwd" class="campo">
			<i class="fas fa-unlock-alt icon"></i>
		
			
			<input class="input" type="password" name="pwd" placeholder="Password" autocomplete="off" autofocus >
			</div>
			
			<div id="mail" class="campo">
			<i class="fas fa-mail-bulk icon"></i>
		
			
			<input class="input" type="email" name="mail" placeholder="E-mail" autocomplete="off" autofocus >
			</div>
		
			
			
			
			
			
			
			<div id="botons">
				<button class="btn" type="submit" value="Enviar" name="Enviar">Login</button>
				<button class="btn" type="submit" value="Registrarse" name="Registrar">Registrarse</button>
				<button class="btn" type="submit" value="Reset pwd" name="Reset">Reset pass</button>
			</div>
			
		
		
		</form>
	
		</div>
	</body>


</html>



<?php


class Registro{
	
	public $db;
	
	function __construct(){
		
		$servidor='localhost';
		$user='root';
		$pwd='';
		$bdd='practica';
		
		$this->db=$this->conectar($servidor,$user,$pwd,$bdd);
		
	}

	/*Conectamos a la BDD*/
	function conectar($servidor,$user,$pwd,$bdd){
		$db= new mysqli ($servidor,$user,$pwd,$bdd);

		if ($db->connect_error){
			die ("No se puede conectar:".$db->connect_error);
		}
		return $db;
	}
    
    
    function comparar ($mail){


		$sql=" SELECT email FROM users where email=?;";

			$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("s",$mail);
		}

		$stmt->execute();

		$resultado=$stmt->get_result();
		  while ($row=mysqli_fetch_array($resultado)) {


			$id=$row ["email"];

		  }

		return $id;

	}

    
    	/*Ejecutamos los comandos sql*/
	function sql($user, $pass, $mail){


		$sql="INSERT INTO users(ID,user,pwd,email) VALUES (DEFAULT,?,?,?)";


		$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("sss", $user, $pass, $mail);
		}

		$stmt->execute();

	}
    
    
    function login ($user){


		$sql=" SELECT user FROM users where user=?;";

			$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("s",$user);
		}

		$stmt->execute();

		$resultado=$stmt->get_result();
		  while ($row=mysqli_fetch_array($resultado)) {


			$id=$row ["user"];

		  }

		return $id;

	}
    
     

	function hash ($user){


		$sql=" SELECT pwd FROM users where user=?;";

			$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("s",$user);
		}

		$stmt->execute();

		$resultado=$stmt->get_result();
		  while ($row=mysqli_fetch_array($resultado)) {


			$id_=$row ["pwd"];

		  }

		return $id_;

	}   
	
	function encontrar($user,$mail){
		

		$sql=" SELECT ID FROM users where user=? AND email=?;";

			$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("ss",$user,$mail);
		}

		$stmt->execute();

		$resultado=$stmt->get_result();
		  while ($row=mysqli_fetch_array($resultado)) {


			$ID=$row ["ID"];
			  print_r($ID);

		  }
		
		return $ID;





	}
	
	
	function reset_pass($pass,$ID){
		
		$sql="UPDATE users SET pwd=? where ID=?";


		$stmt=$this->db->stmt_init();
		if(!$stmt->prepare($sql)){
			die ("error:".$stmt->error);
		}else {

			$stmt->bind_param("si",$pass,$ID);
		}

		$stmt->execute();
		
	}

}



$basedatos_ = new Registro();


/*registrarse en BDD de usuarios*/
if(isset($_POST['Registrar'])&& (isset($_POST['user']))&&(isset($_POST['pwd'])) && (isset($_POST['mail']))){
	
	$user=$_POST['user'];
	$pass=$_POST['pwd'];
	$mail=$_POST['mail'];
	
     $pass_cifrado = password_hash($pass, PASSWORD_DEFAULT, array("cost"=>15));
    
    $id=$basedatos_->comparar($mail);
    
    if($id===$mail){
        echo '<div class="alerta">';
        echo "Usuario ja registrat";
        echo '</div>';
    }else {
	$basedatos_->sql($user, $pass_cifrado, $mail);
    }
	
	
	
	
}





	/*inicio sesion*/
	if((isset($_POST['Enviar'])) && (!empty($_POST['user'])) && (!empty($_POST['pwd']))){

	
	$user=$_POST['user'];
	$pass=$_POST['pwd'];

      	
    $id=$basedatos_->login($user);
    $id_=$basedatos_->hash($pass_cifrado);
		  $hash=$id_;
		

     if(($id==$user)&& ($id_==(password_verify('rasmuslerdorf', $hash)))){
        $_SESSION["user"]=$user;
          header("Location:upload.php");
		exit;
        
    }else {
         if ($id_==$pass_cifrado){
         echo '<div class="alerta">';
        echo "PWD erroneo";
        echo '</div>';
			}
		 if ($id=$user){
         echo '<div class="alerta">';
        echo "Usuario NO registrado";
        echo '</div>';
			}
   
    }
    }


if((isset($_POST['Reset']))&& (isset($_POST['user']))&&(isset($_POST['pwd'])) && (isset($_POST['mail']))){
	$errores = '';
    $enviado = '';
	$user=$_POST['user'];
	$pass=$_POST['pwd'];
	$mail=$_POST['mail'];
	
	
	
	
       
        
        /*                       NOMBRE        */
        if(!empty($user)){
            $user=trim($user);
            $user=filter_var($user, FILTER_SANITIZE_STRING);
        }
        else{
            $errores.= 'Por favor, introduzca su nick <br>';
        }
        
        
         /*                      CORREO      */
        
        
        
        
        if(!empty($mail)){
           
                $mail=filter_var($mail, FILTER_SANITIZE_EMAIL);
            
                if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                      // mirar si es correo real, devuelve false si es incorrecto

                    $errores.='Por favor, introduce un correo válido <br>';
                }
        } 
        else{
                $errores.= 'Por favor, introduzca un correo <br>';
            }
        
        

        
        
         
        
        
        
        
        
        
        // Cuando está todo relleno que pasa
        
        if(!$errores){
            
            
            $destinatario =$mail;
            $asunto = "Reiniciar pwd";
            $mensaje_a_enviar = "Estimado: $user \n";         //cuidado comillas dobles
            $mensaje_a_enviar.= "Mensaje: Desde la web te invitamos a reiniciar tu pwd desde este enlace \n";
            
           
            
            
        }
        
		}
	
	

?>