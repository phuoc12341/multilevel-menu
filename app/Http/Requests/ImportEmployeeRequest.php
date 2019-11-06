<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\CheckExtension;
// use Illuminate\Support\Facades\Validator;

class ImportEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cfg = config('common.import.validation.file');

        return [
            'file' => [
                'bail',
                'required',
                'max:' . $cfg['max'],
                new CheckExtension($cfg['type']),
            ],
        ];
    }

    // /**
    //  * Configure the validator instance.
    //  *
    //  * @param  \Illuminate\Validation\Validator  $validator
    //  * @return void
    //  */

    // public function withValidator($validator)
    // {
    //     if (!$validator->fails()) {
    //         Validator::make(['file' => $this->file()], [
    //             'file' => [new CheckImportFile($this)],
    //         ])->validate();
    //     }
    // }

    public function messages()
    {
        return [
            'file.required' => __('import.message.file_required'),
            'file.max' => __('import.message.file_max', ['capacity' => config('common.import.validate.file.max')]),
        ];
    }
}
