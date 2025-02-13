<?php

class User_profileController extends Controller {

	private $pageTpl = '/templates/user_profile.tpl';

	public function __construct() {
		$this->model = new User_profileModel();
		$this->view = new View();
	}

	public function index() {
        global $env;

        if(isset($_FILES['image'])){
            $this->image_upload();
            $logo = $this->model->check_logo();
            $this->setLogo($logo);
        }

        $this->controller();

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function image_upload(){
        // Checking for sending file
        if(isset($_FILES['image'])){
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=pathinfo($file_name, PATHINFO_EXTENSION);
            $extensions= array("jpeg","jpg","png");

            // Checking the file extension
            if(!in_array($file_ext,$extensions)){
                $errors[]="Extension not allowed, please choose a JPEG or PNG file.";
            }

            // Check the file size (maximum 2MB)
            if($file_size > 2097152){
                $errors[]='File size must be less than 2 MB';
            }

            // If there are no errors, move the file to the desired directory
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,__DIR__ ."/../assets/uploads/".$file_name);
                $this->model->user_profile_logo($file_name);
                return;
            } else {
                print_r($errors);
                return;
            }
        }

    }

}