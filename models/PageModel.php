<?php

class PageModel extends Model{

    public function get_page($temporary){

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `id`,`Title`,`Description` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        } elseif ($env['route1'] == 'news') {

            $sql = "SELECT `id`,`name`,`content` FROM `" . $env['route1'] . "` WHERE `name` = '$temporary'";

        } elseif ($env['route1'] == 'blog') {

            $sql = "SELECT `id`,`Title`,`blog_content` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        }

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $rower = $smtppage->fetch(PDO::FETCH_ASSOC);

        $_SESSION["page_id"] = $rower['id'];

        return ($rower);

    }

}