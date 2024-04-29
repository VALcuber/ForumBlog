<?php

class User_profileController extends Controller {

	private $pageTpl = '/templates/user_profile.tpl';

	public function __construct() {
		$this->model = new User_profileModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
        if(isset($_FILES['image'])){
            $this->image_upload();
        }

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function image_upload(){
        // Проверяем, был ли отправлен файл
        if(isset($_FILES['image'])){
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=pathinfo($file_name, PATHINFO_EXTENSION);
            $extensions= array("jpeg","jpg","png");

            // Проверяем расширение файла
            if(!in_array($file_ext,$extensions)){
                $errors[]="Extension not allowed, please choose a JPEG or PNG file.";
            }

            // Проверяем размер файла (максимум 2MB)
            if($file_size > 2097152){
                $errors[]='File size must be less than 2 MB';
            }

            // Если нет ошибок, перемещаем файл в желаемую директорию
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,__DIR__ ."/../assets/uploads/".$file_name);
                //echo "Success";
                return;
            } else {
                print_r($errors);
                return;
            }
        }

    }

}