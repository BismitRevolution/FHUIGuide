<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\LatestInfo;

use Carbon;

class LatestInfoController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {
            $info = LatestInfo::first();

            return [
                'status' => 'Success',
                'data' => [$info]
            ];
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update record
     */
    public function update(Request $request) {
        try {
            $info = LatestInfo::first();

            $info->info = $request->info;

            // Success
            if ($info->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $info
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

        if (Competition::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
