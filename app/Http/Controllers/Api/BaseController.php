<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class BaseController extends Controller
{
    public function sendResponse($result, $message,$paginate =false)
    {
        if($paginate){
            $response = [
                'success' => true,
                'data'    => $result,
                'current_page'=>$result->currentPage(),
                'has_more_pages'=>$result->hasMorePages(),
                'count'=>$result->count(),
                'per_page'=>$result->perPage(),
                'message' => $message,
            ];
        }
        else{
            $response = [
                'success' => true,
                'data'    => $result,
                'message' => $message,
            ];
        }


        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
