<?php
    class User {

        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function get_single_user($email) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $this->db->query($sql);
            $this->db->bind(':email', $email);
            return $this->db->single();
        }

        public function login($email, $password) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $this->db->bind(':email', $email);
            $user = $this->db->single();
            $hash_password = $user->password;

            if(password_verify($password, $hash_password)) {
                return $user;
            } else {
                return false;
            }
        }
        
        public function insert_user($data) {
            $sql = "INSERT INTO users (firstname, lastname, about_user, user_image, email, password, role, created_at) VALUES (:fname, :lname, :about, :user_image, :email, :password, :role, :date)";

            $this->db->query($sql);
            $this->db->bind(":fname", $data['fname']);
            $this->db->bind(":lname", $data['lname']);
            $this->db->bind(":about", $data['about']);
            $this->db->bind(":user_image", $data['auther_img']);
            $this->db->bind(":email", $data['email']);
            $this->db->bind(":password", $data['password']);
            $this->db->bind(":role", $data['role']);
            $this->db->bind(":date", time());
            $this->db->execute();
        }

        public function password_update($email, $new_password) {
            $sql = "UPDATE users SET password = :new_password WHERE email = :email";

            $this->db->query($sql);
            $this->db->bind(":new_password", $new_password);
            $this->db->bind(":email", $email);
            $this->db->execute();
        }

        public function insert_psw_token($data) {
            $sql = "INSERT INTO forgot_password (email, token, token_created_at) VALUES (:email, :token, :date)";

            $this->db->query($sql);
            $this->db->bind(":email", $data['email']);
            $this->db->bind(":token", $data['token']);
            $this->db->bind(":date", time());
            $this->db->execute();
        }

        public function get_token($token) {
            $sql = "SELECT * FROM forgot_password WHERE token = :token";

            $this->db->query($sql);
            $this->db->bind(":token", $token);
            return $this->db->single();
        }

        public function delete_token($token) {
            $sql = "DELETE FROM forgot_password WHERE token = :token";

            $this->db->query($sql);
            $this->db->bind(":token", $token);
            $this->db->execute();
        }
    }