<?php
    /*
    * App core class
    * Crea URL's y carga el core controller
    * De manera dinamica carga controladores
    * Formato de url: /controllers/method/params
    */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __CONSTRUCT(){
            //print_r($this->getUrl());

            $url = $this->getURL();

            # Buscar dentro de "controllers" el primer valor del arreglo de url
            # primer valor sera el nombre del controller
            # segundo el metodo
            # tercero en adelante los parametros
            if (file_exists('../app/controllers/'. ucwords($url[0]). '.php')) {
                # si existe, lo seteo como controller 
                $this->currentController = ucwords($url[0]);
                # elimino el primer valor del arreglo (aun no se para que)
                unset($url[0]);
            }

            # llamar al controller
            require_once('../app/controllers/' . $this->currentController . '.php');

            # instancear el controller
            # se veria algo como Pages = new Pages o post = new Post
            $this->currentController = new $this->currentController;

            # chequear la segunda parte/indice 1 del arreglo "url"
            if (isset($url[1])) {
                if (method_exists($this->currentController, $url[1])) {
                    # seteo la propiedad con el metodo que viene de la url
                    $this->currentMethod = $url[1];
                    # eliminar index 1
                    unset($url[1]);
                }                
            }

            # paso los parametros que vienen desde la url
            $this->params = $url ? array_values($url) : [];
            
            # callback: llamar a un metodo como un string
            # def2: "posibilidad de ejecutar una función a partir de una variable cuyo contenido es el nombre de la función. 
            # Una función que es ejecutada de esta forma se denomina función “callback”.
            # en este caso llamo a la clase y metodo seleccionado y le envio los parametros
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        # tomamos el parametro "url" ya que en el .htaccess de public lo definimos
        # con ese nombre
        public function getUrl(){
            if (isset($_GET['url'])) {
                # eliminar el "/" al final del string
                $url = rtrim($_GET['url'], '/');
                # elimino los caracteres que una url no debe tener
                $url = filter_var($url, FILTER_SANITIZE_URL);
                # convierto la url en un array, eliminando los "/"
                $url = explode('/',$url);
                return $url;
            }
        }
        
    }

    ?>
    