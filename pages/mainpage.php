<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Funny facts</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <?php
        $route = $_SERVER['REQUEST_URI'];
        // get the header html code component from server
        $header = headerComponent();      
        // Conditionally set $component based on the route
        switch ($route) 
        {
            case '/':
                $component = registerComponent();
                break;
            case '/music':
                $component = musicComponent();
                break;
            case '/country':
                $component = countryComponent();
                break;
            // Add more cases as needed
            default:
                // Handle default case or set a default component
                $component = "<h1>Something went wrong...</h1>";
        }
    ?>
</head>
<body>
        <?php
            echo $header;
            echo $component;
        ?>
        <div class="btm"></div>
   
</body>

</html>
