<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends BaseController
{
    private $methods = [
        'get' => [
            'show' => ['func' => 'getModel'],
            'create' => ['func' => 'getCreateModel'],
            'edit' => ['func' => 'getEditModel', 'id_required' => true],
            'delete' => ['func' => 'deleteModel', 'id_required' => true],
            'trashed' => ['func' => 'getTrashedModel'],
            'restore' => ['func' => 'restoreModel', 'id_required' => true],
            'force_delete' => ['func' => 'forceDeleteModel', 'id_required' => true]
        ],
        'post' => [
            'create' => ['func' => 'postCreateModel'],
            'edit' => ['func' => 'postEditModel', 'id_required' => true],
        ]
    ];

    public function __construct (Request $request)
    {
        \View::share('admin_menu', $this->accessable_models);
        \View::share('page_title', ucfirst(strtolower($request->model_name)));
        \View::share('model_name', strtolower($request->model_name));

        $this->middleware(['auth', 'admin']);
    }

    public function dashboard (Request $request)
    {
        return view('admin.index');
    }

    public function getModelAction (Request $request, $model_name, $model_action = 'show', $id = null)
    {
        \View::share('page_action', $model_action);

        return $this->handleModelAction($request, $model_name, $model_action, $id, 'get');
    }

    public function postModelAction (Request $request, $model_name, $model_action = 'edit', $id = null)
    {
        return $this->handleModelAction($request, $model_name, $model_action, $id, 'post');
    }



    private function handleModelAction (Request $request, $model_name, $model_action, $id, $method) {
        $model_action = strtolower($model_action);
        $model_class = $this->getModelClass($model_name);

        $this->model_class = $model_class;
        $this->model_name = $model_name;
        $this->model_id = $id;
        $this->model_action = $model_action;

        if ( isset($this->methods[$method][$model_action]) ) {
            $action_func = $this->methods[$method][$model_action]['func'];

            if ( isset($this->methods[$method][$model_action]['id_required'])
                && ! $id ) {
                return redirect()->route('admin:dashboard');
            }

            return $this->$action_func($request);
        }

        return redirect()->route('admin:dashboard');
    }

    private function getModel (Request $request)
    {
        $model_class = $this->model_class;

        if ($this->model_id) {
            $row_actions = ['edit', 'delete'];
            $data = $model_class::getItem($this->model_id);
            $inputs = $model_class::getInputs();
            return view('admin.model.show', ['data' => $data, 'row_actions' => $row_actions, 'inputs' => $inputs]);
        }

        $data = $model_class::getList();
        $row_actions = ['show', 'edit', 'delete'];
        return view('admin.model.index', ['data' => $data, 'row_actions' => $row_actions]);
    }

    private function getCreateModel (Request $request)
    {
        $model_class = $this->model_class;
        $inputs = $model_class::getInputs();

        return view('admin.model.edit', ['inputs' => $inputs]);
    }

    private function getEditModel (Request $request)
    {
        $model_class = $this->model_class;
        $data = $model_class::getWithRelations($this->model_id);

        $inputs = $model_class::getInputs();

        return view('admin.model.edit', ['data' => $data, 'inputs' => $inputs]);
    }

    private function deleteModel (Request $request)
    {
        $model_class = $this->model_class;
        $data = $model_class::findOrFail($this->model_id);

        $data->delete();

        return redirect()->back();
    }

    private function getTrashedModel (Request $request)
    {
        $model_class = $this->model_class;

        if ($this->model_id) {
            $row_actions = ['restore'];
            $data = $model_class::getItem($this->model_id, true);
            return view('admin.model.show', ['data' => $data, 'row_actions' => $row_actions]);
        }

        $data = $model_class::getList(null, true);
        $row_actions = ['show', 'restore'];
        return view('admin.model.index', ['data' => $data, 'row_actions' => $row_actions]);
    }

    private function restoreModel (Request $request)
    {
        $model_class = $this->model_class;
        $data = $model_class::onlyTrashed()->findOrFail($this->model_id);

        $data->restore();

        return redirect()->back();
    }

    private function forceDeleteModel (Request $request)
    {
        $model_class = $this->model_class;
        $data = $model_class::onlyTrashed()->findOrFail($this->model_id);

        $data->forceDelete();

        return redirect()->back();
    }

    private function postEditModel (Request $request)
    {
        $model_class = $this->model_class;
        $data = $model_class::findOrFail($this->model_id);
        $inputs = $request->all();

        if (! empty($model_class::$inputs) ) {
            $inputs = array_only($inputs, array_keys($model_class::$inputs));
        } else {
            $inputs = array_except($inputs, ['_token', 'deleted_at', 'created_at', 'updated_at', 'id']);
        }

        foreach ($model_class::$inputs as $key => $value) {
            if ( $value['type'] == 'image' && $request->hasFile($key)) {
                $image = $inputs[$key];
                $image_name = $key .  '.' . $image->extension();
                $image_folder = $this->model_name . '/' . $data->id;
                $image = \Storage::url($image->storeAs($image_folder, $image_name ,'public'));
                $inputs[$key] = $image;
            }
        }

        $data->update($inputs);

        if (! empty($model_class::$relation_inputs) ) {
            $inputs = $model_class::getInputs();

            foreach ($model_class::$relation_inputs as $relation_title => $relation_value) {
                $input = $inputs[$relation_title];
                $input_name = str_replace('[]', '', $input['input_name']);
                $input_value = $request->input($input_name);

                if (! isset($input['multiple'])) {
                    $input_value = '\App\\'. ucfirst($relation_title);
                    $input_value = $input_value::findOrFail($request->input($input_name));
                } 

                if (! empty($input_value)) {
                    $data->$relation_title()->$input['method']($input_value);
                } else {
                    $data->$relation_title()->$input['method']([]);
                }

            }

            $data->save();
        }

        return redirect()->route('admin:getModelAction', [$this->model_name, 'show', $this->model_id]);
    }

    private function postCreateModel(Request $request)
    {
       $model_class = $this->model_class;
       $inputs = $request->all();

       if (! empty($model_class::$inputs) ) {
           $inputs = array_only($inputs, array_keys($model_class::$inputs));
       } else {
           $inputs = array_except($inputs, ['_token', 'deleted_at', 'created_at', 'updated_at', 'id']);
       }


       $data = $model_class::create($inputs);

       foreach ($model_class::$inputs as $key => $value) {
            if ( $value['type'] == 'image' && $request->hasFile($key)) {
                $image = $inputs[$key];
                $image_name = $key .  '.' . $image->extension();
                $image_folder = $this->model_name . '/' . $data->id;
                $image = \Storage::url($image->storeAs($image_folder, $image_name ,'public'));
                $data->update([$key => $image]);
            }
        }

       if (! empty($model_class::$relation_inputs) ) {
           $inputs = $model_class::getInputs();

           foreach ($model_class::$relation_inputs as $relation_title => $relation_value) {
               $input = $inputs[$relation_title];
               $input_name = str_replace('[]', '', $input['input_name']);
               $input_value = $request->input($input_name);

               if (! $input_value) continue;

               if (! isset($input['multiple'])) {
                   $input_value = '\App\\'. ucfirst($relation_title);
                   $input_value = $input_value::findOrFail($request->input($input_name));
               }

               $data->$relation_title()->$input['method']($input_value);
           }

            $data->save();
       }

       return redirect()->route('admin:getModelAction', [$this->model_name, 'show', $data->id]);
    }

}
