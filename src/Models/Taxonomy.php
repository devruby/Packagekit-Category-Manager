<?php

namespace Devdojo\CategoryManager\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'taxonomies';

    protected $guarded = array();

    public function scopeNameById($query, $id)
    {
        $data = $this->where('id', $id)->first();
        return ($data) ? $data->name : '';
    }

    public function children()
    {
        return $this->hasMany('App\Taxonomy', 'parent_id', 'ID');
    }

    public function parent()
    {
        return $this->hasOne('App\Taxonomy', 'id', 'parent_id');
    }

    public function saveCategory($type)
    {
        extract($_POST);
        $slug = str_slug($name, '-');
        if ($type == 'danh-muc') {
            $this::create([
                'name' => $name,
                'slug' => $slug,
                'taxonomy_type' => $type
            ]);
        } elseif ($type == 'loai') {
            $this::create([
                'name' => $name,
                'slug' => $slug,
                'taxonomy_type' => $type,
                'parent_id' => $parent_id
            ]);
        } elseif ($type == 'bo-phan') {
            $this::create([
                'name' => $name,
                'slug' => $slug,
                'taxonomy_type' => $type,
                'parent_id' => $parent_id
            ]);
        }
    }

    public function listCategory($type)
    {
        $search = [];
        $data = new \stdClass();
        if ($type == 'danh-muc') {
            $data->list = $this->where('taxonomy_type', 'danh-muc')->get();
            $data->title = trans('taxonomy.list_dm');
        } elseif ($type == 'loai') {
            $data->list = $this->where('taxonomy_type', 'loai')->get();
            $data->title = trans('taxonomy.list_l');
        } elseif ($type == 'bo-phan') {
            $data->list = $this->where('taxonomy_type', 'bo-phan');

            // check isset, null for search_name
            if(isset($_GET['name']) && $_GET['name']){
                // tìm gía trị theo trường của đối tượng đó
                $data->list             = $data->list->where('name' , '%'. $_GET['name'] . '%');
                $search['name']  = $_GET['name'];
            }

            $data->list = $data->list->orderBy('id')->paginate(12);

            if($search){
                $data->list->appends($search);
            }

            $data->title = trans('taxonomy.list_bp');
        }
        $data->slug = $type;
        return $data;
    }

    public function deleteCategory($id)
    {
        $data = $this->find($id);

        if ($data->taxonomy_type == 'danh-muc') {
            $check_dm = $this->where('taxonomy_type', 'bo-phan')->whereIn('parent_id', $data->children()->pluck('ID')->toArray())->pluck('ID')->toArray();
            if (isset($check_dm) && count($check_dm)) {
                $this->where('taxonomy_type', 'bo-phan')->whereIn('parent_id', $data->children()->pluck('ID')->toArray())->delete();
            }
            if (isset($data->children) && count($data->children)) {
                $this->where('parent_id', $id)->delete();
            }
            $this->where('ID', $id)->delete();

            return '/taxonomy/list-category/danh-muc';
        } elseif ($data->taxonomy_type == 'loai') {
            if (isset($data->children) && count($data->children)) {
                $this->where('parent_id', $id)->delete();
            }

            $this->where('ID', $id)->delete();
            return '/taxonomy/list-category/loai';
        } elseif ($data->taxonomy_type == 'bo-phan') {
            $this->where('ID', $id)->delete();

            return '/taxonomy/list-category/bo-phan';
        }
    }
}
