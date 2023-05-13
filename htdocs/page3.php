<!DOCTYPE html>

<script src="script1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <title>chat</title>
    </head>
    <body> 
        <nav class="navbar navbar-expand navbar-dark bg-black">
            <div class="container">
                <div class="dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chat</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Item 1</a></li>
                        <li><a class="dropdown-item" href="#">Item 2</a></li>
                        <li><a class="dropdown-item" href="#">Item 3</a></li>
                    </ul>
                </div>
                <div class="navbar-header">
                    <ul class="navbar-nav nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">page 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">page 2</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">page 3</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="overflow-auto" style="min-width: 100%; min-height: 300px; max-height: 500px; border-style: dashed; border-color: black;">text</div>
        <div class="contianer">
            <div class="border border-4 p-1">
                <form>
                    <div style="margin-top: 2px; margin-bottom: 2px;">
                        <button class="btn btn-primary">send</button>
                    </div>
                    <div class="input-group">
                        <textarea class="form-control" aria-label="With textarea" placeholder="message as ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">change username to</button>
                </div>
            </div>
        </div>
    </body>
</html>