<?php

/**
 * Clase funciones
 * 
 * Desarrollo Web en Entorno Servidor
 * Tema 5: Servicios web
 * Tarea 5
 * @author RubenRL
*/

class funciones {
    
    /**
     * Método público encargado de crear la conexión a la base de datos.
     * 
     * @return \PDO El objeto de la conexión
     */
	 
    public function accesoBD(){
        
        $localhost = "localhost"; // El localhost
        $nombreBD = "voluntarios3"; // Nombre de la DB
        $usuario = "dwes"; // Nombre del usuario de ls BD
        $clave = "dwes"; // Clave del usuarion de la BD
        
        try{
        
            $conexion = new PDO('mysql:host='.$localhost.'; dbname='.$nombreBD, $usuario, $clave);
            $conexion->exec("set names utf-8");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conexion; // Devolvemos la conexión.
            
        // en caso de que se produzca una excepción la controlamos.    
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
    
    /**
     * Método público que se encarga de recoger los diferentes voluntarios
     * que hay en la base de datos.
     * 
     * @return boolean devolvemos un booleano o un array
     */
	 
    public function getVoluntarios(){
        
        try{
            
            $conexion = self::accesoBD(); // Conectamos con la base de datos.
            $sql = "SELECT login, email FROM anunciantes"; // Creamos la consulta
            $consulta = $conexion->prepare($sql); // Preparamos la consulta
			$consulta->execute(); // Ejecutamos la consulta
			
            if(count($consulta) > 0){
                return $consulta->fetchAll();
            }else{
                return false;
            }
            
        // en caso de que se produzca una excepción la controlamos.    
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
	
	
	/**
     * Método público que se encarga de recoger los diferentes anuncios de tipo publico
     * que hay en la base de datos.
     * 
     * @return boolean devolvemos un booleano o un array
     */
	 
	public function getAnunciosPublicos(){
        
        try{
            
            $conexion = self::accesoBD(); // Conectamos con la base de datos.
            $sql = "SELECT fecha, contenido FROM anuncios WHERE privado='0'"; // Creamos la consulta
            $consulta = $conexion->prepare($sql); // Preparamos la consulta
            $consulta->execute(); // Ejecutamos la consulta
			
            if(count($consulta) > 0){
                return $consulta->fetchAll();
            }else{
                return false;
            }
            
        // en caso de que se produzca una excepción la controlamos.    
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
	
	/**
     * Método público que se encarga de recoger los diferentes voluntarios
     * que hay en la base de datos.
	 *
     * @param type $loginUsuario el login del usuario
     * @return boolean devolvemos un booleano o un array
     */
	 
	public function getParticipacionVoluntarios($loginUsuario){
        
        try{
            
            $conexion = self::accesoBD(); // Conectamos con la base de datos.
            $sql = "SELECT autor, privado FROM anuncios WHERE autor=:loginUsuario"; // Creamos la consulta
            $consulta = $conexion->prepare($sql); // Preparamos la consulta
			$consulta->bindParam(":loginUsuario", $loginUsuario);
            $consulta->execute(); // Ejecutamos la consulta
			
			if(count($consulta) > 0){
                return $consulta->fetchAll();
            }else{
                return false;
            }
            
        // en caso de que se produzca una excepción la controlamos.    
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
