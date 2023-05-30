<!DOCTYPE html>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="/script1.js"></script>
        <script src="./tryname.js"></script>
        <title>chat</title>
    </head>
    <body style="background-color: #83b1a3"> 
        <nav class="navbar navbar-expand navbar-dark bg-black">
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
                    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.html"></script>
                </div>
            </div>
        </nav>
        
        <div class="container">
            <form action="#">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for username ... (regex accepted)" name="title">
                    <button class="btn" style=" background-color: #34eb98 !important" type="submit">Search</button>
                </div>
            </form> 
        </div>
        <br>
        <!-- user grouping -->
        <div class="card-columns p-1" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 5px;">
            <div class="card" style="max-width: 100%;">
                <div class="card-header">
                    username
                </div>
                <img class="card-img-top rounded-0" src="/icon/default/icon.png">
                <small class="card-text text-muted">time of posting</small>
                <div class="card-body" style="flex: 1">
                    
                </div>
            </div>
        </div>

        <!-- modal user -->
        <div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="modal-user-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" >User</h1>&ensp;
                        <h1 class="modal-title fs-5 border border-primary border-2 border-opacity-15 rounded-2 modal-user-label" id="modal-user-usernamedisplay">Username here</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-modal-tryusername">
                            <div class="input-group mb-3 newname">
                                <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary rounded-0" type="submit">try</button> 
                                </div>
                                <input required name="newName" type="text" class="form-control" id="usernamerequest-input" placeholder="new name " aria-label="username" aria-describedby="basic-addon1" maxlength="255">
                            </div>
                        </form> 
                    </div>
                    <!-- <div class="modal-footer">
                        <input type="submit" value="update">
                    </div> -->
                </div>
            </div>
        </div>
    </body>
</html>