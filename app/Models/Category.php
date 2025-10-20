<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'
    ];

    public static function rules($id = 0){
        return [
                'name' => ["required","string","min:3","max:255",Rule::unique('categories', 'name')->ignore($id)],
                'parent_id' => ['nullable','int','exists:categories,id'],
                'image' => ['image','max:1024','dimensions:min_width=100,min_height=100'],
                'status' => 'required|in:0,1',
        ];
    }
}
