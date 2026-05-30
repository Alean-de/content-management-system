<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;

class MessagesController extends Controller
{
     public function index()
    {
        $messages = Messages::latest()->get();

        return view(
            'administrator.messageAdm',
            compact('messages')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required']
        ]);

        Messages::create($request->only([
            'name',
            'email',
            'subject',
            'message'
        ]));

        return back()->with(
            'success',
            'Pesan berhasil dikirim'
        );
    }

    public function show(Messages $message)
    {
        return view(
            'administrator.showMessage',
            compact('message')
        );
    }

    public function delete(Messages $message)
    {
        $message->delete();

        return back()->with(
            'success',
            'Pesan berhasil dihapus'
        );
    }
}
