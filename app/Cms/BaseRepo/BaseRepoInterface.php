<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/07/2018
 * Time: 10:41 AM
 */

namespace App\Cms\BaseRepo;


interface BaseRepoInterface
{
    /**
     * @param  int    $id
     * @return $model
     */
    public function find($id);
    /**
     * Return a collection of all elements of the resource
     * @return mixed
     */
    public function all();
    /**
     * Create a resource
     * @param $data
     * @return mixed
     */
    public function create($data);
    /**
     * Update a resource
     * @param $model
     * @param  array $data
     * @return mixed
     */
    public function update($model, $data);
    /**
     * Destroy a resource
     * @param $model
     * @return mixed
     */
    public function destroy($model);
    /**
     * Return resources translated in the given language
     * @param $lang
     * @return object
     */

    public function findByAttributes(array $attributes);
    /**
     * Return a collection of elements who's ids match
     * @param array $ids
     * @return mixed
     */
    public function findByMany(array $ids);
    /**
     * Get resources by an array of attributes
     * @param array $attributes
     * @param null|string $orderBy
     * @param string $sortOrder
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function clearCache();
}
