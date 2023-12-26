<?php

namespace App\Http\Controllers;

use App\Models\TictactoeGame;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function index()
    {
        return view('tictactoe.index');
    }

    public function play(Request $request)
    {
        $player1 = $request->input('player1');
        $player2 = $request->input('player2');

        $players = [$player1, $player2];
        shuffle($players);
        [$player1, $player2] = $players;

        $gameBoard = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];

        $request->session()->put('gameBoard', $gameBoard);
        $request->session()->put('currentPlayer', 'X');
        $request->session()->put('player1', $player1);
        $request->session()->put('player2', $player2);
        $initialGameState = TictactoeGame::orderBy('created_at', 'desc')->first();
        return view('tictactoe.play', compact('player1', 'player2','initialGameState'));
    }

    public function handleMove(Request $request)
    {
        $row = $request->input('row');
        $col = $request->input('col');

        $gameBoard = $request->session()->get('gameBoard');
        $currentPlayer = $request->session()->get('currentPlayer');
        $player1 = $request->session()->get('player1');
        $player2 = $request->session()->get('player2');



        $currentPlayerName = ($currentPlayer == 'X') ? $player1 : $player2;
        TictactoeGame::create([
            'player_1' => $player1,
            'player_2' => $player2,
            'values' => $currentPlayer,
            'current_player' => $currentPlayerName,
            'row' => $row,
            'col' => $col,
        ]);

        if ($gameBoard[$row][$col] === '') {
            $gameBoard[$row][$col] = $currentPlayer;
            $winner = $this->checkForWinner($gameBoard);
            $isTie = $this->checkForTie($gameBoard, $winner);
            $currentPlayer = ($currentPlayer === 'X') ? 'O' : 'X';
            $request->session()->put('gameBoard', $gameBoard);
            $request->session()->put('currentPlayer', $currentPlayer);

            $responseData = [
                'gameBoard' => $gameBoard,
                'currentPlayer' => $currentPlayer,
                'winner' => $winner,
                'isTie' => $isTie,
                'player1' => $player1,
                'player2' => $player2,
            ];

            if ($isTie) {
                $responseData['message'] = 'The game ended in a tie';
            }

            return response()->json($responseData);
        }

        return response()->json(['error' => 'Invalid move']);
    }

    public function clearGameData()
    {
        TictactoeGame::truncate();
    }
    private function checkForWinner($gameBoard)
    {
        for ($i = 0; $i < 3; $i++) {
            if ($gameBoard[$i][0] == $gameBoard[$i][1] && $gameBoard[$i][1] == $gameBoard[$i][2] && $gameBoard[$i][0] != '') {
                return $gameBoard[$i][0];
            }
            if ($gameBoard[0][$i] == $gameBoard[1][$i] && $gameBoard[1][$i] == $gameBoard[2][$i] && $gameBoard[0][$i] != '') {
                return $gameBoard[0][$i];
            }
        }
        if ($gameBoard[0][0] == $gameBoard[1][1] && $gameBoard[1][1] == $gameBoard[2][2] && $gameBoard[0][0] != '') {
            return $gameBoard[0][0];
        }
        if ($gameBoard[0][2] == $gameBoard[1][1] && $gameBoard[1][1] == $gameBoard[2][0] && $gameBoard[0][2] != '') {
            return $gameBoard[0][2];
        }
        return null;
    }

    private function checkForTie($gameBoard, $winner)
    {
        if ($winner === null) {
            foreach ($gameBoard as $row) {
                if (in_array('', $row)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
