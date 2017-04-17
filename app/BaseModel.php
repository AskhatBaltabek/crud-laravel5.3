<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BaseModel extends Authenticatable
{
    use SoftDeletes;

    public static $relation_inputs = [];

    public static $inputs = [];

    public static $list_inputs = [];

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    public static function getWithRelations ($id = null, $trashed = false) 
    {
        $query = static::with(array_keys(static::$relation_inputs));

        if ($trashed) {
            $query = $query->onlyTrashed();
        }

        if ($id) {
           return  $query->findOrfail($id);
        } else {
           return  $query->get();
        }
    }

    public static function getList ($id = null, $trashed = false)
    {
        $data = static::getWithRelations($id, $trashed);
        $list = [];

        foreach ($data as $model_item) {
            $list_item = $model_item['attributes'];

            if ( static::$list_inputs ){
                $list_item = array_only($list_item, array_keys(static::$list_inputs));
            }
            elseif ( static::$inputs ) {
                $list_item = array_only($list_item, array_keys(static::$inputs));
            }

            if (! isset($list_item['id']) ) {
                $list_item = ['id' => $model_item->id] + $list_item;
            }

            if (! empty($model_item->relations) ) {
                foreach ($model_item->relations as $relation_key => $relation_item) {
                    if ( $relation_item instanceof Model) {
                        $list_item[$relation_key] = $relation_item->getTitle();
                    } else {
                        $relation_titles = [];
                        foreach($relation_item as $item) {
                            $relation_titles[] = $item->getTitle();
                        }

                        $list_item[$relation_key] = implode(', ', $relation_titles);
                    }
                }
            } 

            if ($model_item->timestamps) {
                $list_item['created_at'] = $model_item->created_at;
                $list_item['updated_at'] = $model_item->updated_at;
            }

            $list[] = $list_item;
        }

        return $list;
    }

    public static function getItem($id, $trashed = false)
    {
        $model_item = static::getWithRelations($id, $trashed);

        $list_item = $model_item['attributes'];

        if ( static::$inputs ) {
            $list_item = array_only($list_item, array_keys(static::$inputs));
        }

        if (! isset($list_item['id']) ) {
            $list_item = ['id' => $model_item->id] + $list_item;
        }

        if (! empty($model_item->relations) ) {
            foreach ($model_item->relations as $relation_key => $relation_item) {
                if ( $relation_item instanceof Model) {
                    $list_item[$relation_key] = $relation_item->getTitle();
                } else {
                    $relation_titles = [];
                    foreach($relation_item as $item) {
                        $relation_titles[] = $item->getTitle();
                    }

                    $list_item[$relation_key] = implode(', ', $relation_titles);
                }
            }
        } 

        if ($model_item->timestamps) {
            $list_item['created_at'] = $model_item->created_at;
            $list_item['updated_at'] = $model_item->updated_at;
        }

        return $list_item;
    }

    public static function getInputs()
    {
        $item_inpts = static::$inputs;

        if (! empty(static::$relation_inputs) ) {
            foreach (static::$relation_inputs as $relation_title => $relation_options) {
                $input_name = str_singular($relation_title);

                $model_class = '\App\\' . ucfirst($input_name);
                $model_values = $model_class::all();

                $input_name = $input_name . '_id';
                $input_name .= isset($relation_options['multiple']) ? '[]' : '';

                $relation_options += [
                    'values' => $model_values,
                    'input_name' => $input_name,
                ];

                $item_inpts += [$relation_title => $relation_options];
            }
        }
        return $item_inpts;
    }

    public function getTitle () {
        if ($this->title) {
            return $this->title;
        } else if ($this->name) {
            return $this->name;
        } else {
            return $this[1];
        }
    }
}
