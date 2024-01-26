// Initialize an empty array to store statements
$statements = [];

// if file can be read
if ($quizContent !== false) {
    // Explode the content into an array of lines
    $quizLines = explode("\n", $quizContent);

    // Loop through each line and add statements to the array
    foreach ($quizLines as $quizLine) {
        // Skip empty lines
        if (empty($quizLine)) {
            continue;
        }

        // Split the line into the statement and the correct answer
        list($statement, $correctAnswer) = explode('=', $quizLine);

        // Add the statement to the array
        $statements[$statement] = $correctAnswer === 'true'; // Store if the correct answer is true
    }

    // Store the entire $statements array in the session after the loop
    $_SESSION['quiz_statements'] = $statements;
}
