<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $accessable_models = [
        'User',
        'Blog',
    ];

    /**
     * @return Model class name
     * @throws Exeption
     */
    protected function getModelClass ($model_name) {
        $model_class = ucfirst(strtolower($model_name));

        if (! in_array($model_class, $this->accessable_models) ) {
            throw new \Exception("Model " . $model_class . " inaccessable", 1);
        }

       return $this->model_namespace  . $model_class;
    }
}
