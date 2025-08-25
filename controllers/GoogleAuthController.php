<?php

class GoogleAuthController extends Controller {

    private $pageTpl = '/templates/google_auth.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new GoogleAuthModel();
        $this->view = new View();
    }

    // Step 1: Redirect to Google OAuth login
    public function glogin() {
        try {
            $this->controller();

            if (!defined('GOOGLE_CLIENT_ID') || !defined('GOOGLE_CLIENT_SECRET')) {
                throw new Exception('Google OAuth configuration not loaded');
            }

            $authUrl = $this->getGoogleAuthUrl();
            header('Location: ' . $authUrl);
            exit;

        } catch (Exception $e) {
            $this->showError('Google OAuth Error', $e->getMessage());
        }
    }

    // Step 2: Callback from Google
    public function callback() {
        try {
            $this->controller();

            if (!isset($_GET['code'])) {
                throw new Exception(GOOGLE_ERROR_NO_CODE);
            }

            $code = $_GET['code'];
            $tokenData = $this->getAccessToken($code);

            if (!isset($tokenData['access_token'])) {
                throw new Exception(GOOGLE_ERROR_NO_TOKEN);
            }

            // Receive user data from Google only for identification (id/email)
            $userInfo = $this->getGoogleUserInfo($tokenData['access_token']);

            if (!$userInfo) {
                throw new Exception(GOOGLE_ERROR_NO_USERINFO);
            }

            // Check base and receive user data
            $this->processGoogleUserFromDB($userInfo);

        } catch (Exception $e) {
           $this->showError('Google OAuth Callback Error', $e->getMessage());
        }
    }

    // --- Private methods ---

    private function showError($title, $message) {
        $pageData = [
            'title' => $title,
            'header' => $title,
            'content' => '<div class="alert alert-danger"><h4><strong>Error:</strong> ' . htmlspecialchars($message) . '</h4></div>'
        ];
        $this->view->render($this->pageTpl, $pageData);
        exit;
    }

    private function getGoogleAuthUrl() {
        $params = [
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'scope' => GOOGLE_SCOPES,
            'response_type' => 'code',
            'access_type' => 'offline'
        ];

        return GOOGLE_AUTH_URL . '?' . http_build_query($params);
    }

    private function getAccessToken($code) {
        $postData = [
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => GOOGLE_REDIRECT_URI
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function getGoogleUserInfo($accessToken) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_USERINFO_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function processGoogleUserFromDB($userInfo) {
        global $env;

        // Chech user in DB
        $existingUser = $this->model->getUserByGoogleIdOrEmail($userInfo['id'], $userInfo['email']);

        if ($existingUser) {

            // If Google ID don't set we update
            if (!$existingUser['google_id']) {
                $this->model->updateUserWithGoogleId($existingUser['id'], $userInfo['id']);
            }

            $userId = $existingUser['id'];

            $this->encrypting_data($existingUser);
        }
        else {
            // Create new user with Google data
            $userData = [
                'google_id' => $userInfo['id'],
                'email' => $userInfo['email'],
                'first_name' => $userInfo['given_name'] ?? '',
                'last_name' => $userInfo['family_name'] ?? '',
                'nickname' => $userInfo['name'] ?? 'Google User',
                'birthday' => date('Y-m-d'),
                'password' => password_hash(uniqid(), PASSWORD_DEFAULT),
                'picture' => $userInfo['picture']
            ];

            $userId = $this->model->createGoogleUser($userData);

            //Search user in DB
            $existingUser_after_create = $this->model->getUserByGoogleIdOrEmail($userInfo['id'], $userInfo['email']);

            $this->encrypting_data($existingUser_after_create);
        }

        // Create token for user
        $this->pageData['id_login'] = $env['token'] = $this->LogIn($userId);

        // Redirect on main page
        header('Location: /');
        exit;
    }


}
