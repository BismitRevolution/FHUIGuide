<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CoursePlan;

use Carbon;

class CoursePlanController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {
            $coursePlan = CoursePlan::orderBy('mandatory', 'DESC')->orderBy('name', 'ASC')->get()->toArray();

            return [
                'status' => 'Success',
                'data' => $coursePlan
            ];
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Get one by id
     */
    public function show($id) {
        try {
            $coursePlan = CoursePlan::where('id', $id)->firstOrFail();

            return [
                'status' => 'Success',
                'data' => [$coursePlan]
            ];
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error', 'message' => $e->getMessage()];
        }
    }

    public function showCourses($id) {
        try {
            $coursePlan = CoursePlan::where('id', $id)->firstOrFail();
            $courses = $coursePlan->courses();

            return [
                'status' => 'Success',
                'data' => [$courses]
            ];
        } catch (ModelNotFoundException $e) {
            return ['status' => 'Error', 'message' => $e->getMessage()];
        }
    }


    /**
     * Insert new
     */
    public function store(Request $request) {
        try {
            $coursePlan = new CoursePlan;
            $coursePlan->name = $request->name;
            $coursePlan->mandatory = $request->mandatory;

            if ($request->hasFile('design')) {
                $file = $request->design;

//                tidak perlu di protect tipe file karena yang upload hanya admin
//                $type = explode('/', $file->getMimeType())[1];
//                if($type != 'pdf' && $type != 'zip' && $type != 'rar' && $type != 'doc' && $type != 'docx') {
//                    return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//                }

                $fileName = $file->getClientOriginalName();
                $destinationPath = '/uploads/rancangankuliah/';
                $file->move('../api' . $destinationPath, $fileName);

                $coursePlan->design = $destinationPath . $fileName;
            }

            // Success
            if ($coursePlan->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $coursePlan
                    )
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
            $coursePlan = CoursePlan::where('id', $id)->firstOrFail();

            $file = $request->design;

//            tidak perlu di protect tipe file karena yang upload hanya admin
//            $type = explode('/', $file->getMimeType())[1];
//            if($type != 'pdf' && $type != 'zip' && $type != 'rar' && $type != 'doc' && $type != 'docx') {
//                return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//            }

            $fileName = $file->name();
            $destinationPath = '/uploads/rancangankuliah/';
            $file->move('../api' . $destinationPath, $fileName);

            $coursePlan->name = $request->name;
            $coursePlan->design = $destinationPath . $fileName;

            // Success
            if ($coursePlan->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $coursePlan
                    )
                ];

            // Fail
            } else {
                $response = [
                    'status' => 'Error', 'messange' => 'Cannot save to database.'
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

        if (CoursePlan::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
