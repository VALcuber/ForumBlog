<?php

class TopicModel extends Model {

    public function gettopics(){

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `Topic`, `Title` FROM `" . $env['route1'] . "` WHERE `Topic` = '" . $env['route2'] . "' ";

        }

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $topic=$smtppage->fetchall(PDO::FETCH_ASSOC);

        return($topic);
    }
}
