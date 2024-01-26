// Function to update user score in the file
function updateUserScoreToFile($user) {
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

// ...

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

        // Print the counts and total points
        echo "<h2>Results:</h2>";
        echo "<p>Number of correct statements: $correctCount</p>";
        echo "<p>Number of wrong statements: $wrongCount</p>";
        echo "<p>Total Points: $totalPoints</p>";

        // Update user's points in the session
        $user->points += $totalPoints;
        $_SESSION['user'] = $user;

        // Update user score in the file
        updateUserScoreToFile($user);
    } 
    else 
    {
        // Redirect back if the user is not logged in
        header('Location: /');
        exit;
    }

    break;
}

// ...
