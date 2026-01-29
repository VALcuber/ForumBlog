<?php

class MessagesModel extends Model{

    public function getInbox($userId){
        // Use GROUP BY to get only one entry per sender.
        // We use MAX(id) or subqueries to get the latest message if needed,
        // but a simple GROUP BY will fix the duplication for now.
        $sql = "SELECT m.*, u.logo, u.nickname
                    FROM messages m
                        /* Connect with NOT ME */
                        INNER JOIN users u ON u.id = IF(m.sender_id = :userId, m.receiver_id, m.sender_id)
                            INNER JOIN (
                                SELECT MAX(id) as max_id
                                    FROM messages
                                        WHERE receiver_id = :userId OR sender_id = :userId
                                            /* Group by ID */
                                            GROUP BY IF(sender_id = :userId, receiver_id, sender_id)
                                         ) last_msgs ON m.id = last_msgs.max_id
                                        ORDER BY m.created_at DESC";
        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":userId", $userId, PDO::PARAM_STR);
        $smtpc->execute();

        return $smtpc->fetchall(PDO::FETCH_ASSOC);
    }

    public function getConversation($userId, $otherId) {
        // We select messages where (I am sender AND they are receiver) OR (I am receiver AND they are sender)
        $sql = "SELECT * FROM `messages` 
                WHERE (`sender_id` = :userId AND `receiver_id` = :otherId) 
                   OR (`sender_id` = :otherId AND `receiver_id` = :userId)
                ORDER BY `created_at` ASC"; // Assuming you have a timestamp column

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":otherId", $otherId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead($userId, $otherId){
        // Update existing rows, don't create new ones
        $sql = "UPDATE `messages`
                    SET `is_read` = 1
                        WHERE `receiver_id` = :userId
                          AND `sender_id` = :otherId 
                            AND `is_read` = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':otherId', $otherId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function sendMessage($userId, $otherId, $content){
        // English comment: Insert new record into messages table
        $sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `content`, `is_read`) VALUES (:s, :r, :c, 0)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':s', (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(':r', (int)$otherId, PDO::PARAM_INT);
        $stmt->bindValue(':c', htmlspecialchars($content), PDO::PARAM_STR);

        return $stmt->execute();
    }


}