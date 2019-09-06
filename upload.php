<html>
	<head>
		<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>
      <meta name="description" content="Menu">
      <meta charset="utf-8"/>
      <title>Formulario PHP: Upload</title>
      <script type="text/javascript"> </script>
      <link rel="stylesheet" href="CSS/estilos.css" type="text/css"/>
	   
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

	
	<body>
		
		
	<div id="contenedor">
		
		<form action="location:portfolio.php" method="post">
			
			
			<fieldset id="user" class="campo">
			<legend>Uploader...</legend>
				
				<label for="foto">Archivo:</label>	
				<input type="file" name="fichero_uploader">
				
			</fieldset>
			
			
         
            
			<div id="enviar">
				<button class="btn" type="submit" value="Enviar" name="Enviar">Guardar</button>
			</div>
			
		
		
                </form>
	
		</div>
	</body>


</html>



<?php
	
	if(isset($_POST['Enviar'])){
	
	$fichero=$_FILES['fichero_uploader']['name'];
		
	
		
		$nom=$_FILES['fichero_uploader']['name'];
		$tipo=$_FILES['fichero_uploader']['type'];
		$ext_no=explode(".",$nom);
		$ext_no=$ext_no[0];
		$peso=$_FILES['fichero_uploader']['size'];
		$temp=$_FILES['fichero_uploader']['tmp_name'];
		$error_n=$_FILES['fichero_uploader']['error'];
		$peso_max= 500000000;
		$subdir="docs/";
		$ruta_upload=$subdir.$nom;
		$tipo_upload=pathinfo($ruta_upload,PATHINFO_EXTENSION);
		
		$log_ok=0; //adelantamos que hay error
		
		if($error_n==0){
			echo "Documento seleccionado es correcto <br>";
	
			$log_ok=1;
		}else{
			echo "El fichero no es correcto";
			$log_ok=0;
		}
		
		
		//Miramos si el nombre del documento ya existe
		
		if(file_exists($ruta_upload)){
			echo $ruta_upload;
			echo "Archivo identico";
			$idUnico=time();
			$ext_no="-".$idUnico;
			$nom=$ext_no.".".$tipo;
			
			$ruta_upload=$subdir . $nom;
			
			echo "Nombre nuevo: $ruta_upload <br>";
			
			$logo_ok=1;
			
		}
		
		//Miramos si nos pasamos del peso maxmimo
		
		if($peso>$peso_max){
			
			echo "superas el peso maximo permitido <br>".$peso_max;
			$log_ok=0;
			
		}
		
		
		
		//miramos si tiene la extension correcta
		
		if(($tipo_upload !="jpg") && ($tipo_upload !="png") && ($tipo_upload !="jpeg")){
			echo"Solo se admiten fortmatos: jpg, jpeg,png. <br>";
			$log_ok=0;
		}
		
		
		//Comprobamos si todo OK
		
		if($log_ok==0){
			echo "No superas las condiciones y no se puede subir el archivo <br>";
		}
		else{
			
			//subimos el archivo al directorio de distino final
			if(move_uploaded_file($temp,$ruta_upload)){
				echo "El fichero:".$nom." subido con exito";
			}else {
				echo "El fichero:".$nom." no se puede subir";
				
			}
		}
		
		if(isset($_FILES['fichero_uploader']['name'])){
			
			          header("Location:portfolio.php");
		exit;
			
		}
	}
	
	
	
	
	
	

	
	
		
	
?>