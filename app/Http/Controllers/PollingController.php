<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollingController extends Controller
{
    //
    public function store(Request $req)
    {
        # code...
        $validasi = Validator::make($req->all(), [
            'title'         => ['required', 'string', 'min:4'],
            'description'   => ['required', 'string', 'min:7'],
            'deadline'      => ['date', 'required'],
            'choises'       => ['required', 'array']
        ]);

        if ($validasi->fails()) {
            return response()->json(Formatter::response(400, 'Validasi error', $validasi->errors()), 400);
        }

        $choises = (array)$req['choises'];

        if (count($choises) < 2) {
            return response()->json(Formatter::response(400, 'Choises must be 2 item', []), 400);
        }

        $count_array = array_count_values($choises);

        foreach ($count_array as $a) {
            if ($a > 1) {
                return response()->json(Formatter::response(400, 'Choises must unique', ['duplicate_choise' => $a]), 400);
                break;
            }
        }


        return response()->json(Formatter::response(200, 'Array count', $count_array), 200);
    }

    public function getData()
    {
        # code...
        return response()->json(Formatter::response(200, 'Success get data', ['data' => 'secret']), 200);
    }

    public function delete(Request $req)
    {
        # code...
    }
}
