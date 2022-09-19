<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class valida_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_Validacion','valida');
    }

    public function index_get(){
        $datos = $this->valida->getUsers();
        $this->response($datos);    
    }
    public function index_post(){
        $correo = $this->input->post("correo");
		$codigoGenerado = $this->input->post("codigogenerado");
        $passw = $this->input->post("contrasenia");

        $contrasenia = bin2hex($passw);

        $data = array(
            "correo"=>$correo,
            "contrasenia"=>$contrasenia
        );
        
        if($this->valida->verifica_existencia($codigoGenerado) && $this->valida->verifica_existencia2($correo)){
            if($this->valida->verifica_existencia3($correo)){
                $res = array (
                    'status' => 400,
                    'data' => $this->valida->obtiene_existencia($codigoGenerado),
                    'comentario' => "existe"
                ); 
            }else{
                $datos = $this->valida->save($data);
                $res['status'] = 201;
                $res['message'] = 'Registro Insertado';
            }
           
            
        }else{ 
            
           if($datos) {
            $res['status'] = 201;
            $res['message'] = 'Registro Insertado';
            
            } else {
                $res['status'] = 400;
                $res['message'] = 'insert failed';
            
            }
        }
        $this-> response($res,200);		
    }

}