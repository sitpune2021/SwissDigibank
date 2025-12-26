<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupCommentController extends Controller
{
     public function index( $encodedId)
    {    
         // Decode Base64 ID
    $groupId = base64_decode($encodedId, true);

    // Optional safety check
    abort_if(!$groupId || !is_numeric($groupId), 404);

    // Fetch the group
    $group = Group::findOrFail($groupId);
        $comments = $group->comments()
            ->with('user')
            ->latest()
            ->get();

        return view('groups.group-comments.index', compact('group', 'comments'));
    }

    public function store(Request $request, $encodedId)
{
    // Decode Base64 ID
    $groupId = base64_decode($encodedId, true);

    // Optional safety check
    abort_if(!$groupId || !is_numeric($groupId), 404);

    // Fetch the group
    $group = Group::findOrFail($groupId);

    // Validate input
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    // Create comment
    GroupComment::create([
        'group_id' => $group->id,
        'user_id'  => Auth::id(),
        'comment'  => $request->comment,
    ]);

    // Redirect back to comments page using Base64 again
    return redirect()
        ->route('groups.show', base64_encode($group->id))
        ->with('success', 'Comment added successfully.');
}
    // public function store(Request $request, $encodedId)
    // {
    //     // Decode Base64 ID
    // $groupId = base64_decode($encodedId, true);

    // // Optional safety check
    // abort_if(!$groupId || !is_numeric($groupId), 404);

    // // Fetch the group
    // $group = Group::findOrFail($groupId);
    //     $request->validate([
    //         'comment' => 'required|string|max:1000',
    //     ]);

    //     GroupComment::create([
    //         'group_id' => $group->id,
    //         'user_id'  => Auth::id(),
    //         'comment'  => $request->comment,
    //     ]);

    //     return redirect()
    //         ->route('groups.comments.index', $group->id)
    //         ->with('success', 'Comment added successfully.');
    // }
}
