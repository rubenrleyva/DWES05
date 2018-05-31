<!DOCTYPE html>
<!--
DWES6 - Servicios web
Autor: Rubén Ángel Rodriguez Leyva
-->

<?php

	// Se generan las rutas del archivo
	$url = str_replace("cliente", "servicio", "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$uri = str_replace("/cliente.php", "", "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

	
	// Creamos el cliente SOAP
	$cliente = new SoapClient(null, array('location'=>$url, 'uri'=>$uri));
	
	$error = "";
	$privados = 0;
	$publicos = 0;

?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Tarea 5: SinObsolescencia</title>
    <style>
		*{
            text-align: center;
        }
        table
        {
            border-collapse: collapse;
			margin: 0 auto;
        }
        td, th /* Asigna un borde a las etiquetas td Y th */
        {
            border: 1px solid black;
        }
    </style>
    </head>
    <body>
		<div id="encabezado">
			<center><h1>SinObsolescencia</h1></center>
		</div>
		<div>
            <fieldset>
                <legend>Voluntarios registrados:</legend>
                <table>
					<tr>
						<th>Login</th>
						<th>Email</th>
					</tr>
					<?php
						try {
							// Pasamos el resultado a una variable
							$usuarios = $cliente->getVoluntarios();
							if($usuarios){
								foreach ($usuarios as $value) {            
									echo "<tr>";
									echo "<td>".$value['login']."</td>";
									echo "<td>".$value['email']."</td>";
									echo "</tr>";          
								}
							}
						} catch(Exception $ex) { 
							die($ex->getMessage());
						}
					?>
				</table>
            </fieldset>
        </div>
        
		<br><br>
		<div>
            <fieldset>
                <legend>Anuncios públicos:</legend>
				<?php
				
				// Pasamos el resultado a una variable
				$anuncios = $cliente->getAnunciosPublicos();
				
				if($anuncios){
                echo "<table>";
				echo "<tr>";
					echo "<th>Fecha</th>";
					echo "<th>Contenido</th>";
					echo "</tr>";
					try {
						
			
						foreach ($anuncios as $value) {            
							echo "<tr>";
							echo "<td>".$value['fecha']."</td>";
							echo "<td>".$value['contenido']."</td>";
							echo "</tr>";          
						}
					} catch(Exception $ex) { 
						die($ex->getMessage());
					}	
					
				echo "</table>";
				
				}else{
					echo 'No existen anuncios públicos que mostrar';	
				}				
				?>
			</fieldset>
		</div>
		<br><br>
		
		<?php
		// Si se pulsa sobre enviar
		if (isset($_POST['enviar'])) {
			
			// Pasamos el valor de usuario a una variable
			$loginUsuario = $_POST['usuario'];
			try {
							
				// Pasamos el resultado a una variable
				$tipoAnuncios = $cliente->getParticipacionVoluntarios($loginUsuario);
				
				// Si la variable contiene datos
				if(count($tipoAnuncios) > 0){
					
					// Recorremos los tipos de anuncios y los vamos sumando según sean
					foreach ($tipoAnuncios as $value) {
						if($value['privado'] == 0){
							$publicos++;
						} else if($value['privado'] == 1){
							$privados++;
						}
					}
					
				}else{
					$error = "El usuario introducido no tiene anuncios o no existe.";
				}
			} catch(Exception $ex) {
				//Se obtienen los mensajes de error y se para la ejecución
				die($ex->getMessage());
			}
		}
		?>	
		
		<div>
            <fieldset>
                <legend>Consulta de participación:</legend>
				<form action='cliente.php' method='post'>
					<label for='usuario'>Usuario a consultar:</label>
					<input type='text' name='usuario' id='usuario' maxlength="50" /><br/>
					<input type='submit' name='enviar' value='Consulta participación' />   
				</form>
				<br>
				<?php 
				if($error == "" && isset($loginUsuario)){
					echo "<table width='300'>";
					echo "<caption >Participación del voluntario <strong>$loginUsuario</strong> :</caption>";
					echo "<tr>";
						echo "<th colspan='2'>Públicos</th>";
						echo "<th colspan='2'>$publicos</th>";
					echo "</tr>";
					echo "<tr>";
						echo "<th colspan='2'>Privados</th>";
						echo "<th colspan='2'>$privados</th>";
					echo "</tr>";			
					echo "</table>";
				
				}else{
					echo $error;
					$error = "";
				}
				?>				
			</fieldset>
		</div>
		
		<footer id="pie">
            <center><b><h2>Rubén Ángel Rodriguez Leyva</h2></b></center> 
        </footer>
    </body>
</html>
