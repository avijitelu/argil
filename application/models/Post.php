<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getPost() {
            $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE post_status = :post_status ORDER BY post_created_at DESC";
            $this->db->query($sql);
            $this->db->bind(":post_status", 1);
            return $this->db->resultSet();
        }

        public function popular_post() {
            $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE post_status = :post_status ORDER BY views DESC LIMIT 5";
            $this->db->query($sql);
            $this->db->bind(":post_status", 1);
            return $this->db->resultSet();
        }

        public function latest_posts() {
            $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE post_status = :post_status ORDER BY post_id DESC LIMIT 7";
            $this->db->query($sql);
            $this->db->bind(":post_status", 1);
            return $this->db->resultSet();
        }

        public function get_post_by_id($id) {
            $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE post_id = :id";
            $this->db->query($sql);
            $this->db->bind(":id", $id);
            return $this->db->single();
        }

        public function increase_view_count($id, $views) {
            // Increase the views count
            $view_count = $views + 1;

            $sql_update = "UPDATE posts SET views = :view_count WHERE post_id = :id";
            $this->db->query($sql_update);
            $this->db->bind(":view_count", $view_count);
            $this->db->bind(":id", $id);
            $this->db->execute();
        }

        public function insert_post($data) {
            $sql = "INSERT INTO posts (user_id, title, body, post_status, post_image, slug, post_created_at) VALUES (:id, :title, :body, :post_status, :post_image, :slug, :date)";
            $this->db->query($sql);
            $this->db->bind(":id", $_SESSION['user_id']);
            $this->db->bind(":title", $data['title']);
            $this->db->bind(":body", $data['body']);
            $this->db->bind(":post_status", 0);
            $this->db->bind(":post_image", $data['blog_image']);
            $this->db->bind(":slug", $data['slug']);
            $this->db->bind(":date", time());
            $this->db->execute();
        }
    }