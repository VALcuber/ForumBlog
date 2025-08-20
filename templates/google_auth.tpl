    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fab fa-google"></i> <?= $pageData['header'] ?? 'Google Authentication' ?></h3>
                    </div>
                    <div class="card-body">
                        <?= $pageData['content'] ?? 'Content not loaded' ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
