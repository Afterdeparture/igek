<!DOCTYPE html>
<html>
    <head>
        <title>Igeragozó</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            h2 {color: white;}
            body {background-size: cover; background-position: center center;
                  background-image: url("Parlament.jpg");background-repeat: no-repeat;
            background-attachment: fixed;}
            #forma {padding: 200px 200px 200px 500px;}
        </style>
    </head>
    <body>
        <div id="forma">
        <form method="POST" action="Glagol.php">
            <h2><i> Unesi glagol u osnovnom obliku: <i></h2>
            <input type="text" name="ige"> <br><br>
            <input type="submit" name="submit" value="Pokazi konjugaciju">
        </form>
        </div>
    </body>
</html>
