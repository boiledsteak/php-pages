<?php
session_start();

// Don't display errors
ini_set('display_errors', 0);
// Write errors to log
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

function headerComponent()
{
    echo '
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

function btmComponent()
{
    echo '
    <div class="btm"></div>
    ';
}

function registerComponent()
{
    echo '
        <div class="canvas">
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
        </div>
        ';
}

// Function to update user score in the file
function updateUserScoreToFile($user) 
{
    $filepath = 'testing.txt';

    // Check if the file exists
    if (file_exists($filepath)) 
    {
        // Read existing scores into an associative array
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

        // Update the user's score in the scores array
        $scores[$user->name] = $user->points;

        // Write the updated scores back to the file
        $newContent = '';
        foreach ($scores as $username => $score) 
        {
            $newContent .= "$username=$score\n";
        }
        file_put_contents($filepath, $newContent);
    }
}

// Router API
switch ($request) {

    case '/':
    {
        require __DIR__ . $viewDir . 'mainpage.php';
        headerComponent();
        registerComponent();
        btmComponent();      
        break;
    }

    case '/css':
    {
        header('Content-Type: text/css');
        require __DIR__ . '/main.css';
        break;
    }

    case '/results':
    {
        echo "is it working? This thing thign should be the results";
        break;
    }

    case '/leaderboard':
    {
        
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
                            $user->name = $name;
                            $user->points = (int)$scores[$name];
                            // Store user object in the session
                            $_SESSION['user'] = $user;
                            // redirect to music or country quiz
                            if ($quiz === 'Country') 
                            {
                                header('Location: /country');
                                exit;
                            } elseif ($quiz === 'Music') 
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
        if ($user) {
            echo "is it working? this should be the country quiz page<br>";
            echo $user->name . "<br>";
            echo $user->points . "<br>";
        } else {
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
            // Read the cquiz.txt file
            $quizFilePath = 'cquiz.txt';
            $quizContent = file_get_contents($quizFilePath);

            // Initialize an empty array to store statements
            $statements = [];

            // if file can be read
            if ($quizContent !== false) 
            {
                // Explode the content into an array of lines
                $quizLines = explode("\n", $quizContent);

                foreach ($quizLines as $quizLine) 
                {
                    if (empty($quizLine)) 
                    {
                        continue;
                    }

                    list($statement, $correctAnswer) = explode('=', $quizLine);

                    // Convert "yes" and "no" to boolean values
                    $correctAnswerBool = strtolower(trim($correctAnswer)) === 'yes';
                    $statements[] = [
                        'statement' => $statement,
                        'correctAnswer' => $correctAnswerBool,
                    ];
                }

                $_SESSION['quiz_statements'] = $statements;
            } 
            else 
            {
                // Error reading the quiz file
                error_log("Error reading quiz file");
                echo "<h1>Something went wrong!!! Please try again</h1>";
                return;
            }

            $html = '
            <div class="canvas">
                <div class="countrytitle">
                    Hello ' . htmlspecialchars($user->name) . '! This is the country quiz
                </div>
                <form action="/submit" method="post">
                    <div class="quizquestion">
                        <div class="container">                
                            <ul>';

            foreach ($statements as $statement) {
                // Skip empty statements
                if (empty($statement['statement'])) {
                    continue;
                }
            
                // Add each statement without the "=true" or "=false" part with true/false options
                $html .= '
                    <li>
                        ' . $statement['statement'] . '
                        <br>
                        <input type="radio" name="answers[' . htmlspecialchars($statement['statement']) . ']" value="true" required>
                        <label>True</label>
                        <input type="radio" name="answers[' . htmlspecialchars($statement['statement']) . ']" value="false">
                        <label>False</label>
                    </li>
                ';
                            }
            // Close the HTML
            $html .= '
                            </ul>
                        </div>
                    </div>
                    <!-- Submit button container -->
                    <div class="submit-container">
                        <!-- Submit button -->
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>';
            require __DIR__ . $viewDir . 'mainpage.php';
            headerComponent();
            echo $html;
            btmComponent();
            break;
        } 
        else 
        {
            // Redirect back
            header('Location: /');
            break;
        }
    }

    case '/submit':
        {
            // Retrieve the correct statements and answers from the session
            $correctStatements = $_SESSION['quiz_statements'] ?? [];
        
            // Check if user is logged in
            $user = $_SESSION['user'] ?? null;
        
            if ($user) 
            {
                // Get user's input statements and answers
                $userAnswers = $_POST['answers'] ?? [];
        
                // Check if any user answer is empty
                if (in_array('', $userAnswers, true)) 
                {
                    // Redirect back to /country if any answer is empty
                    header('Location: /country');
                    exit;
                }
        
                // Initialize counters for correct and wrong statements
                $correctCount = 0;
                $wrongCount = 0;
        
                // Compare user's answers with correct answers
                foreach ($correctStatements as $statement) 
                {
                    $userAnswer = $userAnswers[$statement['statement']] ?? null;
                    
                    //check if user somehow submit empty answer
                    if ($userAnswer !== null) 
                    {
                        // Check if the user's answer matches the correct answer
                        $isCorrect = ($userAnswer === 'true') === $statement['correctAnswer'];
        
                        // Update counts
                        if ($isCorrect) {
                            $correctCount++;
                        } else {
                            $wrongCount++;
                        }
                    }
                }

                // Calculate total points
                $totalPoints = ($correctCount * 4) - ($wrongCount * 2);

                // Update user's points in the session
                $user->points += $totalPoints;
                $_SESSION['user'] = $user;

                // Update user score in the file
                updateUserScoreToFile($user);
        
                // Print the counts
                require __DIR__ . $viewDir . 'mainpage.php';
                headerComponent();
                echo "<h2>Results:</h2>";
                echo "<p>Number of correct statements: $correctCount</p>";
                echo "<p>Number of wrong statements: $wrongCount</p>";
                echo "<p>Total Points: $totalPoints</p>";
                btmComponent();
                
            } 
            else 
            {
                // Redirect back if the user is not logged in
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
