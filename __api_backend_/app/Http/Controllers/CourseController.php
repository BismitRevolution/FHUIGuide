<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Course;

use Carbon;

class CourseController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {
            $offset = 5;

            $course = Course::orderBy('id', 'desc');
            if ($request->has('p')) {
                $page = $request->p - 1;
                $course = $course->skip($page * $offset)->take($offset + 1);
            }

            if ($request->has('c')) {
                $course = $course->where('type', $request->input('c'));
            }
            $course = $course->get();

            $course = $this->includeCategory($course);

            $more = false;
            if (sizeof($course) > 5)
                $more = true;

            return [
                'status' => 'Success',
                'more' => $more,
                'data' => $request->has('p') ? array_slice($course, 0, 5) : $course
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
            $course = Course::where('id', $id)->firstOrFail();
            $course = $this->includeCategory([$course]);

            return [
                'status' => 'Success',
                'data' => $course
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
            $course = new Course;
            $course->name = $request->name;
            $course->type = $request->type;

            // Success
            if ($course->save()) {
                $course = $this->includeCategory([$course]);
                $response = [
                    'status' => 'Success',
                    'data' => $course
                ];

            // Fail
            } else {
                $response = [
                    'status' => 'Error',
                    'message' => 'Cannot save to database.'
                ];
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
            $course = Course::where('id', $id)->firstOrFail();

            $course->name = $request->name;
            $course->type = $request->type;

            // Success
            if ($course->save()) {
                $course = $this->includeCategory([$course]);
                $response = [
                    'status' => 'Success',
                    'data' => $course
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

        if (Course::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }

    private function includeCategory($courses) {
        $arrayCourses = [];

        foreach ($courses as $course) {
            $course->category = $course->coursePlan()->name;
            array_push($arrayCourses, $course);
        }

        return $arrayCourses;
    }
}
