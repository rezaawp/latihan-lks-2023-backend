<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Helpers\Role;
use App\Models\Choises;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            return response()->json(Formatter::response(402, 'Validasi error', $validasi->errors()), 402);
        }

        $choises = (array)$req['choises'];

        if (count($choises) < 2) {
            return response()->json(Formatter::response(402, 'Choises must be 2 item', []), 402);
        }

        $count_array = array_count_values($choises);

        foreach ($count_array as $a) {
            if ($a > 1) {
                return response()->json(Formatter::response(402, 'Choises must unique', ['duplicate_choise' => $a]), 402);
                break;
            }
        }

        $uuid = Str::uuid();
        $data = [
            'id'            => $uuid,
            'title'         => $req['title'],
            'description'   => $req['description'],
            'deadline'      => $req['deadline'],
            'user_id'       => Auth::user()->id
        ];

        Polling::create($data);

        foreach ($choises as $c) {
            Choises::create([
                'id'                => Str::uuid(),
                'polling_id'        => $uuid,
                'choise_name'       => $c,
            ]);
        }

        $data[] = $choises;

        return response()->json(Formatter::response(200, 'Success Input', $data), 200);
    }

    public function getData()
    {
        # code...
        $data = Polling::all();
        return response()->json(Formatter::response(200, 'Success get data', $data), 200);
    }

    public function getSpecificData($id, Request $req)
    {
        $data = Polling::with(['Choises', 'Choises.Vote'])->find($id);
        if (!$data) {
            return response()->json(Formatter::response(400, 'Polling not found'), 400);
        }

        if (Role::isAdmin()) {
            $count_polling = 0;

            foreach ($data['choises'] as $c) {
                $count_polling += $c['vote'];
            }

            return [
                'dl_asli'   => $data['deadline'],
                'date_asli' => date('Y-m-d'),
                'dl'        => strtotime($data['deadline']),
                'date'      => strtotime(date('Y-m-d')),
                'logika'    => (strtotime($data['deadline']) > strtotime(date('Y-m-d')))
            ];

            if ($count_polling <= 0 && strtotime($data['deadline']) < strtotime(date('Y-m-d'))) {
                return response()->json(Formatter::response(503, "Data tidak akan kami tampilkan jika hasil polling belum ada dan tanggal tersebut belum melewati batas ketentuan"), 503);
            }

            return response()->json(Formatter::response(200, 'Get succes data (for admin)', $data), 200);
        }

        if (Role::isUser()) {
            return response()->json(Formatter::response(200, 'Get succes data', $data), 200);
        }
    }

    public function delete(Request $req)
    {
        # code...
    }
}
