<?php
    class User
    {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }
    
        # encontrar el usuario en la base de datos
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
    
            $row = $this->db->single();
    
            // Check row
            if ($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        # registrar usuario
        public function register($data){
            $this->db->query('INSERT INTO users (email, name, password) VALUES(:email, :name, :password)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':password', $data['password']);

            # dependiendo si todo sale bien, retorno true o false
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function login($email, $password){
            # selecciono la fila completa con los datos
            # en este punto, el email ya esta verificado
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashedPassword = $row->password;

            # comparar la pass en texto plano con la que esta en la db 
            if (password_verify($password, $hashedPassword)) {
                # retorno los datos de sesion
                return $row;
            } else {
                # retorno falso en caso de datos incorrectos
                return false;
            }
        }

        public function getUserById($id){
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $id);
    
            $row = $this->db->single();

            return $row;
        }

        public function getUserByEmail($email){
            $this->db->query('SELECT users.id FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            return $row;
        }

        public function updateSettings($data){
            
            $this->db->query('UPDATE users_image SET path = :path WHERE user_id = :id; 
            UPDATE users_settings SET timezone = :timezone, gender = :gender, display_name = :display_name WHERE user_id = :user_id');

            $this->db->bind(':path', $data['image_name']);
            $this->db->bind(':id', $data['user_id']);
            $this->db->bind(':timezone', $data['timezone']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':display_name', $data['display_name']);
            $this->db->bind(':user_id', $data['user_id']);

            # dependiendo si todo sale bien, retorno true o false
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getUserSettings($id){
            $this->db->query('SELECT users.name, users.created_at, users_image.path FROM users INNER JOIN users_image ON users.id = users_image.user_id WHERE users.id = '.$id.'');
            $this->db->bind(':id', $id);
            $row = $this->db->single();

            return $row;
        }

        public function recoverPassword($data = []){
            $this->db->query('INSERT INTO password_recovery SET user_id = :user_id, recovery_key = :token');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':token', $data['token']);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }

        
        }

        public function validateToken($token = ''){
            $this->db->query('SELECT user_id, recovery_key FROM password_recovery WHERE recovery_key = :token');
            $this->db->bind(':token', $token);
            $row = $this->db->single();

            return $row;
        }

        public function updatePassword($data = []){
            $this->db->query('UPDATE users SET password = :password WHERE users.id = :id_user ; DELETE FROM password_recovery WHERE password_recovery.user_id = :user_id');
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':id_user', $data['user_id']);
            $this->db->bind(':user_id', $data['user_id']);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
    }
?>