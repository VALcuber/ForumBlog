<?php

class SearchController extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model = new SearchModel();
    }
    public function index(){
        global $env;
        $query = $_POST['query'] ?? '';

        $results = [];

        if ($query !== '') {
            $results = $this->model->search($query);
        }

        if (empty($results)) {
            echo '<div>No results</div>';
        } else {
            // Можно использовать отдельный шаблон для фрагмента
            foreach ($results as $item) {
                // Пример, если у нас есть тип и id
                $url = '';
                switch ($item['title']) {
                    case 'blog_category':
                        $url = '/blog_category/' . $item['id'];
                        break;
                    case 'blog':
                        $url = '/blog/' . $item['id'];
                        break;
                    case 'forum':
                        $url = '/forum/' . $item['id'];
                        break;
                    case 'forum_category':
                        $url = '/forum_category/' . $item['id'];
                        break;
                    case 'news':
                        $url = '/news/' . $item['id'];
                        break;
                }
                echo '<div class="search-item">
            <a href="' . $url . '">' . htmlspecialchars($item['title']) . '</a>
          </div>';
            }
        }
    }
}