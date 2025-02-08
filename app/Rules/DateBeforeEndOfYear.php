<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class DateBeforeEndOfYear implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $start_of_year = today();
        //fix min date
        if ($start_of_year->month > 11) {
            $start_of_year->addYear();
        }
        $start_of_year->endOfYear();

        return Carbon::parse($value)->lte($start_of_year);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :atribute must be before or equal end of year.';
    }
}
