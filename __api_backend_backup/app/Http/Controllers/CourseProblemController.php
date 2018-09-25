<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CourseProblem;

use Carbon;

class CourseProblemController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {
            $offset = 10;

            if ($request->input('p')) {
                $page = $request->p - 1;
            } else {
                $page = 0;
            }

            $courseProblem = CourseProblem::skip($page * $offset)->take($offset + 1)->orderBy('id', 'desc');

            if ($request->has('c')) {
                $courseProblem = $courseProblem->where('course', $request->input('c'));
            }

            $courseProblem = $courseProblem->get()->toArray();

            $more = false;
            if (sizeof($courseProblem) > $offset)
                $more = true;

            return [
                'status' => 'Success',
                'more' => $more,
                'data' => array_slice($courseProblem, 0, $offset)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }


    /**
     * Get one by id
     */
    public function show($id) {
        try {
            $courseProblem = CourseProblem::where('id', $id)->firstOrFail();

            return [
                'status' => 'Success',
                'data' => [$courseProblem]
            ];
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error: '.$e->getMessage()];
        }
    }


    /**
     * Insert new
     */
    public function store(Request $request) {
        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');

//            tidak perlu di protect tipe file karena yang upload hanya admin
//                $type = explode('/', $file->getMimeType())[1];
//                if($type != 'pdf' && $type != 'zip' && $type != 'rar' && $type != 'ppt' && $type != 'pptx' && $type != 'doc' && $type != 'docx') {
//                    return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//                }

                $fileName = $file->getClientOriginalName();
                $destinationPath = '/uploads/courseProblem/';
                $file->move('../api' . $destinationPath, $fileName);

                $courseProblem = new CourseProblem;
                $courseProblem->title = $request->title;
                $courseProblem->filename = $fileName;
                $courseProblem->file = $destinationPath . $fileName;
                $courseProblem->course = $request->course;


                // Success
                if ($courseProblem->save()) {
                    $response = [
                        'status' => 'Success',
                        'data' => array(
                            $courseProblem
                        )
                    ];

                // Fail
                } else {
                    $response = [
                        'status' => 'Error',
                        'message' => 'Cannot save to database.'
                    ];
                }
            }

            return response($response);
        } catch (\Exception $e) {
            return [
                'status' => 'Error',
                'message' => $e->getMessage()
            ];
        }
    }


    /**
     * Update record
     */
    public function update(Request $request, $id) {
        try {
            $courseProblem = CourseProblem::where('id', $id)->firstOrFail();

            $file = $request->file;

//            tidak perlu di protect tipe file karena yang upload hanya admin
//            $type = explode('/', $file->getMimeType())[1];
//            if($type != 'pdf' && $type != 'zip' && $type != 'rar') {
//                return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//            }

            $fileName = $file->getClientOriginalName();
            $destinationPath = '/uploads/courseProblem/';
            $file->move('../api' . $destinationPath, $fileName);

            $courseProblem->name = $request->name;
            $courseProblem->filename = $fileName;
            $courseProblem->file = $destinationPath . $fileName;

            // Success
            if ($courseProblem->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $courseProblem
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
            return ['status' => 'Error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['status' => 'Error', 'message' => $e->getMessage()];
        }
    }


    /**
     * Delete record
     */
    public function destroy($id) {

        if (CourseProblem::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
