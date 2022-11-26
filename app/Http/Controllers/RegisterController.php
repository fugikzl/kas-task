<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;   
class RegisterController extends BaseController
{
    /**
     * Register a new user
     * @param Request request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        //if validation fails send error Response
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),400);       
        }
   

        $input = $request->all(); //get all inputs from request
        $input['password'] = bcrypt($input['password']); //password encryption
        
        $user = User::create($input); //new user by inputs
        $success['token'] =  $user->createToken('MyApp')->plainTextToken; //generate token 
        $success['name'] =  $user->name; //get user name
   
        return $this->sendResponse($success, 'User register successfully.',201); //send good response
    }
   
    /**
     * Login user
     * @param Request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ //if attemp to auth
            
            $user = Auth::user(); //retrieving user instance

            $success['token'] =  $user->createToken('MyApp')->plainTextToken;  //generating token
            $success['name'] =  $user->name; //name
   
            return $this->sendResponse($success, 'User login successfully.'); //send nice response
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']); //or poshel nahui
        } 
    }
}

