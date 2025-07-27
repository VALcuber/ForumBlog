<?php

class View {

    public function render($tpl, $pageData) {
        // Check if this is an admin page
        if (isset($pageData['admin_page']) && $pageData['admin_page'] === true) {
            // For admin pages, render only the template without header and footer
            include ROOT. '/templates/' . $tpl . '.tpl';
        } else {
            // For regular pages, use the original logic
            include ROOT. '/templates/head.tpl';
            include ROOT. '/templates/header.tpl';
            include ROOT. $tpl; // Original logic for main site templates
            include ROOT. '/templates/footer.tpl';
        }
    }

}