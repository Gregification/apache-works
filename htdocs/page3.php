<!DOCTYPE html>

<script src="script1.js"></script>

<!-- bootstrap js src-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap css src-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <title>php fiddle</title>
    </head>
    <body> 
        <br> 
        <button onclick="loadHTML('./index.html')">1</button>
        <br>
        <div style="border-style:inset; border-color: black;">
            <div class="overflow-auto" style="min-width: 100%; min-height: 300px; max-height: 500px; background-color: turquoise; border-style: dashed; border-color: black;">
            </div>
            <div style="margin-top: 2px; margin-bottom: 2px;">
                <button onclick="sentBack(document.getElementById('chatInput').value())">send</button>
                <button> refresh </button> 
            </div>
            <script>
                function sendBack(ei){
                    //
                }   
            </script>
            <textarea id='chatInput' style="word-wrap: normal; min-width: 98%; min-height: 1.2lh; max-height:5lh; text-align: left; margin: auto; margin-left: 1%; resize:vertical;">text</textarea>
        </div>
        <!--
        <?php phpinfo(); ?>
        <p>rand JS number <script>document.write(Math.round(Math.random() * 10))</script></p>
        -->
    </body>
</html>