<!DOCTYPE html>

<?php
    session_start();
    if(!isset($_SESSION['username'])) header("location: /chat/page3.php");
?>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="/chat/chats.js"></script>
        <title>chat search</title>
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
            <form id="form-search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for chats(POSIX regex kinda accepted) ..." name="title" value="<?php echo $_GET['title'] ?? null ?>">
                    <button class="btn" style=" background-color: #d1e76f" type="submit">Search</button>
                </div>
                <div class="row">
                    <lable for="cmpari">Compair against</lable>
                    <div class="input-group col">
                        <select class="form-select" name="cmpari" id="cmpari">
                            <option selected value="username">Title</option>
                            <option value="description">Description</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="orderBy">Order By</label>
                        <div class="input-group">
                            <select class="form-select" name="orderBy" id="orderBy">
                                <option selected value="title">title</option>
                                <option value="usersonline">num users online</option>
                                <option value="creationtime">Creation date</option>
                                <option value="lastactivetime">Last event</option>
                                <option value="description">Description</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label for="orderBy">Sort</label>
                        <div class="input-group">
                            <select class="form-select" name="dr" id="dr">
                                <option <?php echo (($_GET['dr']??null)=='asc'?'selected':'') ?> value="asc">Acending</option>
                                <option <?php echo (($_GET['dr']??null)=='desc'?'selected':'') ?> value="desc">Decending</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col">
                        <label for="batchsize">Batch size</label>
                        <select class="form-select" name="batchsize" id="batchsize">
                            <option value="all">All</option>
                            <option value="5">5</option>
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="40">40</option>
                        </select>
                    </div> -->
                </div>
            </form> 
        </div>
        <br>

        <!-- chat table -->
        <table class="table table-info table-hover">
            <colgroup width=100%>
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
                <col width="5%"><col width="5%">
            </colgroup>
            <thread>
                <th colspan="4">Icon</th>
                <th colspan="5">Title</th>
                <th colspan="3"># Online</th>
                <!-- <th>Creation date</th>
                <th>Latest event</th> -->
                <th colspan="8">Description</th>
            </thread>
            <tbody id="tbody">
                <template>
                    <tr>
                        <td colspan="4"><a href="/chat/chats.html"><img class="rounded-0" src="/icon/default/icon.png"></a></td>
                        <td colspan="5"><a href="/chat/chats.html">tutle</a></td>
                        <td colspan="3">#online</td>
                        <!-- <td>date</td>
                        <td>time</td> -->
                        <td colspan="8">description</td>
                    </tr>
                </template>
            </tbody>
        </table>
        <center>
            <button id="loadmore">load more</button>
            <button id="toDtop!">to top</button>
        </center>

    </body>
</html>