<?php

namespace App\Http\Requests;

use App\Post;
use App\Services\ImageService;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\support\Str;

class PostRequest extends FormRequest
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
        $imageNameRule = $this->getMethod() === 'post' || $this->getMethod() === 'POST' ? 'required' : 'nullable';
        return [
            'title' => ['required'],
            'content' => ['required'],
            'description' => ['nullable'],
            'image' => ['required'],
            'imageName' => [$imageNameRule],
            'categories' => ['required', 'array'],
            'categories.*' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
            'min_read' => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $data = $this->all();
        $min_read = ceil(str_word_count(strip_tags($data['content'])) / 250);
        // prepare description
        $description =  $data['description']  ? Str::words(strip_tags($data['description']), 40, '...') : Str::words(strip_tags($data['content']), 40, '...');



        return $this->merge(
            [
                'user_id' => $this->user()->id,
                'description' => $description,
                'min_read' => $min_read
            ]
        );
    }
}
