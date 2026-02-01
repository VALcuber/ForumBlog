<?php

class MessagesController extends Controller{

    private $pageTpl = '/templates/messages.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new MessagesModel();
        $this->view = new View();
    }

    public function index() {
        // First, initialize the main controller data (ID, environment, etc.)
        $this->controller();

        // Check if this is an AJAX request
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'get_conversation') {
            $otherId = $_GET['other_id'] ?? 0;
            $this->conversation($otherId);
            return;
        }
        //AJAX: Send message (NEW)
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'send_message') {
            $this->sendMessage();
            return;
        }


        $this->inbox();


        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function conversation($otherId) {
        global $env;

        $this->model->markAsRead($env['id'], $otherId);

        // Fetch from model
        $messages = $this->model->getConversation($env['id'], $otherId);

        // Important: Clear any buffered output to ensure clean JSON
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');

        echo json_encode([
            'current_user_id' => $env['id'],
            'messages' => $messages
        ]);

        exit; // Stop execution so the template doesn't load
    }

    public function sendMessage() {
        global $env;
        $senderId = $env['id'];
        $receiverId = (int)($_POST['receiver_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($content !== '' && $receiverId > 0) {
            // English comment: Save new message to the database
            $success = $this->model->sendMessage($senderId, $receiverId, $content);

            if (ob_get_length()) ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['status' => $success ? 'success' : 'error']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empty message']);
        }
        exit;
    }

    public function inbox() {
        global $env;
        $inbox = $this->model->getInbox($env['id']);
        $senders = [];

        // Handle message sending via POST AJAX
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'send_message') {
            $this->sendMessage();
            return;
        }

        foreach($inbox as $value) {

            $id = ($value['sender_id'] == $env['id']) ? $value['receiver_id'] : $value['sender_id'];
            $nickname = htmlspecialchars($value['nickname']);
            $logo = htmlspecialchars($value['logo']);
            $message = htmlspecialchars($value['content']);

            // A message is "unread" for ME only if:
            // 1. I am the receiver (receiver_id == userId)
            // 2. The is_read status is 0
            $isUnreadForMe = ($value['receiver_id'] == $env['id'] && $value['is_read'] == 0);

            // Check if the message is unread
            if ($isUnreadForMe) {
                $openTag = '<strong>';
                $closeTag = '</strong>';
            } else {
                $openTag = $closeTag = '';
            }

            // Added data-user-id attribute here
            $li_inbox = <<<"EOT"
            <li class="d-flex list-group-item user-item" data-user-id="$id" data-user="$nickname" style="cursor:pointer">
                <div class="d-flex flex-column align-items-center justify-content-center"">
                    <img src="$logo" class="header__profile d-none d-sm-block rounded-circle mb-1" width="40">
                    <span class="text-muted text-center">
                        <h5>$nickname</h5>
                    </span>
                </div>

                    <div class="flex-grow-1 d-flex align-items-center justify-content-center text-center">
                        <h3 class="m-0 text-center" style="display: inline-block;">
                            $openTag$message$closeTag
                        </h3>
                    </div>

            </li>
EOT;
            $senders[] = $li_inbox;
        }
        $this->pageData['senders'] = implode("\n", $senders);
    }

}