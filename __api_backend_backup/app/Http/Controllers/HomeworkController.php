<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Homework;

class HomeworkController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {

            $offset = 10;

            if ($request->has('p')) {
                $page = $request->p - 1;
            } else {
                $page = 0;
            }

            $homeworks = Homework::skip($page * $offset)->take($offset + 1)->orderBy('deadline', 'desc');

            if ($request->has('f')) {
                if ($request->f == 'on_going') {
                    $homeworks = $homeworks->where('deadline', '>', date('Y-m-d'));
                } else if ($request->f == 'finished') {
                    $homeworks = $homeworks->where('deadline', '<=', date('Y-m-d'));
                }
            }

            if ($request->has('c')) {
                $homeworks = $homeworks->where('course', $request->c);
            }

            $homeworks = $homeworks->get()->toArray();

            $more = false;
            if (sizeof($homeworks) > $offset)
                $more = true;

            return [
                'status' => 'Success',
                'more' => $more,
                'data' => array_slice($homeworks, 0, $offset)
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
            $homework = Homework::where('id', $id)->firstOrFail();

            return [
                'status' => 'Success',
                'data' => [$homework]
            ];
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error: ', 'message' => $e->getMessage()];
        }
    }

    /**
     * Insert new
     */
    public function store(Request $request) {
        try {
            $homework = new Homework;

            $homework->name = $request->name;
            $homework->deadline = $request->deadline;
            $homework->course = $request->course;

            // Success
            if ($homework->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $homework
                    )
                ];

            // Fail
            } else {
                $response = [
                    'status' => 'Error',
                    'message' => 'Cannot save to database.'
                ];
            }

            return $response;

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
            $homework = Homework::where('id', $id)->firstOrFail();

            $homework->name = $request->name;
            $homework->deadline = $request->deadline;
            $homework->course = $request->course;

            // Success
            if ($homework->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $homework
                    )
                ];

            // Fail
            } else {
                $response = [
                    'status' => 'Error',
                    'message' => 'Cannot save to database.'
                ];
            }

            return $response;
        } catch (\Exception $e) {
            return ['status' => 'Error', 'message' => $e->getMessage()];
        }
    }


    /**
     * Delete record
     */
    public function destroy($id) {
        if (Homework::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
