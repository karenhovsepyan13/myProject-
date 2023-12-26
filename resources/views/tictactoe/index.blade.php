<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
</head>
<body>
<h1>Welcome to Tic Tac Toe</h1>
<form action="{{ route('tictactoe.play') }}" method="post">
    @csrf
    <label for="player1">Player 1 Name:</label>
    <input type="text" name="player1" required>
    <br>
    <label for="player2">Player 2 Name:</label>
    <input type="text" name="player2" required>
    <br>
    <button type="submit">Start Game</button>
</form>
</body>
</html>
