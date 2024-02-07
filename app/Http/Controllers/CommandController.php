<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Vars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class CommandController extends Controller
{
    public function create() {
        $varCode = Vars::find(6)->get();

        return view('vars.create', [
            'varCode' => htmlspecialchars($varCode)
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'command_code' => 'required|string',
            'command_name' => 'required|string',
            'command_signature' => 'required|string'
        ]);

        $data = [
            'command_code' => $request->input('command_code'),
            'command_name' => $request->input('command_name'),
            'command_description' => $request->input('command_description'),
            'command_signature' => $request->input('command_signature'),
            'command_options' => $request->input('command_options'),
            'command_body' => $request->input('command_body') ?? ' ',
            'command_unity_ref' => 0,
            'command_user_ref' => 0,
            'command_date_start' => now(),
            'command_date_end' => now()
        ];

        // Registra la variabile nel db
        Vars::create($data);

        Artisan::call('make:command', [
            'name' => $data['command_code'],
            '--command' => $data['command_signature']
        ]);

        // Ritorna alla schermata di creazione
        return redirect()->back();
    }

    public function execute(Request $request) {
        $result = Artisan::call('variables:get_product_qty', [
            'product_id' => 5048
        ]);
    }
}
