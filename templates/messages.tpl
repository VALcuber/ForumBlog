<main>
    <div class="container-fluid wrapper bg-white">
        <div class="row px-4 py-4">

            <!-- Users card -->
            <aside class="col-4 border-end">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-center align-items-center h5">
                        Users
                    </div>
                    <ul class="list-group list-group-flush" id="usersList">
                        <?= $pageData['senders'] ?>
                    </ul>
                </div>
            </aside>

            <!-- Chatroom card -->
            <section class="col-8" id="chatroomSection">
                <div class="card h-100 d-flex flex-column position-relative" id="chatroomCard">
                    <div class="card-header d-flex justify-content-center align-items-center h5">
                        Chatroom
                    </div>
                    <div id="defaultMessage" class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <h3 class="text-muted">Please choose conversation</h3>
                    </div>
                    <div id="chatWindow" class="flex-grow-1">
                        <div class="card-body overflow-auto" style="height: 400px;" id="chatContent"></div>
                        <div class="card-footer">
                            <form class="d-flex" onsubmit="return false;">
                                <input type="text" id="messageInput" class="form-control me-2" placeholder="Type a message...">
                                <button id="sendBtn" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>
