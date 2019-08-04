<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class ApiController extends Controller
{



    /**
     * Construit une réponse JSON
     * @param null $data
     * @param bool $success
     * @param null $errors
     * @return mixed
     */
    protected function response($data = null, $success = true, $errors = null, $code = 200, $size = false) {
        $response = [];
        $response['success'] = $success;
        if(!empty($size)) $response['total'] = $size;
        if(!empty($errors)) $response['errors'] = $errors;
        if($success) $response['data'] = $data;
        return response($response, $code )
            ->header('Content-Type', 'application/json');
    }

    protected function responseError($errors, $code = 400) {
        throw \Illuminate\Validation\ValidationException::withMessages($errors);
    }

    protected function validateInputs(Request $request, $rules) {
        $validation = Validator::make($request->all(),$rules);
        if(!$validation->fails()) {
            return true;
        }
        else {
            $errors = [];
            $errorsv = $validation->errors()->toArray();
            foreach($errorsv as $name => $error) {
                $errors[] = $this->error('INVALID_INPUT',implode('. ',$error),$name);
            }
            return $errors;
        }
    }

    protected function error($code, $message, $name = '_general') {
        return array(
            'code'      => $code,
            'name'      => $name,
            'message'   => $message,
        );
    }

}
