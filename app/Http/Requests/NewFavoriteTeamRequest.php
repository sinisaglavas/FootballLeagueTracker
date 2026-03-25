<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewFavoriteTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'favorite_team_id' => [
                'required',
                'integer',
                Rule::unique('favorite_teams')
                    ->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],

            'favorite_team_name' => 'required|string|max:64',
            'favorite_team_crest' => 'nullable|url|max:128',
            'favorite_team_country' => 'nullable|string|max:64',
        ];
    }
}
