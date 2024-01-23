<?php
//don't display errors
ini_set('display_errors', 0);
//write errors to log
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$request = strtolower($_SERVER['REQUEST_URI']);
$viewDir = '/pages/';

//classes

//prints the header component
class Header 
{
    public function header() 
    {
        echo 
        '
        <div class="outerhead">
            <div class="thehead">
                <a class="thelogo" href="/">
                    Funny facts
                </a>
                <div class="menoptions">
                    <div class="menoption" >
                        <a href="/results">results</a>
                    </div>
                    <div class="menoption">
                        <a href="/leaderboard">leaderboard</a>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}

//router
switch ($request) {
    case '':
    case '/':
        {
            require __DIR__ . $viewDir . 'mainpage.php';
            break;
        }

    case '/css':
        {
            header('Content-Type: text/css');
            require __DIR__  . '/main.css';
            break;
        }

    case '/results':
        {
            echo "is it working? This thing thign should be the results";
            // require __DIR__ . $viewDir . 'contact.php';
            break;
        }

    case '/leaderboard':
        {
            echo "is it working? this should be the leaderboard";
            // require __DIR__ . $viewDir . 'contact.php';
            break;
        }

    case '/register':
        {
            // TODO
            // get data from form
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $name = strtolower(htmlspecialchars($_POST['fname']));
                $quiz = htmlspecialchars($_POST['quizType']);
                
                // validate name
                if (empty($name)) 
                {
                    echo "<h1>Please enter name!!!!</h1>";
                    require __DIR__ . $viewDir . 'mainpage.php';
                    break;
                } 
                elseif (!preg_match("/^[a-zA-Z]*$/", $name)) 
                {
                    echo "<h1>Only letters allowed !!!! And no whitespace</h1>";
                    require __DIR__ . $viewDir . 'mainpage.php';
                    break;
                } 
                else 
                {
                    // validate quiz type
                    if ($quiz === 'Country' || $quiz === 'Music') {
                        $filepath = 'testing.txt';

                        // Check if the file exists
                        if (file_exists($filepath)) 
                        {
                            // Read file content into an associative array
                            $fileContent = file_get_contents($filepath);
                            $lines = explode("\n", $fileContent);

                            $scores = array();
                            foreach ($lines as $line) 
                            {
                                $parts = explode('=', $line);
                                $username = trim($parts[0]);
                                $score = trim($parts[1]);
                                $scores[$username] = $score;
                            }

                            // Check if the entered nickname exists in the array
                            if (array_key_exists($name, $scores)) 
                            {
                                // Output the username and score for the entered nickname
                                echo "User found!<br>";
                                echo "Username: $name, Score: " . $scores[$name] . "<br>";
                            } 
                            else 
                            {
                                // User not found
                                echo "<h1>User not found</h1>";
                                require __DIR__ . $viewDir . 'mainpage.php';
                                break;
                            }
                        } 
                        else 
                        {
                            // File does not exist
                            echo "<h1>File not found</h1>";
                            require __DIR__ . $viewDir . 'mainpage.php';
                            break;
                        }
                    } 
                    else 
                    {
                        // quiz type not country or music
                        echo "<h1>Invalid quiz type. Please try again</h1>";
                        require __DIR__ . $viewDir . 'mainpage.php';
                        break;
                    }
                }
            }
        }

        // then check if user clicked music or country quiz
        // redirect to music or country quiz
        
        // protect routes!!!

        break;

    default:
    {
        http_response_code(404);
        $errorPageUrl = "https://http.cat/404";
        header("Location: $errorPageUrl");
        exit;
    }
}

