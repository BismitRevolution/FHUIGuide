<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\AdvoReport;

use Carbon;

class AdvoReportController extends Controller
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

      $advoReports = AdvoReport::skip($page * $offset)->take($offset + 1)->orderBy('id', 'desc');

      $advoReports = $advoReports->get()->toArray();

      $more = false;
      if (sizeof($advoReports) > $offset)
        $more = true;

      return [
        'status' => 'Success',
        'more' => $more,
        'data' => array_slice($advoReports, 0, $offset)
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
      $advoReport = AdvoReport::where('id', $id)->firstOrFail();

      return [
        'status' => 'Success',
        'data' => [$advoReport]
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
      $advoReport = new AdvoReport;
      $advoReport->sender = $request->sender;
      $advoReport->title = $request->title;
      $advoReport->report = $request->report;

      if ($request->hasFile('image')) {
        $file = $request->image;

//                tidak perlu di protect tipe file karena yang upload hanya admin
//                $type = explode('/', $file->getMimeType())[1];
//                if($type != 'pdf' && $type != 'zip' && $type != 'rar' && $type != 'doc' && $type != 'docx') {
//                    return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//                }

        $fileName = $file->getClientOriginalName();
        $destinationPath = '/uploads/laporadvo/';
        $file->move('../api' . $destinationPath, $fileName);

        $advoReport->image = $destinationPath . $fileName;
      }

      // Success
      if ($advoReport->save()) {
        $response = [
          'status' => 'Success',
          'data' => array(
            $advoReport
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
      $advoReport = AdvoReport::where('id', $id)->firstOrFail();

      $file = $request->image;

//            tidak perlu di protect tipe file karena yang upload hanya admin
//            $type = explode('/', $file->getMimeType())[1];
//            if($type != 'pdf' && $type != 'zip' && $type != 'rar' && $type != 'doc' && $type != 'docx') {
//                return ['status' => 'Error', 'message' => 'Tipe berkas tidak didukung.'];
//            }

      $fileName = $file->name();
      $destinationPath = '/uploads/laporadvo/';
      $file->move('../api' . $destinationPath, $fileName);

      $advoReport->sender = $request->sender;
      $advoReport->title = $request->title;
      $advoReport->report = $request->report;
      $advoReport->image = $destinationPath . $fileName;

      // Success
      if ($advoReport->save()) {
        $response = [
          'status' => 'Success',
          'data' => array(
            $advoReport
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

    if (AdvoReport::destroy($id)) {
      return ['status' => 'Success'];
    }

    return ['status' => 'Error'];
  }
}
