<?php

namespace App\Http\Controllers\Draft;

use App\Draft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DraftRequest;
use Illuminate\Support\Str;

class DraftController extends Controller
{
    public function store(DraftRequest $request)
    {
        $data = $request->validated();
        $draft = new Draft($data);
        $draft->link = Str::random(16);
        $draft->user_id = $request->user()->id;
        $draft->save();
        return response([
            'data' => $draft
        ], 200);
    }
    public function update(DraftRequest $request, Draft $draft)
    {
        $data = $request->validated();
        $draft->update($data);
        return response([
            "data" => $draft
        ], 200);
    }

    public function show(Draft $draft)
    {
        $this->authorize('show', $draft);

        return $draft;
    }

    public function destroy(Draft $draft)
    {
        $this->authorize('show', $draft);
        $draft->delete();
        return response(['data' => 'ok'], 200);
    }
}
