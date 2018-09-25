<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Company;

use Carbon;

class CompanyController extends Controller
{
    /**
     * Get all
     */
    public function index(Request $request) {
        try {
            $offset = 5;

            if ($request->input('p')) {
                $page = $request->p - 1;
            } else {
                $page = 0;
            }

            $company = Company::skip($page * $offset)->take($offset + 1)->orderBy('id', 'desc')->get()->toArray();

            $more = false;
            if (sizeof($company) > 5)
                $more = true;

            return [
                'status' => 'Success',
                'more' => $more,
                'data' => array_slice($company, 0, 5)
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
            $company = Company::where('id', $id)->firstOrFail();

            return [
                'status' => 'Success',
                'data' => [$company]
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
            $company = new Company;
            $company->title = $request->title;
            $company->content = $request->content;

            // Success
            if ($company->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $company
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
            $company = Company::where('id', $id)->firstOrFail();

            $company->title = $request->title;
            $company->content = $request->content;

            // Success
            if ($company->save()) {
                $response = [
                    'status' => 'Success',
                    'data' => array(
                        $company
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

        if (Company::destroy($id)) {
            return ['status' => 'Success'];
        }

        return ['status' => 'Error'];
    }
}
