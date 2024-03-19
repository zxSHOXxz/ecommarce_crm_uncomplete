<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "nullable|max:190",
            'phone' => "nullable|max:190",
            'bio' => "nullable|max:5000",
            'customer_type' => "required|in:b2b,b2c",
            'company_name' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_address' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'vat_number' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_country' => $request->input('company_country') == 'b2b' ? 'required|max:190' : 'nullable',
            'email' => "required|unique:customers,email",
            'password' => "required|min:8|max:190"
        ], [
            'name.max' => 'The name field must not exceed 190 characters.',
            'phone.max' => 'The phone field must not exceed 190 characters.',
            'bio.max' => 'The bio field must not exceed 5000 characters.',
            'customer_type.required' => 'The customer type field is required.',
            'customer_type.in' => 'The selected customer type is invalid.',
            'company_name.required' => 'The company name field is required when customer type is b2b.',
            'company_name.max' => 'The company name field must not exceed 190 characters.',
            'company_address.required' => 'The company address field is required when customer type is b2b.',
            'company_address.max' => 'The company address field must not exceed 190 characters.',
            'vat_number.required' => 'The VAT number field is required when customer type is b2b.',
            'vat_number.max' => 'The VAT number field must not exceed 190 characters.',
            'company_country.required' => 'The company country field is required when customer type is b2b.',
            'company_country.max' => 'The company country field must not exceed 190 characters.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 190 characters.'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);
        }
        $customer = Customer::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "bio" => $request->bio,
            "customer_type" => $request->customer_type,
            "vat_number" => $request->vat_number,
            "company_address" => $request->company_address,
            "company_name" => $request->company_name,
            "company_country" => $request->company_country,
            "blocked" => $request->input('customer_type') == 'b2b' ? 1 : 0,
            "email" => $request->email,
            "password" => \Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Customer successfully registered',
            'customer' => $customer
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Customer successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
