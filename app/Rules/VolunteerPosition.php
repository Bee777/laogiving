<?php

namespace App\Rules;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class VolunteerPosition implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Helpers::isValidJson($value)) {
            $position = collect(json_decode($value));
            $position['minimum_age'] = $position['minimum_age'] ?? '';
            $validator = Validator::make($position->all(), [
                'position_title' => 'required|max:191',
                'vacancies' => 'required|numeric|min:1|max:200000',
                'minimum_age' => 'numeric|min:13|max:200',
                'position_skills' => 'required|array',
                'position_suitables' => 'required|array',
                'key_responsibilities' => 'required|max:500',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                dump($errors);
            }
            return !$validator->fails();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The volunteer position have some invalid information.';
    }
}
