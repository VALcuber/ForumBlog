<?php

class AddNewsModel extends Model{

    public function post_news(){

        $news_title = $_POST["title"];
        $news_content = $_POST['description'];

        $sql = "SELECT `name` FROM `news` WHERE `name`= '$news_title'";

        $smtppage = $this->db->prepare($sql);
        $smtppage->execute();
        $smtp_page_rows = $smtppage->rowCount();

        if($smtp_page_rows == 0) {

            $sql = "INSERT INTO `news` (`name`, `content`) VALUES ('$news_title','$news_content')";

            $smtppage = $this->db->prepare($sql);

            $smtppage->execute();
        }

    }

}