<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="Customer",
 *     required={"id", "name", "email", "avatar", "phone", "bio", "customer_type"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Customer ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Customer name"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Customer email"
 *     ),
 *     @OA\Property(
 *         property="avatar",
 *         type="string",
 *         description="Customer image"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Customer phone"
 *     ),
 *     @OA\Property(
 *         property="bio",
 *         type="string",
 *         description="Customer bio"
 *     ),
 *     @OA\Property(
 *         property="customer_type",
 *         type="string",
 *         description="Customer type (b2b or b2c)",
 *         example="b2b"
 *     ),
 *     @OA\Property(
 *         property="company_name",
 *         type="string",
 *         description="Company name (required for b2b)",
 *         example="ABC Company"
 *     ),
 *     @OA\Property(
 *         property="company_address",
 *         type="string",
 *         description="Company address (required for b2b)",
 *         example="123 Street, City, Country"
 *     ),
 *     @OA\Property(
 *         property="vat_number",
 *         type="string",
 *         description="VAT number (required for b2b)",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="company_country",
 *         type="string",
 *         description="Company country (required for b2b)",
 *         example="Country"
 *     ),
 * )
 */

class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'sendResetLinkEmail', 'reset']]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login a user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password"
     *                 ),
     *                 example={"email": "user@example.com", "password": "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="JWT access token"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Bearer"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Token expiration time in seconds"
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Unauthorized"
     *             )
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new customer",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Customer name"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     description="Customer phone"
     *                 ),
     *                 @OA\Property(
     *                     property="bio",
     *                     type="string",
     *                     description="Customer bio"
     *                 ),
     *                 @OA\Property(
     *                     property="customer_type",
     *                     type="string",
     *                     description="Customer type (b2b or b2c)"
     *                 ),
     *                 @OA\Property(
     *                     property="company_name",
     *                     type="string",
     *                     description="Company name (required for b2b)",
     *                     example="ABC Company",
     *                 ),
     *                 @OA\Property(
     *                     property="company_address",
     *                     type="string",
     *                     description="Company address (required for b2b)",
     *                     example="123 Street, City, Country",
     *                 ),
     *                 @OA\Property(
     *                     property="vat_number",
     *                     type="string",
     *                     description="VAT number (required for b2b)",
     *                     example="123456789",
     *                 ),
     *                 @OA\Property(
     *                     property="company_country",
     *                     type="string",
     *                     description="Company country (required for b2b)",
     *                     example="Country",
     *                 ),
     *                 @OA\Property(
     *                     property="b2b_files",
     *                     type="string",
     *                     description="Company country (optinal only for b2b)",
     *                     example="images and pdf files",
     *                 ),
     *                 @OA\Property(
     *                     property="customer_discount",
     *                     type="intger",
     *                     description="Customer discount",
     *                     example="19",
     *                 ),
     *                 @OA\Property(
     *                     property="shiping_data",
     *                     type="string",
     *                     description="Customer Shiping data",
     *                     example="London , 71-75 Sheleton street",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="Customer email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Customer password"
     *                 ),
     *              example={"name": "John Doe","phone": "1234567890","bio": "Some bio","customer_type": "b2b","company_name": "ABC Company","company_address": "123 Street, City, Country","vat_number": "123456789","company_country": "Country","b2b_files": "images and pdf files","customer_discount": 19,"shiping_data": "London , 71-75 Sheleton street","email": "user@example.com","password": "password"}
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer successfully registered",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="User",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "nullable|max:190",
            'phone' => "nullable|max:190",
            'bio' => "nullable|max:5000",
            'shiping_data' => "nullable|max:5000",
            'customer_discount' => "nullable",
            'customer_type' => "required|in:b2b,b2c",
            'company_name' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_address' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'vat_number' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_country' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'b2b_files' => $request->input('customer_type') == 'b2b' ? 'nullable' : 'nullable',
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
            'password.max' => 'The password must not exceed 190 characters.',
            'shiping_data.max' => 'The shipping data field must not exceed 5000 characters.',
            'customer_discount.nullable' => 'The customer discount field is optional.',
            'b2b_files.array' => 'The B2B files field must be an array if provided.',
            'b2b_files.nullable' => 'The B2B files field is optional.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);
        }

        if ($request->input('customer_type') == 'b2c') {
            $customer = Customer::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "blocked" => false,
                "email" => $request->email,
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "password" => Hash::make($request->password),
            ]);
        } else {
            $customer = Customer::create([
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "vat_number" => $request->vat_number,
                "company_address" => $request->company_address,
                "company_name" => $request->company_name,
                "company_country" => $request->company_country,
                "blocked" => true,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
        }

        $customer->assignRole(Role::findByName('normal_customer', 'customer'));

        if ($request->hasFile('b2b_files')) {
            $uploadedFiles = $request->file('b2b_files');
            $filePaths = [];

            foreach ($uploadedFiles as $file) {
                $filePath = $file->store('public/customer_files/' . $customer->id); // Adjust path as needed
                $filePaths[] = $filePath;
            }

            $customer->b2b_files = json_encode($filePaths); // Encode file paths as JSON
            $customer->save();
        }

        if ($request->hasFile('avatar')) {
            $avatar = $customer->addMedia($request->avatar)->toMediaCollection('avatar');
            $customer->update(['avatar' => $avatar->id . '/' . $avatar->file_name]);
        }


        return response()->json([
            'message' => 'Customer successfully registered',
            'customer' => $customer
        ], 201);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout a user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Customer successfully signed out",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             )
     *         )
     *     )
     * )
     */

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Customer successfully signed out']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refresh JWT token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="JWT access token"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Bearer"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Token expiration time in seconds"
     *             )
     *         )
     *     )
     * )
     */

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * @OA\Get(
     *     path="/api/auth/user-profile",
     *     summary="Get user profile",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile fetched successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/User"
     *         )
     *     )
     * )
     */

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return response()->json(['email' => 'Customer not found'], 400);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['email' => __($status)], 400);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = $request->email;
        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return response()->json(['email' => 'Customer not found'], 400);
        }

        $credentials = $request->only('password', 'password_confirmation', 'token');
        $credentials['email'] = $email;

        $status = Password::reset(
            $credentials,
            function ($user, $password) use ($customer) {
                $customer->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $customer->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['email' => __($status)], 400);
    }
}
