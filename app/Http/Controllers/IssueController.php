<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Issue;
use Illuminate\Http\Response;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Issue::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate(['title' => 'required|string', 'description' => 'required|string']);
        return Issue::create($data, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $issue = Issue::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }
        return $issue;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = request()->validate(['title' => 'string', 'description' => 'string', 'status' => 'string:in' . implode(',', ['open', 'closed', 'in-progress'])]);
        try {

            $issue = Issue::findOrFail($id);

        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'message' => 'The issue was not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $issue->update($validatedData);
        return $issue;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // throws an error (not a nice message to the client) if find fails
            $issue = Issue::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['message' => 'Issue has been deleted already'], Response::HTTP_NOT_FOUND);
        }
        // destroy -> present on class, delete -> present on instance
        $issue->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);

    }
}