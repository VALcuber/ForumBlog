<?php

class CommentController extends Controller {

    public function __construct() {
        $this->model = new CommentModel();
    }

    public function index() {

        try {
            $response = $this->model->forum_comment();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
        }
        catch (PDOException $e){
            echo 'Error json';
        }



    }
}
//echo '<p class="col-lg-10 col-md-12 mx-auto my-2">'. $msg["Comment"] . '</p>' . '<br>';