<?php

namespace Modules\Movie\App\Http\Requests\V1\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:movies,title,'.$this->route('movie')?->id],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'imdb_id' => ['nullable', 'string', 'max:255'],
            'imdb_thumbnail' => ['nullable', 'string', 'max:255'],
            'imdb_rating' => ['nullable', 'numeric'],
            'video' => [
                'nullable',
                'file',
                'mimes:'.implode(',', config('media.MediaTypeServices.video.extensions'))
            ],
            'thumbnail' => [
                'nullable',
                'file',
                'mimes:'.implode(',', config('media.MediaTypeServices.image.extensions'))
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
