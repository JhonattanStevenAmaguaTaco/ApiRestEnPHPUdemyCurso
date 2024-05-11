<?php
    class Clientes {
        public function index(){
            $json = array(
                "detalle" => "Estas en la vista de registro con Get"
            );
            echo json_encode($json, true);
            return;
        }

        public function create($datos){
            //echo "<pre>";print_r($datos);echo "<pre>";
            if(isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos['nombre'])){
                $json = array(
                    "status"=>404,
                    "detalle" => "Error en el nombre del cliente, solo se aceptan letras"
                );

                echo json_encode($json, true);
                return;
            }
            if(isset($datos['apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos['apellido'])){
                $json = array(
                    "status"=>404,
                    "detalle" => "Error en el apellido del cliente, solo se aceptan letras"
                );

                echo json_encode($json, true);
                return;
            }
            if(isset($datos['email']) && !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/', $datos['email'])){
                $json = array(
                    "status"=>404,
                    "detalle" => "Error en formato de email del cliente, solo se aceptan letras, numeros y los caracteres especiales . _ -"
                );

                echo json_encode($json, true);
                return;
            }

            //validar email repetido
            $clientes= ModeloClientes::index("clientes");
           // echo "<pre>";print_r($clientes);echo "<pre>";
           foreach ($clientes as $key => $value) {
                if($value['email']==$datos['email']){
                    $json = array(
                        "status"=>404,
                        "detalle" => "Error, el email ya existe en la base de datos"
                    );
                    echo json_encode($json, true);
                    return;
                }
                
           }
            

            // Generar Credenciales del cliente

            $id_cliente=str_replace("$","c",crypt($datos['nombre'].$datos['apellido'].$datos['email'], '$2a$07$usesomesillystringforsalt$'));
           // echo "<pre>";print_r($id_cliente);echo "<pre>";
            $llave_secreta=str_replace("$","a",crypt($datos['email'].$datos['apellido'].$datos['nombre'], '$2a$07$usesomesillystringforsalt$'));
           // echo "<pre>";print_r($llave_secreta);echo "<pre>";
            $datos = array(
                "nombre"=>$datos['nombre'],
                "apellido"=>$datos['apellido'],
                "email"=>$datos['email'],
                "id_cliente"=>$id_cliente,
                "llave_secreta"=>$llave_secreta,
                "create_at" => date('Y-m-d H:i:s'),
                "update_at" => date('Y-m-d H:i:s')
            );
        $crearRegistro = ModeloClientes::create("clientes",$datos);
        
        if ($crearRegistro == "ok"){
            $json = array(
                "status"=>200,
                "detalle" => "Registro exitoso, sus credenciales son: id_cliente: $id_cliente, llave_secreta: $llave_secreta"
            );
            echo json_encode($json, true);
            return;
        }

    }

    }
?>
