<?php
// Start the session to store game state across page reloads
session_start();

// Check if a new game should be started
if (!isset($_SESSION['number']) || isset($_POST['new_game'])) {
    // Generate a random number between 1 and 100
    $_SESSION['number'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
    $_SESSION['message'] = "I've picked a number between 1 and 100. Try to guess it!";
}

// Check if a guess has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guess'])) {
    $guess = (int)$_POST['guess'];
    $_SESSION['attempts']++;

    // Compare the guess to the number
    if ($guess > $_SESSION['number']) {
        $_SESSION['message'] = "Too high! Try again.";
    } elseif ($guess < $_SESSION['number']) {
        $_SESSION['message'] = "Too low! Try again.";
    } else {
        $_SESSION['message'] = "Congratulations! You guessed the number {$_SESSION['number']} in {$_SESSION['attempts']} attempts!";
        unset($_SESSION['number']); // End game
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guess the Number Game</title>
</head>
<body>
    <h1>Guess the Number Game</h1>
    <p><?php echo $_SESSION['message']; ?></p>

    <!-- Only show the guess form if the game is still active -->
    <?php if (isset($_SESSION['number'])): ?>
        <form method="POST" action="">
            <label for="guess">Enter your guess:</label>
            <input type="number" id="guess" name="guess" required min="1" max="100">
            <button type="submit">Submit Guess</button>
        </form>
    <?php endif; ?>

    <!-- Button to start a new game -->
    <form method="POST" action="">
        <button type="submit" name="new_game">Start New Game</button>
    </form>
</body>
</html>