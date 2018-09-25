<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Advografis;

use Carbon;

class AdvografisController extends Controller
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

      $advografis = Advografis::skip($page * $offset)->take($offset + 1)->orderBy('id', 'desc')->get()->toArray();

      $more = false;
      if (sizeof($advografis) > 5)
        $more = true;

      return [
        'status' => 'Success',
        'more' => $more,
        'data' => array_slice($advografis, 0, 5)
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
      $advografis = Advografis::where('id', $id)->firstOrFail();

      return [
        'status' => 'Success',
        'data' => [$advografis]
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
      $advografis = new Advografis;
      $advografis->title = $request->title;
      $advografis->content = $request->content;

      // Success
      if ($advografis->save()) {
        $response = [
          'status' => 'Success',
          'data' => array(
            $advografis
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
      $advografis = Advografis::where('id', $id)->firstOrFail();

      $advografis->title = $request->title;
      $advografis->content = $request->content;

      // Success
      if ($advografis->save()) {
        $response = [
          'status' => 'Success',
          'data' => array(
            $advografis
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

    if (Advografis::destroy($id)) {
      return ['status' => 'Success'];
    }

    return ['status' => 'Error'];
  }
}
