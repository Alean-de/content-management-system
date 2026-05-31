<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;

class MessagesController extends Controller
{
     public function index(Request $request)
    {
        $messages = Messages::latest()->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $messages
            ]);
        }

        return view('administrator.messageAdm', compact('messages'));
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

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }
}
