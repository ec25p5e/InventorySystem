<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocsController extends Controller
{
    public function index()
    {
        $docusaurusPath = public_path('public/docs/build');

        if (File::isDirectory($docusaurusPath)) {
            $content = File::get($docusaurusPath . '/index.html');
            return response($content)->header('Content-Type', 'text/html');
        } else {
            abort(404, 'Documentazione non trovata');
        }
    }
}
