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
        echo '<div class="thehead">
        <div class="thelogo">
            Funny facts
        </div>
        <div class="menoptions">
            <div class="menoption" >
                <a href="/results">results</a>
            </div>
            <div class="menoption">
                <a href="/leaderboard">leaderboard</a>
            </div>
            
        </div>
    </div>';
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

    default:
        http_response_code(404);
        $errorPageUrl = "https://http.cat/404";
        header("Location: $errorPageUrl");
        exit;
}
