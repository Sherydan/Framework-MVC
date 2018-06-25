<?php
class Controller{
    /* 
     * Controlador base
     * permite cargar modelos y vistas
     */

    # function model es llamada desde el controlador default pages
    # de esta manera, pages puede llamar un modelo
    public function model($model){
        # cargar el modelo
        require_once('../app/models/'. $model . '.php');

        # instancear el modelo
        return new $model();
    }
    
    # function view es llamada desde el controlador default pages
    # permite cargar una vista y pasarle datos
    public function view($view, $data = []){
        # chequear si existe la vista
        if (file_exists('../app/views/'. $view . '.php')) {
            require_once('../app/views/'. $view . '.php');

        } else {
            die('View not found');
        }
    }
}

?>