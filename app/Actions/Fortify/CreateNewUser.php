<?php

namespace App\Actions\Fortify;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $guard = config('fortify.guard');

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'company_adress' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Customer::class),
            ],
            'password' => $this->passwordRules(),
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        if ($guard === 'customer') {
            $customer = new Customer();
            $customer->name = $input['name'];
            $customer->company_name = $input['company_name'];
            $customer->company_adress = $input['company_adress'];
            $customer->name = $input['name'];
            $customer->email = $input['email'];
            $customer->password = Hash::make($input['password']);
            $customer->blocked = true;
            $customer->save();
        } else {
            return abort(403, 'Unauthorized action.');
        }
        return $customer;
    }
}
