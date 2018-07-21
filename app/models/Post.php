<?php
    class Post{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getPosts(){
            /* 
             * debo usar alias, ya que ambas tablas tienen campos 
             * con el mismo nombre, de esta manera
             * el resultado me retorna campos facilmente distingibles el uno de otro
             */
            $this->db->query('SELECT *, 
                            posts.id as postId, 
                            users.id as userId, 
                            posts.created_at as  postCreatedAt,
                            users.created_at as userCreatedAt 
                            FROM posts INNER JOIN users 
                            ON posts.user_id = users.id 
                            ORDER BY posts.created_at DESC');
                        

            $results = $this->db->resultSet();

            return $results;
        }

        public function addPost($data){
            $this->db->query('INSERT INTO posts (title, body, user_Id) VALUES(:title, :body, :user_id)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':user_id', $data['user_id']);

            # dependiendo si todo sale bien, retorno true o false
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }


        public function showPostById($id){
            $this->db->query('SELECT * FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;

        }

        public function editPost($data){
            $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':id', $data['id']);
            

            # dependiendo si todo sale bien, retorno true o false
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function deletePost($id){
            $this->db->query('DELETE FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
    
            # dependiendo si todo sale bien, retorno true o false 
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getPostsByUser($id){
            $this->db->query('SELECT * FROM posts WHERE posts.user_id = :id');
            $this->db->bind(':id', $id);
            $posts = [];
            if ($this->db->execute()) {
                $posts = $this->db->resultSet();
                return $posts;
            }

            return $posts;
        }
    }

?>