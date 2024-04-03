<?php

class CommentController extends Controller{

    public function __construct() {
        $this->model = new CommentModel();
    }

    public function index(){

        global $env;
        $this->controller();

        try {
            $response = $this->model->forum_comment();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
        }
        catch (PDOException $e) {
            echo 'Error json';
        }

        if ($_POST['action'] == 'add_comment') {
            $this->add_comment();
        }
    }

    public function add_comment(){
        $this->model->add_comments();
    }
}