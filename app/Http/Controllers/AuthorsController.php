<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        $author = Author::create($this->validateRequest());

        return redirect($book->path());
    }
}