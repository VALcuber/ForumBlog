<?php

class GoogleAuthModel extends Model {
    
    // Check if user exists by Google ID or email
    public function getUserByGoogleIdOrEmail($googleId, $email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE google_id = ? OR email = ?");
        $stmt->execute([$googleId, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create new user with Google data
    public function createGoogleUser($userData) {
        $stmt = $this->db->prepare("INSERT INTO users (google_id, email, `first_name`, `last_name`, `nickname`, `birthday`, `pass`, `logo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userData['google_id'],
            $userData['email'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['nickname'],
            $userData['birthday'],
            $userData['password'],
            $userData['picture']
        ]);
        return $this->db->lastInsertId();
    }
    
    // Update existing user with Google ID
    public function updateUserWithGoogleId($userId, $googleId) {
        $stmt = $this->db->prepare("UPDATE users SET google_id = ? WHERE id = ?");
        return $stmt->execute([$googleId, $userId]);
    }
    
    // Check if google_id column exists in users table
    public function checkGoogleIdColumn() {
        $stmt = $this->db->prepare("SHOW COLUMNS FROM users LIKE 'google_id'");
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
    public function getUserDataById($userId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 