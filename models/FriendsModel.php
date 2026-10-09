<?php

class FriendsModel extends Model{

    public function getFriends($userId){
        $sql = "SELECT f.*, u.nickname, u.logo
                    FROM friends f
                        /* Connect with NOT ME */
                        INNER JOIN users u ON u.id = IF(f.friend1_id = :userId, f.friend2_id, f.friend1_id)
                            ORDER BY f.friends_from DESC";
        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":userId", $userId, PDO::PARAM_STR);
        $smtpc->execute();

        return $smtpc->fetchall(PDO::FETCH_ASSOC);
    }

    public function getfriendlist($userId, $friendId) {
        // Friend's data (from users) + friendship date (from friends).
        // The WHERE clause guarantees that a stranger's profile is never returned: a real friendship is required.
        $sql = "SELECT f.*, u.first_name, u.last_name, u.nickname, u.birthday, u.email, u.logo
                FROM friends f
                    INNER JOIN users u ON u.id = :friendId
                WHERE (f.friend1_id = :userId AND f.friend2_id = :friendId)
                   OR (f.friend1_id = :friendId AND f.friend2_id = :userId)
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":friendId", $friendId, PDO::PARAM_INT);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();

        // A single row, or false if there is no such friend
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}