<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe - Play</title>
</head>
<body>
<h2>Game between {{ $player1 }} and {{ $player2 }}</h2>
<p id="currentPlayer">Current Player: X ({{ $player1 }})</p>
<table border="1" style="width: 200px; height: 200px;">
    @for ($i = 0; $i < 3; $i++)
        <tr>
            @for ($j = 0; $j < 3; $j++)
                <td onclick="handleCellClick({{ $i }}, {{ $j }})"> <p style="height: 20px; width: 20px; display: flex; justify-content: center" id="cell{{ $i }}{{ $j }}"> </p></td>
            @endfor
        </tr>
    @endfor
</table>

@if(isset($isTie) && $isTie)
    <p>The game ended in a tie</p>
@endif

<p id="winnerDisplay"></p>
<button onclick="resetGame()">Reset</button>
<button onclick="StartNewGame()">Start New Game</button>
<script>
    function resetGame() {
        location.reload();
    }
    function StartNewGame() {
        window.location.href = '{{ route('tictactoe.index') }}';
    }
    window.onload = function () {
        fetch('{{ route('tictactoe.clearGameData') }}')
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function handleCellClick(row, col) {
        if (document.getElementById('winnerDisplay').textContent !== '') {
            return;
        }
        fetch('{{ route('tictactoe.handleMove') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ row, col }),
        })
            .then(response => response.json())
            .then(data => {
                updateBoard(data.gameBoard);
                updateCurrentPlayer(data.currentPlayer, data.player1, data.player2);
                updateWinnerDisplay(data.winner, data.player1, data.player2, data.isTie);

                if (data.isTie) {
                    document.getElementById('winnerDisplay').textContent = 'The game ended in a tie';
                }

                if (data.winner === "X") {
                    document.getElementById('winnerDisplay').textContent = `The winner is ${data.player1}`;
                }

                if (data.winner === "O") {
                    document.getElementById('winnerDisplay').textContent = `The winner is ${data.player2}`;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateBoard(gameBoard) {
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                const cellId = `cell${i}${j}`;
                document.getElementById(cellId).innerText = gameBoard[i][j];
            }
        }
    }

    function updateCurrentPlayer(currentPlayer, player1, player2) {
        const currentPlayerDisplay = document.getElementById('currentPlayer');
        const currentPlayerName = (currentPlayer === 'X') ? player1 : player2;
        currentPlayerDisplay.textContent = `Current Player: ${currentPlayer} (${currentPlayerName})`;
    }

    function updateWinnerDisplay(winner, player1, player2, isTie, message) {
        const winnerDisplay = document.getElementById('winnerDisplay');
        if (winner) {
            console.log(winner)
            const winnerName = (winner === 'X') ? player1 : player2;
            winnerDisplay.textContent = `The Winner is ${winnerName}`;
        } else if (isTie) {
            winnerDisplay.textContent = message; // Display the tie message
        } else {
            winnerDisplay.textContent = '';
        }
    }
</script>
</body>
</html>
