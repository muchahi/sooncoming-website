<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat()
    {
       
        return view('chats.about-us'); // Make sure this matches your file
    }
    

    public function messages()
    {
        return view('chats.messages'); // Matches file structure
    }
}
