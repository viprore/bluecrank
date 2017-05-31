<?php

namespace App\Http\Requests;

use App\Attachment;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * The input keys that should not be flashed on redirect.
     *
     * @var array
     */
    protected $dontFlash = [
        'files',
    ];

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
        $mimes = implode(',', config('project.mimes'));

        return [
            'ad_title' => ['required'],
            'ad_short_description' => ['max:50'],
            'tags' => ['required', 'array'],
            'category' => ['required'],
            'price' => ['required'],
            'description' => ['required', 'min:10'],
            'files' => ['array'],
            'files.*' => ["mimes:{$mimes}", 'max:30000'],
            'attachments' => ['array'],
            'attachments.*' => ['integer', 'exists:attachments,id'],
        ];
    }



    /**
     * 사용자 입력 값으로부터 첨부파일 객체를 조회합니다.
     *
     * @return Collection
     */
    public function getAttachments()
    {
        return Attachment::whereIn(
            'id',
            $this->input('attachments', [])
        )->get();
    }
}
