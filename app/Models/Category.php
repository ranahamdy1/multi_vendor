<?php

namespace App\Models;

use App\Rules\Fiter;
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
                'name' => ["required","string","min:3","max:255",Rule::unique('categories', 'name')->ignore($id),
//                    function ($attribute, $value, $fail) {
//                            if (strtolower($value) == 'laravel'){
//                                $fail('this name is forbidden!');
//                            }
//                    }
                    //new Fiter(['php','laravel','html'])
                    'filter: php, laravel, html'

                 ],
                'parent_id' => ['nullable','int','exists:categories,id'],
                'image' => ['image','max:1024','dimensions:min_width=100,min_height=100'],
                'status' => 'required|in:0,1',
        ];
    }
}
