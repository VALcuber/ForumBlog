<?php

class SearchController extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model = new SearchModel();
    }

    public function index(){
        $query = $_POST['query'] ?? '';
        $query = trim($query);

        if ($query === '') {
            echo '<div class="no-results">Enter text to search</div>';
            return;
        }

        $searchPattern = '%' . $query . '%';
        $results = $this->model->search($searchPattern);

        if (empty($results)) {
            echo '<div class="no-results">No results found</div>';
        } else {
            foreach ($results as $item) {
                $url = $this->generateUrl($item);
                $highlightedTitle = $this->highlightQuery($item['title'], $query);

                echo '<a href="' . $url . '">' . $highlightedTitle . '</a>';
            }
        }
    }

    private function generateUrl($item) {
        switch ($item['type']) {
            case 'blog':
                // /blog/Games
                return '/blog/' . urlencode($item['title']);

            case 'blog_category':
                // /blog/Games/Portal
                return '/blog/' . urlencode($item['parent_category']) . '/' . urlencode($item['title']);

            case 'forum':
                // /forum/Games
                return '/forum/' . urlencode($item['title']);

            case 'forum_category':
                // /forum/Games/Portal
                return '/forum/' . urlencode($item['parent_category']) . '/' . urlencode($item['title']);

            default:
                return '#';
        }
    }

    private function highlightQuery($text, $query) {
        $text = htmlspecialchars($text);
        $query = htmlspecialchars($query);

        return preg_replace(
            '/(' . preg_quote($query, '/') . ')/iu',
            '<mark>$1</mark>',
            $text
        );
    }

    private function getTypeLabel($type) {
        $labels = [
            'blog' => 'Blog - Category',
            'blog_category' => 'Blog - Post',
            'forum' => 'Forum - Category',
            'forum_category' => 'Forum - Topic'
        ];

        return $labels[$type] ?? $type;
    }

    private function getDisplayPath($item) {
        switch ($item['type']) {
            case 'blog':
                return '/blog/' . htmlspecialchars($item['title']);

            case 'blog_category':
                return '/blog/' . htmlspecialchars($item['parent_category']) . '/' . htmlspecialchars($item['title']);

            case 'forum':
                return '/forum/' . htmlspecialchars($item['title']);

            case 'forum_category':
                return '/forum/' . htmlspecialchars($item['parent_category']) . '/' . htmlspecialchars($item['title']);

            default:
                return '';
        }
    }
}