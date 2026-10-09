<?php

class FriendsController extends Controller{

    private $pageTpl = '/templates/friends.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new FriendsModel();
        $this->view = new View();
    }

    public function index() {
        // First, initialize the main controller data (ID, environment, etc.)
        $this->controller();

        // Check if this is an AJAX request
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_friend_info') {
            $friendsId = (int)($_GET['friends_id'] ?? 0);
            $this->friends_list($friendsId);
            return;
        }

        $this->friends_info();

        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function friends_list($friendId) {
        global $env;

        // Fetch from model (a single row or false)
        $friend_data = $this->model->getfriendlist($env['id'], $friendId);

        // Clear output buffer to ensure clean JSON without stray PHP errors/notices
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        if (!$friend_data) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Friend not found'
            ]);
            exit;
        }

        // Data processing and HTML building are done in PHP, JS only inserts the result
        $friend = $this->prepareFriend($friend_data);

        echo json_encode([
            'status' => 'success',
            'current_user_id' => $env['id'],
            'html' => $this->renderFriendProfile($friend)
        ]);

        exit; // Terminate execution so template is not rendered
    }

    /** Escape a value for HTML output, using a default when it is empty */
    private function escape($value, $default = '') {
        return htmlspecialchars($value ?: $default);
    }

    /** Escape data and apply default values */
    private function prepareFriend(array $row): array {
        return [
            'nickname' => $this->escape($row['nickname']),
            'logo'     => $this->escape($row['logo'], '/assets/img/default-avatar.png'),
            'fullName' => $this->escape(trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))),
            'email'    => $this->escape($row['email'], 'Not specified'),
            'birthday' => $this->escape($row['birthday'], 'Not specified'),
            'since'    => $this->escape($row['friends_from'], 'N/A'),
        ];
    }

    /** HTML of the friend's profile card */
    private function renderFriendProfile(array $f): string {
        return <<<HTML
        <div class="d-flex flex-column align-items-center">
            <img src="{$f['logo']}" class="rounded-circle mb-3 border" width="100" height="100" style="object-fit: cover;">
            <h3>{$f['fullName']}</h3>
            <p class="text-muted">@{$f['nickname']}</p>
        </div>
            <hr class="my-4">

            <div class="text-start px-3">
                <p class="mb-2"><strong>Email:</strong> {$f['email']}</p>
                <p class="mb-2"><strong>Birthday:</strong> {$f['birthday']}</p>
                <p class="mb-2"><strong>Friends Since:</strong> {$f['since']}</p>
            </div>
HTML;
    }

    public function friends_info() {
        global $env;
        $friends_list = $this->model->getFriends($env['id']);
        $friends = [];

        foreach($friends_list as $value) {

            $id = ($value['friend1_id'] == $env['id']) ? $value['friend2_id'] : $value['friend1_id'];
            $friends_nickname = htmlspecialchars($value['nickname']);
            $friends_logo = htmlspecialchars($value['logo']);
            $friends_info = '';

            // Added data-friend-id attribute here
            $li_friends_list = <<<"EOT"
            <li class="d-flex list-group-item user-item" data-user-id="$id" data-user="$friends_nickname" style="cursor:pointer">
                <div class="d-flex flex-column align-items-center justify-content-center"">
                    <img src="$friends_logo" class="header__profile d-none d-sm-block rounded-circle mb-1" width="40">
                    <span class="text-muted text-center">
                        <h5>$friends_nickname</h5>
                    </span>
                </div>

                    <div class="flex-grow-1 d-flex align-items-center justify-content-center text-center">
                        <h3 class="m-0 text-center" style="display: inline-block;">
                            $friends_info
                        </h3>
                    </div>

            </li>
EOT;
            $friends[] = $li_friends_list;
        }
        $this->pageData['friend_request_senders'] = implode("\n", $friends);
    }

}