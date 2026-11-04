<?php
/** @used-by Router */
class User_profileController extends Controller {

    private $pageTpl = '/templates/user_profile.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new User_profileModel();
        $this->view = new View();
    }

    public function index() {

        $this->controller();

        // AJAX: fresh "Messages" block for live updates (unread dots)
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_inbox') {
            $this->inboxJson();
            return;
        }

        if(isset($_FILES['image'])){
            $id = $this->get_decrypted_post_data();
            $this->image_upload();
            $logo = $this->model->check_logo($id['id']);
            $this->setLogo($logo);
        }

        $this->pageData['script_profile'] = '<script src="../assets/js/profile.js"></script>';
        $this->pageData['user_forum_posts'] = $this->user_forum_posts();
        $this->pageData['user_blog_posts'] = $this->user_blog_posts();
        $this->pageData['user_messages_unread_inbox'] = $this->inbox();
        $this->pageData['user_friends_no_friends'] = $this->friends();

        $this->view->render($this->pageTpl, $this->pageData);
    }

    private function image_upload(){

        $id = $this->get_decrypted_post_data();
        // Checking for sending file
        if(isset($_FILES['image'])){
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            //$file_type=$_FILES['image']['type'];
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
                $this->model->user_profile_logo($file_name, $id['id']);
                return;
            } else {
                print_r($errors);
                return;
            }
        }

    }
    private function user_forum_posts(){

        $id = $this->get_decrypted_post_data();

        $result_forum_HTML = '';

        $user_posts_array = $this->model->user_forum_posts($id['id']);
        $count_user_posts = count($user_posts_array);

        for ($i = 0; $i < $count_user_posts; $i++) {
            $user_posts_part_from_bd = $user_posts_array[$i]['Part'];
            $user_posts_category_from_bd = $user_posts_array[$i]['Category'];
            $user_posts_subcategory_from_bd = $user_posts_array[$i]['Subcategory'];
            $user_posts_description_from_bd = $user_posts_array[$i]['Description'];


            $user_posts = <<<"EOT"
<a href="/$user_posts_part_from_bd/$user_posts_category_from_bd/$user_posts_subcategory_from_bd/$user_posts_description_from_bd">$user_posts_description_from_bd</a>
EOT;
            $result_forum_HTML .= $user_posts;
        }
        return $result_forum_HTML;
    }
    private function user_blog_posts(){

        $id = $this->get_decrypted_post_data();

        $result_blog_HTML = '';

        $user_posts_array = $this->model->user_blog_posts($id['id']);
        $count_user_posts = count($user_posts_array);

        for ($i = 0; $i < $count_user_posts; $i++) {
            $user_posts_category_from_bd = $user_posts_array[$i]['Category'];
            $user_posts_subcategory_from_bd = $user_posts_array[$i]['Subcategory'];
            $user_posts_description_from_bd = $user_posts_array[$i]['Description'];
            $user_posts_part_from_bd = $user_posts_array[$i]['Part'];

            $user_posts = <<<"EOT"
<a href="/$user_posts_part_from_bd/$user_posts_category_from_bd/$user_posts_subcategory_from_bd/$user_posts_description_from_bd">$user_posts_description_from_bd</a>
EOT;
            $result_blog_HTML .= $user_posts;
        }

        return $result_blog_HTML;
    }

    /** AJAX: returns the freshly rendered "Messages" block as JSON */
    private function inboxJson(){
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');

        echo json_encode([
            'status' => 'success',
            'html' => $this->inbox()
        ]);

        exit;
    }

    public function inbox(){
        global $env;

        $users_inbox = $this->model->users_inbox($env['id']);

        if ($users_inbox != NULL){
            $items = [];

            foreach ($users_inbox as $value) {
                $id = (int)(($value['sender_id'] == $env['id']) ? $value['receiver_id'] : $value['sender_id']);
                $nickname = htmlspecialchars($value['nickname']);

                // Unread for ME: I am the receiver and the message is not read yet (0 or NULL)
                $unreadDot = ($value['receiver_id'] == $env['id'] && empty($value['is_read']))
                    ? '<span class="new-message-dot ms-2 d-inline-block rounded-circle bg-danger" style="width:10px;height:10px;" title="New message"></span>'
                    : '';

                $items[] = <<<"EOT"
            <li class="list-group-item d-flex justify-content-between align-items-center position-relative" data-user-id="$id" data-user="$nickname" style="cursor:pointer">
                <a href="/user_profile/messages?chat=$id" class="stretched-link text-decoration-none text-reset">$nickname</a>$unreadDot
            </li>
EOT;
            }

            // The model returns at most 3 freshest conversations, they are shown in ONE card
            $list = implode("\n", $items);

            return $this->pageData['senders'] = <<<"EOT"
        <div class="card" style="width: 500px; height: auto; max-height: 250px; overflow-y: auto;">
          <div class="card-header text-center">Messages</div>
          <ul class="list-group list-group-flush">
$list
          </ul>
          <div class="card-footer text-center">
            <a href="/user_profile/messages" class="btn btn-sm btn-primary">All messages</a>
          </div>
        </div>
EOT;
        }
        else{
            return $user_posts = <<<"EOT"
        <div class="card" style="width: 500px; height: 205px; overflow-y: auto;">
          <ul class="list-group list-group-flush">
            <li class="d-flex list-group-item justify-content-center">Please</li>
            <li class="d-flex list-group-item justify-content-center">start</li>
            <li class="d-flex list-group-item justify-content-center">conversation</li>
          </ul>
          <div class="card-footer text-center">
            <a href="/user_profile/messages" class="btn btn-sm btn-primary">All messages</a>
          </div>
        </div>
EOT;
        }
    }

    public function friends(){
        global $env;

        $friends_inbox = $this->model->users_friends($env['id']);

        if ($friends_inbox != NULL){
            $items = [];

            foreach ($friends_inbox as $value) {
                $id = (int)(($value['friend1_id'] == $env['id']) ? $value['friend2_id'] : $value['friend1_id']);
                $nickname = htmlspecialchars($value['nickname']);

                // The whole row is a link to the friends page with this friend preselected
                $items[] = <<<"EOT"
            <li class="list-group-item position-relative" data-user-id="$id" data-user="$nickname" style="cursor:pointer">
                <a href="/user_profile/friends?friend=$id" class="stretched-link text-decoration-none text-reset">$nickname</a>
            </li>
EOT;
            }

            // All friends are shown in ONE card
            $list = implode("\n", $items);

            return $this->pageData['friends'] = <<<"EOT"
        <div class="card" style="width: 500px; height: auto; max-height: 250px; overflow-y: auto;">
          <div class="card-header text-center">Friends</div>
          <ul class="list-group list-group-flush">
$list
          </ul>
          <div class="card-footer text-center">
            <a href="/user_profile/friends" class="btn btn-sm btn-primary">All friends</a>
          </div>
        </div>
EOT;
        }
        else{
            return $user_posts = <<<"EOT"
        <div class="card" style="width: 500px; height: 205px; overflow-y: auto;">
          <ul class="list-group list-group-flush">
            <li class="d-flex list-group-item justify-content-center">Please</li>
            <li class="d-flex list-group-item justify-content-center">make</li>
            <li class="d-flex list-group-item justify-content-center">friends</li>
          </ul>
          <div class="card-footer text-center">
            <a href="/user_profile/friends" class="btn btn-sm btn-primary">All friends</a>
          </div>
        </div>
EOT;
        }
    }

}