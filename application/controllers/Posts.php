<?php
    class Posts extends Controller {
        public function __construct() {
            $this->postModel = $this->model('Post');
        }

        public function index($page = "page=1") {
            // Separate page no, 1-Index contain page no
            $page_param_array = explode("=", $page);
            $current_page = $page_param_array[1];
            $post_perpage = 10;
            $start = ( $current_page * $post_perpage ) - $post_perpage;

            // Get posts form the database
            $posts = $this->postModel->getPost();
            // Decode the htmlentities of the post body form the database
            foreach ($posts as $value) {
                $value->body = htmlspecialchars_decode($value->body); 
            }

            $popular_posts = $this->postModel->popular_post();
            $latest_posts = $this->postModel->latest_posts();

            $no_of_post = count($posts);
            $no_of_pages = ceil( $no_of_post / 10 );

            if($current_page > $no_of_pages) {
                $current_page = $no_of_pages;
                redirect('/posts/index/page=' . $current_page);
            }
            
            $data = [
                'posts'         => $posts,
                'page_no'       => $current_page,
                'start'         => $start,
                'no_of_pages'   => $no_of_pages,
                'popular_posts'  => $popular_posts,
                'latest_posts'  => $latest_posts
            ];
            echo Twig::getInstance()->render('/home/index.html', $data);
        }

        /**
         * This controller method used to create new post
         */
        public function addpost() {
            if(empty($_SESSION['user_id'])) {
                redirect('/users/login');
                exit();
            }

            // Fetch popular post & latest post for showing in this page
            $popular_posts = $this->postModel->popular_post();
            $latest_posts = $this->postModel->latest_posts();

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $title = trim(htmlspecialchars($_POST["blog_title"]));
                $body = trim(htmlspecialchars($_POST["blog_body"]));
                
                $file_name = $_FILES['blog_image']['name'];
                $file_temp = $_FILES['blog_image']['tmp_name'];
                $file_size = $_FILES['blog_image']['size'];

                $target_dir = IMAGE_PATH . "/blog/";
                $name = strtolower(str_replace(" ", "-", $title));

                // Remove Single and double qoute from a string
                $name = preg_replace("/&#?[a-z0-9]+;/i","",$name);
                $file_ext = strtolower(end(explode('.', $file_name)));
                $name_img = strtolower($_SESSION['fname']) . "-" . strtolower($_SESSION['lname']) . "-" . mt_rand() . "." . $file_ext;
                $target_file = $target_dir . $name_img;
                
                $expensions = array('jpeg', 'jpg', 'png');

                $error = [];

                if(in_array($file_ext, $expensions) == false) {
                    $error[] = "The file extension must be jpeg, jpg or png";
                }
                
                if($file_size > 2097152) {
                    $error[] ='File size should be less than 2MB';
                }
                
                // True if there is no error
                if(empty($error)) {
                    // Data send to the model to store in the database
                    $data_model = [
                        'title' => $title,
                        'body' => $body,
                        'blog_image' => $name_img,
                        'slug' => $name
                    ];

                    move_uploaded_file($file_temp, $target_file);
                    $this->postModel->insert_post($data_model);
                }
                
                // If user made a POST request then this data will send to the view
                $data = [
                    'error' => $error,
                    'popular_posts'  => $popular_posts,
                    'latest_posts'  => $latest_posts
                ];

            } else {
                // Otherwise this data will send to the view
                $data = [
                    'popular_posts'  => $popular_posts,
                    'latest_posts'  => $latest_posts
                ];
            }
            
            echo Twig::getInstance()->render('/home/newpost.html', $data);
        }

        public function fullpost($param) {
            // Convert the string into array
            $param_array = explode('-', $param);
            // 0-index in the post id
            $post_id = $param_array[0];

            $popular_posts = $this->postModel->popular_post();
            $latest_posts = $this->postModel->latest_posts();

            $post = $this->postModel->get_post_by_id($post_id);

            // This is true when ajax hit is happend in this method
            // url last character is end with 1
            if(end($param_array) == 1) {
                $this->postModel->increase_view_count($post_id, $post->views);
                echo "done";
                exit();
            }

            $post->body = htmlspecialchars_decode($post->body);

            $data = [
                'post'          => $post,
                'popular_posts' => $popular_posts,
                'latest_posts' => $latest_posts
            ];

            echo Twig::getInstance()->render('/home/fullpost.html', $data);
        }
    }