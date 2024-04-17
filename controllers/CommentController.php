<?php

class CommentController extends Controller{

    public function __construct() {
        $this->model = new CommentModel();
    }

    public function index(){
        global $env;

        $this->controller();

        if($env['action'] != 'add_comment') {
            try {
                $response = $this->model->forum_comment();

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($response);
            }
            catch (PDOException $e) {
                echo 'Error json';
            }
        }

        elseif ($env['action'] == 'add_comment') {
            echo ($this->add_comment());
            $env['action'] = '';
        }
    }

    public function add_comment(){
        return ($this->model->add_comments());
    }
}