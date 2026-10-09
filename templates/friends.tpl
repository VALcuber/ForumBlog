<main class="flex-grow-1">
    <div class="container-fluid wrapper bg-white">
        <div class="row px-4 py-4">

            <!-- Friends card -->
            <aside class="col-4 border-end">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-center align-items-center h5">
                        Users
                    </div>
                    <ul class="list-group list-group-flush" id="friendsList">
                        <?= $pageData['friend_request_senders'] ?>
                    </ul>
                </div>
            </aside>

            <!-- Friend info card -->
            <section class="col-8" id="FriendInfoSection">
                <div class="card h-100 d-flex flex-column position-relative" id="FriendInfoCard">
                    <div class="card-header d-flex justify-content-center align-items-center h5">
                        Friend Info
                    </div>
                    <div id="defaultMessage" class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <h3 class="text-muted">Please choose friend</h3>
                    </div>
                    <div id="InfoWindow" class="flex-grow-1">
                        <div class="card-body overflow-auto" style="height: 400px;" id="InfoContent"></div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>
