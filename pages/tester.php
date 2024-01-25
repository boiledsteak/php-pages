// Function to generate the country component HTML
function getCountryComponent(array $statements)
{
    $html = '
        <div class="canvas">
            <div class="countrytitle">
                Hello John! This is the country quiz
            </div>
            <form action="/submit" method="post">
                <div class="quizquestion">
                    <div class="container">                
                        <ul>';

    foreach ($statements as $statement) {
        // Skip empty statements
        if (empty($statement)) {
            continue;
        }

        // Add each statement with true/false options
        $html .= '
                            <li>
                                ' . $statement . '
                            </li>
                            <li>
                                <input type="radio" name="answers[' . htmlspecialchars($statement) . ']" value="true">
                                <label>True</label>
                            </li>
                            <li>
                                <input type="radio" name="answers[' . htmlspecialchars($statement) . ']" value="false">
                                <label>False</label>
                            </li>';
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

    return $html;
}

// Example statements array
$statements = [
    "Singapore is the world's only island city-state=true",
    "It is illegal to sell chewing gum in Singapore=true",
    "Singapore has merlions=true",
    "Malaysia has twin towers=true",
    "Najib is Malaysia's national treasure=true",
    "Malaysia to Singapore 3:1=true",
    "Japan is the leader in the porn industry=true",
    "Most Japanese don't consider prostitution as cheating=true",
];

// Output the country component with the provided statements
echo getCountryComponent($statements);
