<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuggestionResource;
use App\Suggestion;
use App\Show;

class SuggestionController extends Controller
{
    public function show($show)
    {
        $suggestion = Suggestion::where('show_id', $show)
                    ->get();

        return SuggestionResource::collection($suggestion);
    }

    public function destroy($id)
    {
        $suggestion = Suggestion::where('show_id', $id);
        $suggestion->delete();

        return response()->json([
            'message' => 'Suggestion destroyed successfully!'
        ], 200);
    }

    public function store(Request $request)
    {
        $suggestion = $this->validate($request, [
            'show_id' => 'required',
            'suggestion' => 'required'
        ]);

        $suggestion = Suggestion::create($suggestion);

        return new SuggestionResource($suggestion);
    }

}
