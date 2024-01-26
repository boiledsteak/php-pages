// Determine the current quiz type based on the URI
$currentQuizType = (strpos($_SERVER['REQUEST_URI'], '/country') !== false) ? 'Country' : 'Music';

// Determine the opposite quiz type based on the current quiz
$oppositeQuizType = ($currentQuizType === 'Country') ? 'Music' : 'Country';

// Prepare HTML for displaying results
$htmlResults = '
    <div class="canvas">
        <div class="countrytitle">
            Hello ' . htmlspecialchars($user->name) . '! Results for the ' . $currentQuizType . ' Quiz
        </div>
        <div class="quizresults">
            <h2>Results:</h2>
            <p>Number of correct statements: ' . $correctCount . '</p>
            <p>Number of wrong statements: ' . $wrongCount . '</p>
            <p>Total Score of your current attempts this sitting: ' . $totalPoints . '</p>
        </div>

        <div class="optionsbox">
            <div class="options">
                <a href="/' . strtolower($currentQuizType) . '">Try again</a>
            </div>
            <div class="options">
                <a href="/' . strtolower($oppositeQuizType) . '">Try ' . strtolower($oppositeQuizType) . ' quiz</a>
            </div>
        </div>
    </div>';
