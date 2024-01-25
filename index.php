<?php
session_start();

//don't display errors
ini_set('display_errors', 0);
//write errors to log
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$request = strtolower($_SERVER['REQUEST_URI']);
$viewDir = '/pages/';

// Define the User class
class User 
{
    public $name;
    public $points;

    public function __construct($name = 'x', $points = 0)
    {
        $this->name = $name;
        $this->points = $points;
    }
}

// // Create an instance of the User class
// $user = new User();

//prints the header component
function headerComponent() 
{
    echo 
    '
    <div class="outerhead">
        <div class="thehead">
            <a class="thelogo" href="/">
                Funny facts
            </a>
            <div class="menoptions">
                <div class="menoption">
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

function registerComponent()
{
    echo
    '
    <div class="mainpagefn">
        <form class="nameform" method="post" action="/register">
            <div class="namebox">
                <div class="thename">
                    Enter your nickname!
                </div>
                <input type="text" id="fname" name="fname" required>
            </div>

            <div class="quizprompt">
                <p>
                    Pick a quiz
                </p>
            </div>
            <div class="quizoptions">
                <div class="quizoption">
                    <input class="hvr-wobble-skew" type="submit" name="quizType" value="Country">
                </div>
                <div class="quizoption">
                    <input class="hvr-wobble-skew" type="submit" name="quizType" value="Music">
                </div>
            </div>
        </form>
    </div>
    ';
}

//router API
switch ($request) 
{
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
            // get data from form
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $name = strtolower(htmlspecialchars($_POST['fname']));
                $quiz = htmlspecialchars($_POST['quizType']);
                
                // create an instance of the User class
                $user = new User();
        
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
                    if ($quiz === 'Country' || $quiz === 'Music') 
                    {
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
                                if (!empty($line))
                                {
                                    $parts = explode('=', $line);
                                    $username = $parts[0];
                                    $score = $parts[1];
                                    $scores[$username] = $score;
                                }
                            }
        
                            // Check if the entered nickname exists in the array
                            if (array_key_exists($name, $scores)) 
                            {
                                // Output the username and score for the entered nickname
                                echo "User found!<br>";
        
                                $user->name = $name;
                                $user->points = (int)$scores[$name];
        
                                echo 'Username: ' . $user->name . ", Score: " . $user->points . "<br>";
                                // Store user object in the session
                                $_SESSION['user'] = $user;
                                // redirect to music or country quiz
                                if ($quiz === 'Country') 
                                {
                                    header('Location: /country');
                                    exit;
                                } 
                                elseif ($quiz === 'Music') 
                                {
                                    header('Location: /music');
                                    exit;
                                }
                            }
                            else 
                            {
                                // User not found                               
                                // Append the user's input nickname and a default score of 90 to the file
                                $newEntry = "$name=0\n";
                                file_put_contents($filepath, $newEntry, FILE_APPEND);
        
                                $user->name = $name;
                                $user->points = 0;
        
                                // Display a message about the appended entry
                                echo 'User added! Username: ' . $user->name . ", Score: " . $user->points . "<br>";
                                // Store user object in the session
                                $_SESSION['user'] = $user;
                                // redirect to music or country quiz
                                if ($quiz === 'Country') 
                                {
                                    header('Location: /country');
                                    exit;
                                } 
                                elseif ($quiz === 'Music') 
                                {
                                    header('Location: /music');
                                    exit;
                                }
                            }
                        } 
                        else 
                        {
                            // File does not exist or error with file reading
                            echo "<h1>Something went wrong!!! Please try again</h1>";
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
            break;
        }

    case '/music':
        {
            // Retrieve user object from the session
            $user = $_SESSION['user'] ?? null;
            // Check if user is logged in
            if ($user) 
            {
                echo "is it working? this should be the country quiz page<br>";
                echo $user->name . "<br>";
                echo $user->points . "<br>";
            } 
            else 
            {
                // Redirect back
                header('Location: /');
                exit;
            }
            break;
        }

    case '/country':
        {
            // Retrieve user object from the session
            $user = $_SESSION['user'] ?? null;
            // Check if user is logged in
            if ($user) 
            {
                echo "is it working? this should be the country quiz page<br>";
                echo $user->name . "<br>";
                echo $user->points . "<br>";

                // Read the cquiz.txt file
                $quizFilePath = 'cquiz.txt';
                $quizContent = file_get_contents($quizFilePath);

                // if file can be read
                if ($quizContent !== false)
                {
                    // Explode the content into an array of lines
                    $quizLines = explode("\n", $quizContent);

                    // Loop through each line and prompt the user
                    foreach ($quizLines as $quizLine) 
                    {
                        // Skip empty lines
                        if (empty($quizLine)) 
                        {
                            continue;
                        }

                        // Split the line into the statement and the correct answer
                        list($statement, $correctAnswer) = explode('=', $quizLine);

                        // Output the statement and prompt the user
                        echo $statement . '<br>';
                        echo 'True or False? <br>';

                        // Add logic here to handle the user's input (true/false)
                        // For example, you can have a form with radio buttons for each statement.

                       
                    }
                }
                else 
                {
                    // Error reading the quiz file
                    error_log("Error reading quiz file");
                    echo "<h1>Something went wrong!!! Please try again</h1>";
                    require __DIR__ . $viewDir . 'mainpage.php';
                    break;

                }

                
            } 
            else 
            {
                // Redirect back
                header('Location: /');
                exit;
            }
            break;
        }


    default:
    {
        http_response_code(404);
        $errorPageUrl = "https://http.cat/404";
        header("Location: $errorPageUrl");
        exit;
    }
}
