<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19/06/2018
 * Time: 12:51 PM
 */

namespace App\Cms\BaseRepo;


abstract class BaseRepo implements BaseRepoInterface
{
    abstract public function getModel();

    public function index()
    {
        try {
            return jsend_success($this->getModel()->get());
        } catch (\Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
    public function find($id)
    {
        try {
            return $this->getModel()->find($id);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function all()
    {
        try {
            return $this->getModel()->orderBy('created_at', 'DESC')->get();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($data)
    {
        try {
            return $this->getModel()->create($data);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($request, $id)
    {
        try {
            if($this->getModel()->find($id)->update($request)){
                return $this->find($id);
            }
            return null;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $dato = $this->getModel()->findOrFail($id);
            $dato->active = $dato->active ? 0: 1;
            if($dato->save()) {
                return $this->find($id);
            }
            return null;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function findByAttributes(array $attributes)
    {
        try {
            $query = $this->buildQueryByAttributes($attributes);
            return $query->first();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function findByMany(array $ids)
    {
        try {
            $query = $this->getModel()->query();
            return $query->whereIn("id", $ids)->get();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function clearCache()
    {
        return true;
    }

    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->getModel()->query();
        if (method_exists($this->getModel(), 'translations')) {
            $query = $query->with('translations');
        }
        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }
        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }
        return $query;
    }
}
