<?php
$arrayRutas =explode("/", $_SERVER['REQUEST_URI']);
//echo $_SERVER['REQUEST_URI'];
//echo "<pre>";print_r($arrayRutas);echo "<pre>";

// array_filter($arrayRutas) -> Elimina los elementos vacios de un array
// count() -> Devuelve el numero de elementos de un array
// Si el array tiene 3 elementos, significa que se esta pasando un parametro por la URL
// Si el array tiene 2 elementos, significa que no se esta pasando ningun parametro por la URL
if (count(array_filter($arrayRutas)) == 3){
    

    $json = array(
        "detalle" => "No encontrado",
    );
    echo json_encode($json, true);
    return;
}
// Si el array tiene 4 elementos, significa que se esta pasando un parametro por la URL
if (count(array_filter($arrayRutas)) == 4){
    // Si el cuarto elemento de la URL es igual a cursos
    if(array_filter($arrayRutas)[4] == 'cursos'){
        // Petición POST
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){// Se evalua si se esta enviando un POST
            $cursos = new ControladorCursos();
            $cursos -> create();
           
        }
        // Petición GET
        elseif(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET'){
            $cursos = new ControladorCursos();
            $cursos -> index();
    
        }
       
    }
    // Si el cuarto elemento de la URL es igual a registro
    if(array_filter($arrayRutas)[4] == 'registro'){
        // Petición GET
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER['REQUEST_METHOD']=='GET'){
            $clientes = new Clientes();
            $clientes -> index();
        }
        // Petición POST
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
            
            $datos =array(  "nombre"=> $_POST['nombre'],
                            "apellido"=> $_POST['apellido'],
                            "email"=> $_POST['email'],);
            //echo "<pre>";print_r($datos);echo "<pre>";

            $clientes = new Clientes();
            $clientes -> create($datos);
        }
        
    }

    
}else{
    // Si el cuarto elemento de la URL es igual a cursos y el quinto elemento es un numero
    if(array_filter($arrayRutas)[4]=="cursos" && is_numeric(array_filter($arrayRutas)[5]) ){
        // Petición GET
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET'){
            $cursos = new ControladorCursos();
            $cursos -> show(array_filter($arrayRutas)[5]);
        }
        // Petición PUT
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='PUT'){
            $editarCurso = new ControladorCursos();
            $editarCurso -> update(array_filter($arrayRutas)[5]);
        }
        // Petición DELETE
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='DELETE'){
            $eliminarCurso = new ControladorCursos();
            $eliminarCurso -> delete(array_filter($arrayRutas)[5]);

        }
    }

}

?>
