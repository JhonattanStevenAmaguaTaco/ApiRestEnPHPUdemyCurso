<?php 

    class ControladorCursos{
        public function index(){
            $clientes = ModeloClientes::index("clientes");
            if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
                foreach ($clientes as $key =>$value){
                    if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) ==
                     base64_encode($value["id_cliente"].":".$value["llave_secreta"])){
                        $arryaCursos = ModeloCursos::index("cursos");
                        $json = array(
                            "detalle" =>  $arryaCursos
                        );
                        echo json_encode($json, true);
                        return;
                     }
                }
            }
           
        }
        public function create(){
            echo "Estas en la vista cursos con POST";
            

        }
        public function show($id){
            $json = array(
                "detalle" => "Estas en la vista cursos con GET y el id es:  ".$id
            );
            echo json_encode($json, true);
            return;
        }
        public function update($id){
            echo "Estas en la vista cursos con PUT y el id es:  ".$id;
        }
        public function delete($id){
            echo "Estas en la vista cursos con DELETE y el id es:  ".$id;
        }
            
        

    }


   


?>