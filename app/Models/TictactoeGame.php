<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TictactoeGame extends Model
{
use HasFactory;

protected $fillable = [
'player_1',
'player_2',
'values',
'current_player',
'row',
'col',
];

// Add any additional methods or relationships here if needed
}
