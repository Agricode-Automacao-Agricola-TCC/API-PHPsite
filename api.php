<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
  
    // $con = new mysqli('localhost','root','','agricode');
    $con = new mysqli('localhost','arduino','arduino','agricode');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        // Pegando as informações do banco de dados
        if(isset($_GET['id'])){  
            // Este If é usado, caso de passagem de ID
            $id = $_GET['id'];
            $sql = $con->query("select * from cliente where id='$id'");
            $data = $sql->fetch_assoc();
        }else{
            // Entra nesse, caso não tenha passagem de ID via "get"
            $data = array();
            $sql = $con->query("select * from cliente");
            while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
        }
        exit(json_encode($data));
    }   
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        // alterar informações
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $data = json_decode(file_get_contents("php://input"));
            $sql = $con->query("update cliente set 
               nome = '".$data->nome."', 
                senha = '".$data->senha."', 
                email = '".$data->email."', 
                dtnasc = '".$data->dtnasc."', 
                usuario = '".$data->usuario ."',               
                ss_temp = '".$data->ss_temp."',  
                ss_umidade = '".$data->ss_umidade."',  
                ss_chuva = '".$data->ss_chuva."',  
                ss_nivelagua = '".$data->ss_nivelagua."',  
                ss_chamas = '".$data->ss_chamas."',  
                bomba_agua = '".$data->bomba_agua."'

                where id = '$id'");
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
        }

    } 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // gravar informações
        $data = json_decode(file_get_contents("php://input"));
        $sql = $con->query("insert into cliente (nome, senha, email, dtnasc, usuario, ss_temp, ss_umidade, ss_chuva, ss_nivelagua, ss_chamas, bomba_agua) values ('".$data->nome."','".$data->senha."','".$data->email."','".$data->dtnasc."','".$data->usuario."','".$data->ss_temp."','".$data->ss_umidade."','".$data->ss_chuva."','".$data->ss_nivelagua."','".$data->ss_chamas."','".$data->bomba_agua."')");
        if($sql){
            $data->id = $con->insert_id;
            exit(json_encode($data));
        }else{
            exit(json_decode(array('status' => 'Não Funcionou')));
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        // apagar informações do banco
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = $con->query("delete from cliente where id='$id'");
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não funcinou')));
            }
        }
    }
   
    
?>