<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'
    ];

    //active() method
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=','active');
    }
//    public function scopeStatus(Builder $builder, $status)
//    {
//        $builder->where('status', '=','$status');
//    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name']??false,function($builder,$value){
            $builder->where('categories.name','LIKE',"%{$value}%");
        });

        $builder->when($filters['status']??false,function($builder,$value){
            $builder->where('categories.status','=',$value);
        });


//        if ($filters['name']?? false) {
//            $builder->where('name', 'like', "%{$filters['name']}%");
//        }
//        if ($filters['status']?? false) {
//            $builder->where('status', '=',$filters['status']);
//        }
    }

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
                'status' => 'required|in:active,archived',
        ];
    }
}
