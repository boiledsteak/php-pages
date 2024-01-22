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
    <link rel='stylesheet' type='text/css' media='screen' href='/css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <?php
        $header = new Header();
    ?>
</head>
<body>
    <div class="page">
        <?php
        $header->header();
        ?>
        <div class="canvas">
            <div class="mainpagefn">
                <form class="nameform" method="post" action="/register">
                    <div class="namebox">
                        <div class="thename">
                            Enter your nickname!
                        </div>
                            <input type="text" id="fname" name="fname">
                    </div>

                    <div class="quizprompt">
                        <p>
                        Pick a quiz
                        </p>
                    </div>
                    <div class="quizoptions">
                        <div class="quizoption">
                            <input type="submit" form="quizForm" name="quizType" value="Country"></input>
                        </div>
                        <div class="quizoption">
                            <input type="submit" form="quizForm" name="quizType" value="Music"></inputs>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>