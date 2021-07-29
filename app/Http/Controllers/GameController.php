<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\BoardStateStringToArrayAdapter;
use App\Domain\Board\Board;
use App\Domain\Game;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class GameController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'board' => 'required|string|size:9'
        ]);

        $boardState = $request->input('board');

        $board = new Board(BoardStateStringToArrayAdapter::adapt($boardState));

        $game = new Game(Uuid::uuid4()->toString(), $board);

        dd($game);
    }
}
