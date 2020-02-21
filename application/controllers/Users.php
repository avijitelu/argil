<?php
    
    class Users extends Controller {

        protected $userModel;

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function index() {
            redirect("/users/login");
        }

        public function signup() {
            $data = [];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $fname = trim($_POST['firstname']);
                $lname = trim($_POST['lastname']);
                $email = trim($_POST['email']);
                $about = trim($_POST['about']);

                $auther_img = $_FILES['auther_image']['name'];
                $file_temp = $_FILES['auther_image']['tmp_name'];
                $file_size = $_FILES['auther_image']['size'];

                $target_dir = IMAGE_PATH . "/users/";
                $file_ext = strtolower(end(explode('.', $auther_img)));
                $img_name = strtolower($fname) . "-" . strtolower($lname) . "-" . mt_rand() .  "." . $file_ext;
                $target_file = $target_dir . $img_name;
                $expension = array('jpeg', 'jpg', 'png');

                $password = htmlspecialchars($_POST['password']);

                $hash_psw = password_hash($password, PASSWORD_DEFAULT);

                $user_data = $this->userModel->get_single_user($email);
                $err = [];

                if($user_data->email == $email) {
                    $err['email'] = "This email is already exist try with another one";
                }

                if(in_array($file_ext, $expension) == false) {
                    $err['img_ext'] = "The file extension must be jpeg, jpg or png";
                }

                if($file_size > 2097152) {
                    $err['size'] = 'File size must not exceed 2 MB';
                }

                $data = [
                    'fname'         =>  $fname,
                    'lname'         =>  $lname,
                    'email'         =>  $email,
                    'password'      =>  $hash_psw,
                    'about'         =>  $about,
                    'role'          =>  "auther",
                    'auther_img'    =>  $img_name,
                    'err'           =>  $err,
                    'ext'           => $file_ext
                ];

                if(empty($err)) {
                    move_uploaded_file($file_temp, $target_file);
                    $this->userModel->insert_user($data);
                    $_SESSION['register_success'] = "You have successfully Register";
                    $data['register_msg'] = $_SESSION['register_success'];
                    redirect('/users/login');
                }
            }

            echo Twig::getInstance()->render('/user/signup.html', $data);
        }

        public function login() {
            $data = [
                'email'             => "",
                'password'          => "",
                'error_email'       => "",
                'error_password'    => "",
                'register_msg'      => ""
            ];

            if(!empty($_SESSION['register_success'])){
                $data['register_msg'] = $_SESSION['register_success'];
                unset($_SESSION['register_success']);
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data['email'] = $_POST['email'];
                $data['password'] = $_POST['password'];

                if($this->userModel->get_single_user($data['email'])){
                    //user found
                    $logged_in_user = $this->userModel->login($data['email'], $data['password']);

                    if($logged_in_user) {
                        create_user_session($logged_in_user);
                        redirect('/');
                    } else {
                        $data['error_password'] = "Incorrect password";
                    }
                } else {
                    $data['error_email'] = "Email not found";
                }
            }
            echo Twig::getInstance()->render('/user/login.html', $data);
        }

        public function logout() {
            session_unset();
            session_destroy();
            redirect('/users/login');
        }

        public function forgotpassword() {
            $data = [];
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $email = $_POST['email'];
                $row = $this->userModel->get_single_user($email);

                if(!empty($row)) {
                    $token = sha1(uniqid($email, true));
                    $token_data = [
                        "token"     =>  $token,
                        "email"     =>  $email
                    ];

                    $data = [
                        "message"   =>  "A password reset link is send to your registered email                         address. Please check your email."
                    ];

                    $this->userModel->insert_psw_token($token_data);

                    $url = URLROOT . "/users/resetpassword/" . $token;
                    $header = "From: Argil <noreply@argil.in>";

                    mail($email, "Password Reset Link", $url, $header);
                    echo Twig::getInstance()->render('/user/blank.html', $data);
                    exit();

                } else {
                    $data['register_msg'] = "This email is not register";
                }
            }
            

            echo Twig::getInstance()->render('/user/forgotpassword.html', $data);
        }

        public function resetpassword($token = null) {
            $data = [];

            $token_data = $this->userModel->get_token($token);

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $new_password = htmlspecialchars($_POST['new_password']);
                $password = password_hash($new_password, PASSWORD_DEFAULT);

                $this->userModel->password_update($token_data->email, $password);
                $this->userModel->delete_token($token);

                $data = [
                    "message"   =>  "You have successfully changed your password. Please login with                     your new credentials."
                ];

                echo Twig::getInstance()->render('/user/blank.html', $data);
                exit();
            }
            
            if(!empty($token_data)) {
                $second = $token_data->token_created_at;
                $email = $token_data->email;
                $sec_diff = time() - $second;
                $data = [
                    "token"     => $token
                ];

                if($sec_diff >= 3600) {
                    $data = [
                        "message"   =>  "The password reset link is no longer valid. Please request                     another password reset email from the login page."
                    ];

                    $this->userModel->delete_token($token);
                    echo Twig::getInstance()->render('/user/blank.html', $data);
                    exit();
                }

            } else {
                echo Twig::getInstance()->render('/common/404.html', $data);
                exit();
            }
            echo Twig::getInstance()->render('/user/resetpassword.html', $data);
        }
    }