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
switch ($request) 
{
    case '':
    case '/':
        require __DIR__ . $viewDir . 'mainpage.php';
        break;
    
    case '/css':
        header('Content-Type: text/css');
        require __DIR__  . '/main.css';
        break;

    case '/results':
        echo "is it working? This thing thign should be the results";
        // require __DIR__ . $viewDir . 'contact.php';
        break;
    
    case '/leaderboard':
        echo "is it working? this should be the leaderboard";
        // require __DIR__ . $viewDir . 'contact.php';
        break;

    case '/register':
        
        // TODO
        // get data from form
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $name = strtolower(htmlspecialchars($_POST['fname']));
            $quiz = htmlspecialchars($_POST['quizType']);
            // validate name
            if (empty($name)) 
            {
                // should use ajax here for better input validation
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
                if ($quizType === 'Country' || $quizType === 'Music')
                {
                    echo "yep all values are good";
                }
                else
                {
                    echo "<h1>Something went wrong. Please try again</h1>";
                    require __DIR__ . $viewDir . 'mainpage.php';
                    break;
                }

            }
        }

        // check if user exists by reading from .txt files
        // if user doesn't exist then write new file
        // if user does exist, find existing file and extract data
        // then check if user clicked music or country quiz
        // redirect to music or country quiz
        
        // protect routes!!!

        
        break;

    default:
        http_response_code(404);
        $errorPageUrl = "https://http.cat/404";
        header("Location: $errorPageUrl");
        exit;
}
