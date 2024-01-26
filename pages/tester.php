// ... (previous code)

case '/submitmusic':
{
    // Retrieve the correct answers and user input from the session
    $correctAnswers = $_SESSION['quiz_questions'] ?? [];
    $userAnswers = $_POST['answers'] ?? [];

    // Check if user is logged in
    $user = $_SESSION['user'] ?? null;

    if ($user) 
    {
        // Check if any user answer is empty
        if (in_array('', $userAnswers, true)) 
        {
            // Redirect back to /music if any answer is empty
            header('Location: /music');
            exit;
        }

        // Initialize counters for correct and wrong answers
        $correctCount = 0;
        $wrongCount = 0;

        // Prepare HTML for displaying results
        $htmlResults = '
        <div class="canvas">
            <div class="countrytitle">
                Hello ' . htmlspecialchars($user->name) . '! Results for the Music Quiz
            </div>
            <div class="quizresults">
                <h2>Results:</h2>
                <ul>';

        // Compare user's answers with correct answers
        foreach ($correctAnswers as $index => $question) 
        {
            // Skip empty questions
            if (empty($question['path'])) 
            {
                continue;
            }

            // Get user's answer for the current question
            $userAnswer = $userAnswers[$index] ?? '';

            // Check if the user's answer matches the correct answer
            $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question['correctAnswer']));
            
            // Update counts and prepare HTML for each result
            if ($isCorrect) 
            {
                $correctCount++;
                $htmlResults .= '<li class="correct">Question ' . ($index + 1) . ': Correct!</li>';
            } 
            else 
            {
                $wrongCount++;
                $htmlResults .= '<li class="wrong">Question ' . ($index + 1) . ': Incorrect. Correct Answer: ' . htmlspecialchars($question['correctAnswer']) . '</li>';
            }
        }

        // Calculate total points
        $totalPoints = ($correctCount * 4) - ($wrongCount * 2);

        // Update user's points in the session
        $user->points += $totalPoints;
        $_SESSION['user'] = $user;

        // Update user score in the file
        updateUserScoreToFile($user);

        // Append the total points to the HTML results
        $htmlResults .= '
            </ul>
            <p>Total Points: ' . $totalPoints . '</p>
        </div>
        </div>';

        // Display results
        require __DIR__ . $viewDir . 'mainpage.php';
        headerComponent();
        echo $htmlResults;
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

// ... (remaining code)
