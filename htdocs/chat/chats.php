<!DOCTYPE html>

<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("location: /chat/page3.php");
    }
?>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="/script1.js"></script>
        <title>chat</title>
    </head>
    <body style="background-color: #61c8d6"> 
        <nav class="navbar navbar-expand navbar-dark bg-black">
            <div class="container">
                <div class="dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chat: chats</a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/chat/page3.php">chat</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="/chat/usersearch.php">user search</a></li>
                        <li><a class="dropdown-item" href="/chat/stats.php">stats</a></li>
                    </ul>
                </div>
                <div class="navbar-header">
                    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
                    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.php"></script>
                </div>
            </div>
        </nav>

        <div class="container">
            <form action="#">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for chats ... (regex accepted)" name="title">
                    <button class="btn" style=" background-color: #79adcf" type="submit">Search</button>
                </div>
            </form> 
        </div>
        <br>

        <!-- chat table -->
        <table class="table table-info table-hover">
            <thread>
                <th>icon</th>
                <th>name</th>
                <th># online</th>
                <th>creation date</th>
                <th>first event</th>
                <th>latest event</th>
            </thread>
            <tbody>
                <tr>
                    <td><a href="/chat/chats.html"><img class="rounded-0" src="/icon/default/icon.png"></a>                    </td>
                    <td><a href="/chat/chats.html">chatname</a></td>
                    <td>#</td>
                    <td>date</td>
                    <td>time</td>
                    <td>time</td>
                </tr>
            </tbody>
        </table>

    </body>
</html>