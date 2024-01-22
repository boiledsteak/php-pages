<!-- 

Timothy Mah
web server programming assignment 1
22 Jan 2024

 -->

<!-- 
notes:
music is open ended while country is true false 

-->

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Funny facts</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    
</head>
<body>
    <b>
        Hullo testing some php code
    </b>
    <div>
    <?php
        for ($i = 0; $i < 5; $i++) 
        {
            echo "this is the count\t" . strval($i) . "<br>"; 
        }
    ?>
    </div>
</body>
</html>