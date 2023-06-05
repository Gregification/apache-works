<!DOCTYPE html>

<?php
    ob_start();
    include_once '/var/www/html/request/chat/login.php';
    ob_end_clean();
?>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="/chat/usersearch.js"></script>
        <title>chat</title>
    </head>
    <body style="background-color: #83b1a3"> 
        <nav class="navbar navbar-expand navbar-dark bg-black sticky-top">
            <div class="container">
                <div class="dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chat: users</a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/chat/page3.php">chat</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="/chat/chats.php">chat search</a></li>
                        <li><a class="dropdown-item" href="/chat/stats.php">stats</a></li>
                        <div class="dropdown-divider"></div>
                        <li><button class="dropdown-item btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-user">user</button></li>
                    </ul>
                </div>
                <div class="navbar-header">
                    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
                    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.php"></script>
                </div>
            </div>
        </nav>
        
        <div class="container" style="background-color: #a2c0a5;">
            <!-- serach form -->
            <div class="container" style="background-color: #abf1d228">
                <form id="form-usersearch">
                    <div class="row">
                        <lable for="">Keyword</lable>
                        <div class="input-group">
                            <input type="text" name="searchTerm" class="form-control" placeholder="username...">
                            <button class="btn" style=" background-color: #34eb98" type="submit">Search</button>
                        </div>
                    </div>
                    <div class="row">
                        <lable for="cmpari">Compair against</lable>
                        <div class="input-group col">
                            <select class="form-select" name="cmpari" id="cmpari">
                                <option selected value="username">Username</option>
                                <option value="creationtime">Creation time</option>
                                <option value="lastactivetime">Last active</option>
                                <option value="description">Description</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="orderBy">Order By</label>
                            <div class="input-group">
                                <select class="form-select" name="orderBy" id="orderBy">
                                    <option selected value="username">Username</option>
                                    <option value="creationtime">Creation time</option>
                                    <option value="lastactivetime">Last active</option>
                                    <option value="description">Description</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="orderBy">Sort</label>
                            <div class="input-group">
                                <select class="form-select" name="dr" id="dr">
                                    <option selected value="asc">Acending</option>
                                    <option value="desc">Decending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="batchsize">Results per page</label>
                            <select class="form-select" name="batchsize" id="batchsize">
                                <option value="all">All</option>
                                <option selected value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="20">20</option>
                                <option value="40">40</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="container" style="background-color: #abf1d228;">
                <!-- user cards -->
                <div class="card-columns p-1" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 5px;" id="usercards">
                    <div hidden class="card" style="min-width: 200px; max-width: 30%;">
                        <img class="card-img-top rounded-0" src="/icon/default/icon.png">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">description</p>
                            <div class="justify-content-between">
                                <small class="text-muted text-left">join#</small>
                                <small class="text-muted text-right">onlinehr#</small>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="row justify-content-center">
                    <ul class="pagination justify-content-center" id="paginationBottom">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- modal user -->
        <div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="modal-user-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" >User</h1>&ensp;
                        <h1 class="modal-title fs-5 border border-primary border-2 border-opacity-15 rounded-2 modal-user-label" style="word-wrap: break-word;" id="modal-user-usernamedisplay">
                            <?php echo $_SESSION['username']; ?>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-modal-tryusername" method='post'>
                            <label for="btn_try">Name</label>
                            <div class="input-group mb-3 newname">
                                <button class="btn btn-outline-secondary rounded-0" type="submit" name="btn_try" id="btn_try">try</button> 
                                <input required name="newName" type="text" class="form-control" id="usernamerequest-input" placeholder="timmy" aria-label="username" aria-describedby="basic-addon1" maxlength="255">
                            </div>
                        </form>
                        <form id="form-modal-description">
                            <lable for="usr_description">Description</lable>
                            <button class="btn btn-outline-secondary rounded-0 border-opacity-0" type="submit" name="btn_description" id="btn_description">update</button> 
                            <div>
                                <textarea required type="text" name="description" id="usr_description" placeholder="something something"  maxlength="500" style="width: 100%; min-height: 5rem;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" id="rndName_btn">random name</button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>