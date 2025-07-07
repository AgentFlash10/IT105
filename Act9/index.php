<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Analyzer</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        textarea {
            width: 100%;
            height: 200px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            resize: vertical;
            transition: border-color 0.3s;
        }
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
            display: block;
            margin: 20px auto;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .results {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #667eea;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #666;
            font-size: 0.9em;
        }
        .detailed-analysis {
            margin-top: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .word-frequency {
            margin-top: 20px;
        }
        .frequency-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .sample-text {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2196f3;
        }
        .sample-text h4 {
            margin-top: 0;
            color: #1976d2;
        }
        .sample-text p {
            margin: 10px 0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Text Analyzer</h1>
        
        <?php
        // ============================================
        // PHP TEXT ANALYZER - MAIN LOGIC
        // ============================================
        
        // Initialize variables to store user input and analysis results
        $text = "";           // Variable to hold the text entered by user
        $analysis = null;     // Variable to store the analysis results (null means no analysis yet)
        
        // Check if the form was submitted using POST method and if text was provided
        // $_SERVER["REQUEST_METHOD"] tells us which HTTP method was used (GET or POST)
        // $_POST["text"] contains the text from the form field named "text"
        // !empty() checks if the text field is not empty
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["text"])) {
            // trim() removes extra spaces from beginning and end of the text
            $text = trim($_POST["text"]);
            
            // Call our custom function to analyze the text
            $analysis = analyzeText($text);
        }
        
        // ============================================
        // CUSTOM FUNCTION: analyzeText()
        // This function performs all the text analysis calculations
        // ============================================
        function analyzeText($text) {
            // Create an empty array to store all analysis results
            $analysis = array();
            
            // ============================================
            // BASIC TEXT COUNTS
            // ============================================
            
            // Count total characters (including spaces, punctuation, etc.)
            $analysis['characters'] = strlen($text);
            
            // Count characters excluding spaces
            // str_replace(' ', '', $text) removes all spaces from the text
            $analysis['characters_no_spaces'] = strlen(str_replace(' ', '', $text));
            
            // Count total words using PHP's built-in function
            $analysis['words'] = str_word_count($text);
            
            // Count sentences using regular expression
            // preg_match_all() finds all matches of the pattern
            // '/[.!?]+/' matches one or more periods, exclamation marks, or question marks
            $analysis['sentences'] = preg_match_all('/[.!?]+/', $text);
            
            // Count paragraphs by splitting on double line breaks
            // explode("\n\n", $text) splits text into array at double line breaks
            // array_filter() removes empty elements
            // count() counts the remaining elements
            $analysis['paragraphs'] = count(array_filter(explode("\n\n", $text)));
            
            // Count lines by counting newline characters and adding 1
            // substr_count() counts how many times "\n" appears in the text
            $analysis['lines'] = substr_count($text, "\n") + 1;
            
            // ============================================
            // ADVANCED CALCULATIONS
            // ============================================
            
            // Calculate average word length
            // str_word_count($text, 1) returns an array of words (not just count)
            $words = str_word_count($text, 1);
            $totalWordLength = 0;
            
            // Loop through each word and add up their lengths
            foreach ($words as $word) {
                $totalWordLength += strlen($word);
            }
            
            // Calculate average: total length divided by number of words
            // round() rounds to 2 decimal places
            // Check if $words array is not empty to avoid division by zero
            $analysis['avg_word_length'] = $words ? round($totalWordLength / count($words), 2) : 0;
            
            // Calculate reading time (assumes average reading speed of 200 words per minute)
            // ceil() rounds up to the nearest whole number
            $analysis['reading_time'] = ceil($analysis['words'] / 200);
            
            // ============================================
            // WORD FREQUENCY ANALYSIS
            // ============================================
            
            // Find most common words
            // array_map('strtolower', $words) converts all words to lowercase
            // array_count_values() counts how many times each word appears
            $wordCount = array_count_values(array_map('strtolower', $words));
            
            // arsort() sorts array in descending order (most frequent first)
            arsort($wordCount);
            
            // array_slice() gets only the first 10 most common words
            // The 'true' parameter preserves the original keys
            $analysis['common_words'] = array_slice($wordCount, 0, 10, true);
            
            // ============================================
            // CHARACTER FREQUENCY ANALYSIS
            // ============================================
            
            // Find most common characters
            // str_split() splits the text into individual characters
            // strtolower() converts all characters to lowercase
            $charCount = array_count_values(str_split(strtolower($text)));
            
            // Sort by frequency (most common first)
            arsort($charCount);
            
            // Get top 10 most common characters
            $analysis['char_frequency'] = array_slice($charCount, 0, 10, true);
            
            // ============================================
            // TEXT STATISTICS
            // ============================================
            
            // Count unique words (vocabulary size)
            // array_unique() removes duplicate words
            $analysis['unique_words'] = count(array_unique(array_map('strtolower', $words)));
            
            // Calculate lexical diversity (percentage of unique words)
            // This shows how varied the vocabulary is
            // Formula: (unique words / total words) * 100
            $analysis['lexical_diversity'] = $analysis['words'] ? round(($analysis['unique_words'] / $analysis['words']) * 100, 2) : 0;
            
            // Return the complete analysis array
            return $analysis;
        }
        ?>
        
        <!-- Sample Text Section -->
        <div class="sample-text">
            <h4>💡 Try this sample text:</h4>
            <p>"The quick brown fox jumps over the lazy dog. This pangram contains every letter of the alphabet at least once. It's commonly used to test fonts and keyboards. The sentence is both meaningful and comprehensive."</p>
        </div>
        
        <!-- ============================================
             HTML FORM SECTION
             This form collects text input from the user
             ============================================ -->
        <form method="POST" action="">
            <!-- Form group for the textarea -->
            <div class="form-group">
                <!-- Label for accessibility and user guidance -->
                <label for="text">Enter your text to analyze:</label>
                
                <!-- Textarea for text input
                     name="text" - This name is used in $_POST["text"] to access the data
                     id="text" - Links to the label for accessibility
                     placeholder - Shows hint text when textarea is empty
                     The PHP echo inside preserves the text if form is resubmitted -->
                <textarea 
                    name="text" 
                    id="text" 
                    placeholder="Paste or type your text here..."><?php echo htmlspecialchars($text); ?></textarea>
            </div>
            
            <!-- Submit button to send the form data -->
            <button type="submit" class="btn">🔍 Analyze Text</button>
        </form>
        
        <?php if ($analysis): ?>
        <!-- ============================================
             DISPLAY ANALYSIS RESULTS
             This section shows the calculated statistics in a grid layout
             ============================================ -->
        <div class="results">
            <!-- Display word count -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['words']; ?></div>
                <div class="stat-label">Words</div>
            </div>
            
            <!-- Display total character count (including spaces) -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['characters']; ?></div>
                <div class="stat-label">Characters</div>
            </div>
            
            <!-- Display character count excluding spaces -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['characters_no_spaces']; ?></div>
                <div class="stat-label">Characters (no spaces)</div>
            </div>
            
            <!-- Display sentence count -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['sentences']; ?></div>
                <div class="stat-label">Sentences</div>
            </div>
            
            <!-- Display paragraph count -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['paragraphs']; ?></div>
                <div class="stat-label">Paragraphs</div>
            </div>
            
            <!-- Display line count -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['lines']; ?></div>
                <div class="stat-label">Lines</div>
            </div>
            
            <!-- Display average word length -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['avg_word_length']; ?></div>
                <div class="stat-label">Avg Word Length</div>
            </div>
            
            <!-- Display estimated reading time -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['reading_time']; ?></div>
                <div class="stat-label">Reading Time (min)</div>
            </div>
            
            <!-- Display unique word count -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['unique_words']; ?></div>
                <div class="stat-label">Unique Words</div>
            </div>
            
            <!-- Display lexical diversity percentage -->
            <div class="stat-card">
                <div class="stat-number"><?php echo $analysis['lexical_diversity']; ?>%</div>
                <div class="stat-label">Lexical Diversity</div>
            </div>
        </div>
        
        <!-- ============================================
             DETAILED ANALYSIS SECTION
             This section shows word frequency, character frequency, and text insights
             ============================================ -->
        <div class="detailed-analysis">
            <h3>📈 Detailed Analysis</h3>
            
            <!-- ============================================
                 MOST COMMON WORDS SECTION
                 Loops through the array of common words and displays them
                 ============================================ -->
            <div class="word-frequency">
                <h4>🔤 Most Common Words:</h4>
                <?php 
                // Loop through each word and its count in the common_words array
                // $word is the word itself, $count is how many times it appears
                foreach ($analysis['common_words'] as $word => $count): ?>
                    <?php 
                    // Only show words that are longer than 2 characters
                    // This filters out very short words like "a", "an", "the", etc.
                    if (strlen($word) > 2): ?>
                    <div class="frequency-item">
                        <!-- htmlspecialchars() prevents XSS attacks by converting special characters -->
                        <span><strong><?php echo htmlspecialchars($word); ?></strong></span>
                        <span><?php echo $count; ?> times</span>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- ============================================
                 CHARACTER FREQUENCY SECTION
                 Shows which letters appear most often in the text
                 ============================================ -->
            <div class="word-frequency">
                <h4>🔤 Most Common Characters:</h4>
                <?php 
                // Loop through each character and its count
                foreach ($analysis['char_frequency'] as $char => $count): ?>
                    <?php 
                    // ctype_alpha() checks if the character is a letter (a-z, A-Z)
                    // This filters out numbers, punctuation, and spaces
                    if (ctype_alpha($char)): ?>
                    <div class="frequency-item">
                        <span><strong><?php echo htmlspecialchars($char); ?></strong></span>
                        <span><?php echo $count; ?> times</span>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- ============================================
                 TEXT INSIGHTS SECTION
                 Provides intelligent analysis and suggestions based on the text statistics
                 ============================================ -->
            <div class="word-frequency">
                <h4>💡 Text Insights:</h4>
                <ul>
                    <?php 
                    // Analyze average word length and provide feedback
                    // If average word length is greater than 6, consider it "long words"
                    if ($analysis['avg_word_length'] > 6): ?>
                        <li>Your text uses relatively long words (average: <?php echo $analysis['avg_word_length']; ?> characters)</li>
                    <?php else: ?>
                        <li>Your text uses relatively short words (average: <?php echo $analysis['avg_word_length']; ?> characters)</li>
                    <?php endif; ?>
                    
                    <?php 
                    // Analyze lexical diversity (vocabulary variety)
                    // If more than 70% of words are unique, it's considered "high diversity"
                    if ($analysis['lexical_diversity'] > 70): ?>
                        <li>High lexical diversity (<?php echo $analysis['lexical_diversity']; ?>%) - varied vocabulary</li>
                    <?php else: ?>
                        <li>Moderate lexical diversity (<?php echo $analysis['lexical_diversity']; ?>%) - some word repetition</li>
                    <?php endif; ?>
                    
                    <?php 
                    // Provide reading time feedback
                    // Use singular "minute" for 1 minute, plural "minutes" for others
                    if ($analysis['reading_time'] <= 1): ?>
                        <li>Quick read: approximately <?php echo $analysis['reading_time']; ?> minute</li>
                    <?php else: ?>
                        <li>Reading time: approximately <?php echo $analysis['reading_time']; ?> minutes</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Instructions -->
        <div class="sample-text">
            <h4>📝 How to use:</h4>
            <ul>
                <li>Paste or type any text in the textarea above</li>
                <li>Click "Analyze Text" to get detailed statistics</li>
                <li>View word count, character count, reading time, and more</li>
                <li>See the most common words and characters in your text</li>
                <li>Get insights about your writing style and vocabulary</li>
            </ul>
        </div>
    </div>
</body>
</html> 