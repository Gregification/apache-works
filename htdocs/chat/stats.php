<!DOCTYPE html>

<script src="/script1.js"></script>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <title>chat</title>
    </head>
    <body> 
        <nav class="navbar navbar-expand navbar-dark bg-black">
            <div class="container">
                <div class="dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chat stats</a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/chat/page3.php">home</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="/chat/chats.php">chat search</a></li>
                        <li><a class="dropdown-item" href="/chat/usersearch.php">user search</a></li>
                        <li><a class="dropdown-item" href="/chat/stats.php">stats</a></li>
                    </ul>
                </div>
                <div class="navbar-header">
                    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
                    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/stats.html"></script>
                </div>
            </div>
        </nav>
    </body>
</html>