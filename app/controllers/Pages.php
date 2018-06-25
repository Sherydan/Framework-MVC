<?php
# Pages es el controlador default
class Pages extends Controller{
    
    public function __CONSTRUCT(){
        # creo la propiedad postModel y llamo a la funcion model
        # la cual busca el modelo dentro de la carpeta y lo instancea
        # $this->postModel = $this->model('Post');
    }

     # como extendi Controller, puedo llamar a los emtodos view y model
    # al cargarse la funcion index (que se determina en la url)
    # esta funcion al mismo tiempo carga la vista junto con sus datos
    public function index(){
        $data = ['title' => 'Luis MVC'];
        $this->view('pages/index', $data);
        
    }

    # funcion about, se llama desde el core haciendo un callback
    public function about(){
        $data = ['title' => 'About Us'];
        $this->view('pages/about', $data);
    }
    
   
}
?>