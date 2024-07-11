<?php

namespace NotificationsManager\Notifications\Api\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationAddRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'customerId' => 'required|string',
            'operatorId' => 'required|integer',
            'orderNumber' => 'required|string',
            'messageType' => 'required|string',
            'createdDate' => 'required|date',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            ['message' => "Invalid request format."],
            400,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        ));
    }
}
