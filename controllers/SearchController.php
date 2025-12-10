<?php

class SearchController extends Controller{

    private $pageTpl = '/templates/search_results.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new SearchModel();
    }

    public function index(){
        // Проверяем, это AJAX запрос для живого поиска или обычная форма
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($isAjax) {
            // Для живого поиска - только результаты без шаблона
            $this->liveSearch();
        } else {
            // Для обычной страницы - полный шаблон
            $this->controller();
            $this->prepareSearchData();
            $this->view->render($this->pageTpl, $this->pageData);
        }
    }

    private function liveSearch() {
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

    private function prepareSearchData() {
        $query = $_POST['query'] ?? $_GET['query'] ?? '';
        $query = trim($query);

        $results = [];
        $resultsHtml = '';

        if ($query !== '') {
            $searchPattern = '%' . $query . '%';
            $results = $this->model->search($searchPattern);
        }

        $count = count($results);

        // Формируем строку с результатами
        $resultsInfo = '';
        if ($query) {
            $plural = $count !== 1 ? 's' : '';
            $resultsInfo = "Found <strong>{$count}</strong> result{$plural} for \"<strong>" . htmlspecialchars($query) . "</strong>\"";
        }

        // Формируем HTML результатов
        if (!empty($results)) {
            $resultsHtml .= '<div class="results-list">';
            foreach ($results as $item) {
                $url = $this->generateUrl($item);
                $highlightedTitle = $this->highlightQuery($item['title'], $query);
                $typeLabel = $this->getTypeLabel($item['type']);
                $badgeClass = 'badge-' . str_replace('_', '-', $item['type']);
                $path = $this->getPath($item);

                $resultsHtml .= '
                    <div class="result-card">
                        <a href="' . $url . '">
                            <div class="result-title">' . $highlightedTitle . '</div>
                            <div class="result-meta">
                                <span class="result-badge ' . $badgeClass . '">' . $typeLabel . '</span>
                                <span class="result-path">' . htmlspecialchars($path) . '</span>
                            </div>
                        </a>
                    </div>';
            }
            $resultsHtml .= '</div>';
        } elseif ($query) {
            $resultsHtml = '
                <div class="no-results-container">
                    <div class="no-results-icon">😔</div>
                    <div class="no-results-text">No results found</div>
                    <div class="no-results-hint">Try different keywords or check your spelling</div>
                    <a href="/" class="back-link">← Back to Home</a>
                </div>';
        } else {
            $resultsHtml = '
                <div class="no-results-container">
                    <div class="no-results-icon">🔎</div>
                    <div class="no-results-text">Start searching</div>
                    <div class="no-results-hint">Enter a keyword in the search box above</div>
                </div>';
        }

        $this->pageData['query'] = htmlspecialchars($query);
        $this->pageData['resultsInfo'] = $resultsInfo;
        $this->pageData['resultsHtml'] = $resultsHtml;
    }

    public function generateUrl($item) {
        switch ($item['type']) {
            case 'blog':
                return '/blog/' . urlencode($item['title']);

            case 'blog_category':
                return '/blog/' . urlencode($item['parent_category']) . '/' . urlencode($item['title']);

            case 'forum':
                return '/forum/' . urlencode($item['title']);

            case 'forum_category':
                return '/forum/' . urlencode($item['parent_category']) . '/' . urlencode($item['title']);

            default:
                return '#';
        }
    }

    public function highlightQuery($text, $query) {
        $text = htmlspecialchars($text);
        $query = htmlspecialchars($query);

        return preg_replace(
            '/(' . preg_quote($query, '/') . ')/iu',
            '<mark>$1</mark>',
            $text
        );
    }

    public function getTypeLabel($type) {
        $labels = [
            'blog' => 'Blog',
            'blog_category' => 'Blog Post',
            'forum' => 'Forum',
            'forum_category' => 'Forum Topic'
        ];

        return $labels[$type] ?? $type;
    }

    public function getPath($item) {
        switch ($item['type']) {
            case 'blog':
                return '/blog/' . $item['title'];

            case 'blog_category':
                return '/blog/' . $item['parent_category'] . '/' . $item['title'];

            case 'forum':
                return '/forum/' . $item['title'];

            case 'forum_category':
                return '/forum/' . $item['parent_category'] . '/' . $item['title'];

            default:
                return '';
        }
    }
}