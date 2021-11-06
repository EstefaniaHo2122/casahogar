<?php

namespace App\Controllers;
//Se importa el modelo de datos
use App\Models\AnimalModelo;

class Animales extends BaseController
{
    public function index(){
        return view('registroAnimal');
    }
    public function registrar (){
        // recibo los datos enviados desde el formulario(desde la vista)
        //Lo que tengo dentro de getPost("") es el name que puse en cada input
        $nombre=$this->request->getPost("nombre");
        $edad=$this->request->getPost("edad");       
        $descripcion=$this->request->getPost("descripcion");
        $tipo=$this->request->getPost("tipo");
        print_r($nombre);
        if($this->validate('animal')){
        //Crear un arreglo asociativo con los datos del punto 1
        $datos=array(
            "nombre"=>$nombre,
            "edad"=>$edad,            
            "descripcion"=>$descripcion,
            "tipo"=>$tipo
        );
        //4. intentamos grabar los datos en BD
        try{
           
            $modelo=new AnimalModelo();
            $modelo->insert($datos);
            return redirect()->to(site_url('/animales/registro'))->with('mensaje',"El registro fue exitoso");


        }catch(\Exception $error){
            return redirect()->to(site_url('/animales/registro'))->with('mensaje',$error->getMessage());
        }

        }else{
        $mensaje="tienes datos pendientes";
        return redirect()->to(site_url('/animales/registro'))->with('mensaje',$mensaje);
        }        
    }

    public function buscar(){
        try{
            $modelo=new AnimalModelo();
            $resultado=$modelo->findAll();
            $animales=array('animales'=>$resultado);
            return view('listaAnimales',$animales);
        }catch(\Exception $error){
            return redirect()->to(site_url('/animales/registro'))->with('mensaje',"sara".$error->getMessage());
        }
   }

    public function eliminar($id){

       try{
        $modelo=new AnimalModelo();
        $modelo->where('id',$id)->delete();
        return redirect()->to(site_url('/animales/registro'))->with('mensaje',"Eliminaciòn exitosa");
        }catch(\Exception $error){
            return redirect()->to(site_url('/animales/registro'))->with('mensaje',$error->getMessage());

        }
    }
    public function editar($id){
        $nombre=$this->request->getPost("nombre");
        $edad=$this->request->getPost("edad");       
        $descripcion=$this->request->getPost("descripcion");
        $tipo=$this->request->getPost("tipo");
        //validacion de dato

            if($this->validate('animal')){
                //organizar datos en un array asociativo
                $datos = array(
                    'nombre'=>$nombre,
                    'edad'=>$edad,
                    'descripcion'=>$descripcion,
                    'tipo'=>$tipo
                );
                //crear un objeto del modelo
                try {
                    $modelo=new AnimalModelo();
                    $modelo->update($id,$datos);
                    return redirect()->to(site_url('/animales/registro'))->with('mensaje',"Se edito de manera correcta");
                }catch(\Exception $error){
                    return redirect()->to(site_url('/animales/registro'))->with('mensaje',$error -> getMenssage());
                }
            }else{
            
            }
        }
}