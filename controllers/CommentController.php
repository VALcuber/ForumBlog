<?php
/** @used-by Router */
class CommentController extends Controller{

/**@noinspection PhpMissingParentConstructorInspection*/
    public function __construct() {
        $this->model = new CommentModel();
    }

    public function index(){
        global $env;

        $this->controller();

        $response = $this->model->forum_comment();

        if($env['action'] != 'add_comment') {

            try {
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

    private function add_comment(){
        return ($this->model->add_comments());
    }
}