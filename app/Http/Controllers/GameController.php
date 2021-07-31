<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\BoardStateConvertor;
use App\Domain\Board\Board;
use App\Domain\Game\Game;
use App\Http\Resources\GameLocationResource;
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

        $board = new Board(BoardStateConvertor::fromStringToArray($boardState));

        $game = new Game(Uuid::uuid4()->toString(), $board);

        return GameLocationResource::make($game);
    }
}
