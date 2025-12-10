<main class="main">
    <div class="search-page">
        <div class="container search-container">
            <div class="search-header">
                <h1 class="mb-4">🔍 Search</h1>
                <form action="/search" method="POST" class="search-box">
                    <input type="text"
                           name="query"
                           value="<?= $pageData['query'] ?>"
                           placeholder="What are you looking for?"
                           autocomplete="off"
                           autofocus>
                    <button type="submit">🔎</button>
                </form>

                <div class="results-info"><?= $pageData['resultsInfo'] ?></div>
            </div>

            <?= $pageData['resultsHtml'] ?>
        </div>
    </div>
</main>