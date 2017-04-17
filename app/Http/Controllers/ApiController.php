<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends BaseController
{

    protected $accessable_models = [
        'User',
    ];

    public function getModel (Request $request, $model_name, $id = null)
    {

        $model_class = $this->getModelClass($model_name);

        if ($id) {
            return $model_class::findOrFail($id);
        }
        
        return $model_class::all();
    }

    public function getModelWithRelation (Request $request, $model_name, $with_models, $id = null)
    {
        $relation_models = [];
        foreach (explode(',', $with_models) as $key => $value) {
            $relation_models[] = ucfirst(strtolower($value));
        }

        $model_class = $this->getModelClass($model_name);

        if ($id) {
            return $model_class::with($relation_models)->findOrFail($id);
        }

        return $model_class::with($relation_models)->get();
    }

}
