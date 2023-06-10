<!DOCTYPE html>

<?php
    ob_start();
    include_once '/var/www/html/request/chat/login.php';
    include_once '/var/www/html/request/chat/joinchat.php';
    ob_end_clean();
?>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script type='module' src="/chat/page3.js"></script>
        <title>chat</title>
    </head>
    
    <body> 
        <nav class="navbar navbar-expand navbar-dark bg-black sticky-top">
            <div class="container">
                <div class="dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chat</a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/chat/chats.php">chat search</a></li>
                        <li><a class="dropdown-item" href="/chat/users.php">user search</a></li>
                        <li><a class="dropdown-item" href="/chat/stats.php">stats</a></li>
                        <div class="dropdown-divider"></div>
                        <li><button class="dropdown-item btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-chatinfo">chat info</button></li>
                    </ul>
                </div>
                <div class="navbar-header text-warning" id="chatnamedisplay"></div>
                <div class="navbar-header">
                    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
                    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.php"></script>
                </div>
            </div>
        </nav>

        <!-- note: https://htmldom.dev/create-resizable-split-views/ -->
        <!-- <header>
            <h2 style="text-align: center;"><?php echo $_SESSION['chat'] ?? 'no chat' ?></h2>
        </header> -->

        <!-- message creator -->
        <div class="fixed-bottom" style="width: 100%; max-height: 40%;">
            <div class="contianer">
                <div class="border border-4 p-1">
                    <form>
                        <div class="row" style="margin-bottom: 2px;">
                            <div class="col">
                                <button class="btn btn-primary">send</button>
                            </div>
                        </div>
                        <div class="row">
                            <textarea class="form-control" placeholder="message ..." style="min-height: 1.5rem; max-height: 200px;"oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- message display -->
        <div style="overflow-y: auto; height: 700px; background-color: #0f6c79">
            <template>
                <div class="card text-left" style="flex-direction: row; margin: 5px;">
                    <div style="max-width: 20%; min-width: 5%; max-height: 90%;">
                        <img class="card-img-left rounded-0" src="/icon/default/icon.png" style="width: 50px; height: 50px;" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        username
                        <small class="card-text text-muted">time of posting</small>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.Some quick example text to build on the card title and make up the bulk of the card's content.Some quick example text to build on the card title and make up the bulk of the card's content.Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- modal chat settings -->
        <div class="modal fade" id="modal-chatinfo" tabindex="-1" aria-labelledby="modal-user-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 border border-primary border-2 border-opacity-15 rounded-2 modal-user-label" style="word-wrap: break-word;" id="modal-chatinfo-chatnamedisplay"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-modal-joinchat" method='post'>
                            <label for="btn_join">Chat title</label>
                            <div class="input-group mb-3 newname">
                                <button class="btn btn-outline-secondary rounded-0" type="submit" id="btn_join">join</button>
                                <input required name="title" type="text" class="form-control" placeholder="default chat" maxlength="255">
                            </div>
                        </form>
                        <!-- <form id="form-modal-description">
                            <lable for="usr_description">Description</lable>
                            <button class="btn btn-outline-secondary rounded-0 border-opacity-0" type="submit" name="btn_description" id="btn_description">update</button> 
                            <div>
                                <textarea required type="text" name="description" id="usr_description" placeholder="something something"  maxlength="500" style="width: 100%; min-height: 5rem;"></textarea>
                            </div>
                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" id="rndName_btn">random name</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>