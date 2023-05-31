<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(20);
        return view("admin.comments.index" , compact("comments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view("admin.comments.show" , compact("comment"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('موفق','کامنت با موفقیت حذف شد');
        return redirect()->route("admin.comments.index");
    }

    public function changeStatus(Comment $comment)
    {
        if($comment->approved == 1){
            $comment->update([
                'approved' => 0
            ]);
            alert()->warning('موفق', 'وضعیت کامنت به عدم تایید تغییر کرد')->persistent("بستن");
        }else{
            $comment->update([
                'approved' => 1
            ]);
            alert()->success('موفق', 'وضعیت کامنت به تایید شده تغییر کرد')->persistent("بستن");
        }

        return redirect()->back();
    }
}
