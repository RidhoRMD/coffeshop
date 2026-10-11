<?php

namespace App\Http\Controllers;

use App\Services\TandaPembaruan;

class PembaruanController extends Controller
{
    public function __invoke()
    {
        return response()->json(['tanda' => TandaPembaruan::pesanan()]);
    }
}