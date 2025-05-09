<body>

    <?= $pageData['panel']?>

<header class="header">

    <div class="container-fluid bg-white wrapper">

        <div class="row px-4 py-2">

            <div class="header__column d-flex align-items-center">

                <button data-state = "closed" class="toggle-btn bg-transparent border-0">

                    <span class="toggle-btn__bar my-2"></span>

                    <span class="toggle-btn__bar my-2"></span>

                    <span class="toggle-btn__bar my-2"></span>

                </button>

            </div>

            <a href="/" class="header__logo mx-3">

                <img src="/assets/img/logo.png" alt="logo img">

            </a>

            <div class="header__column d-flex align-items-center justify-content-end">

                <input type="text" class="header__search px-3 mr-sm-4 border-0 rounded-pill d-block" placeholder="Search...">

                <button data-state = "closed" id="<?= htmlspecialchars($pageData['id_state']) ?>" class="toggle-btns header__profile text-center d-none d-sm-block rounded-circle" <?= $pageData['signin_modal_winwow'] ?> > <?= $pageData['check'] ?> </button>

            </div>

        </div>
        <div class="row px-4 py-4">

            <nav class="categories flex-grow-1" id="categories">

                <ul class="nav nav-pills nav-fill" id="categories-list">
                    <?= $pageData['topmenu']?>

    </div>

</header>
