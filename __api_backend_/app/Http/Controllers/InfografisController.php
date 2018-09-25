<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Infografis;

use Carbon;

class InfografisController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        $offset = 5;

        if ($request->input('p')) {
            $page = $request->p - 1;
        } else {
            $page = 0;
        }

        $infografis = Infografis::skip($page * $offset)->take($offset + 1)->orderBy('id', 'desc')->get()->toArray();

        $more = false;
        if (sizeof($infografis) > 5)
            $more = true;

        return [
            'status' => 'Success',
            'more' => $more,
            'data' => array_slice($infografis, 0, 5)
        ];
    }


    /**
     * Get one by id
     */
    public function show($id) {
        try {
            $infografis = Infografis::where('id', $id)->firstOrFail();

            return [
                'status' => 'Success',
                'data' => [$infografis]
            ];
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error: '.$e->getMessage()];
        }
    }


    /**
     * Insert new
     */
    public function store(Request $request) {
        $file = $request->image;

        if(substr($file->getMimeType(), 0, 5) != 'image') {
            return ['status' => 'Error: Uploaded file is not an image.'];
        }

        $fileName = $file->hashName();
        $destinationPath = '/uploads/infografis/';
        $file->move('../api' . $destinationPath, $fileName);

        $infografis = new Infografis;
        $infografis->title = $request->title;
        $infografis->image = $destinationPath . $fileName;

        // Success
        if ($infografis->save()) {
            $response = [
                'status' => 'Success',
                'data' => array(
                    $infografis
                )
            ];

        // Fail
        } else {
            $response = [
                'status' => 'Error: Cannot save to database.'
            ];
        }

        return response($response);
    }


    /**
     * Update record
     */
    public function update(Request $request, $id) {
        try {
            $infografis = Infografis::where('id', $id)->firstOrFail();

            $file = $request->image;

            if(substr($file->getMimeType(), 0, 5) != 'image') {
                return ['status' => 'Error: Uploaded file is not an image.'];
            }

            $fileName = $file->hashName();
            $destinationPath = '/uploads/infografis/';
            $file->move($destinationPath, $fileName);

            $infografis->title = $request->title;
            $infografis->image = $destinationPath . $fileName;

            // Success
            if ($infografis->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $infografis
                    )
                ];

            // Fail
            } else {
                $response = [
                    'status' => 'Error: Cannot save to database.'
                ];
            }

            return $response;
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error: '.$e->getMessage()];
        }
    }


    /**
     * Delete record
     */
    public function destroy($id) {

        if (Infografis::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
