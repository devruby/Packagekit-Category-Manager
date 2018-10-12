<?php
namespace Devdojo\CategoryManager\Controllers;

use App\Http\Controllers\Controller;
use App\Taxonomy;
use Illuminate\Http\Request;
use App\Http\Controllers\FunctionsController;

class TaxonomyController extends Controller {

	public $dataView;
	public $defautPerPage 	= 20;
	public $orderShowIndex 	= ['ID'=>'desc'];
	public $urlPaginate 	= '/taxonomy/';
	public $taxonomy_type;
    public $taxo;
    public function __construct(Taxonomy $vvv ){
        $this->taxo = $vvv;
		$this->dataView 		= new Taxonomy;
		$this->taxonomy_type  	= \Request::segment(2);
	}


	/**
	 * View all Taxonomy
	 */
	public function getProjectStyle(){
		$data['title'] 				= trans('taxonomy.project_style_title');
		$data['h1'] 				= trans('taxonomy.project_style_h1');
		$data['button_add'] 		= trans('taxonomy.add_new');
		$data['button_add_link'] 	= '/taxonomy/add-project-style/';
		$data['current_url'] 		= '/taxonomy/project-style/';
		$data['page']				= 'project_style';

		$show = FunctionsController::showDataSetup([
            'orderBy'	=> $this->orderShowIndex,
            'table'		=> $this->dataView,
            'url' 		=> $this->urlPaginate,
            'per_page'	=> $this->defautPerPage,
        ]);

		$datas = array_merge($data, $show);

		return view('hrms.taxonomy.view', ['datas' => $datas]);
	}

	public function getProjectType(){
		$data['title'] 				= trans('taxonomy.project_type_title');
		$data['h1'] 				= trans('taxonomy.project_type_h1');
		$data['button_add'] 		= trans('taxonomy.add_new');
		$data['button_add_link'] 	= '/taxonomy/add-project-type/';
		$data['current_url'] 		= '/taxonomy/project-type/';
		$data['page']				= 'project_type';

		$show = FunctionsController::showDataSetup([
            'orderBy'	=> $this->orderShowIndex,
            'table'		=> $this->dataView,
            'url' 		=> $this->urlPaginate,
            'per_page'	=> $this->defautPerPage,
        ]);

		$datas = array_merge($data, $show);

		return view('hrms.taxonomy.view', ['datas' => $datas]);
	}


	/**
	 * Add and edit - Method GET
	 */
	public function getAddProjectStyle(){
		$data['title'] 	= trans('taxonomy.add_project_style_title');
		$data['h1'] 	= trans('taxonomy.add_project_style_h1');
		$data['submit'] = trans('taxonomy.add_new');
		$data['cancel'] = trans('taxonomy.cancel');
		$data['page'] 	= 'project_style';

		if(isset($_GET['edit']) && $_GET['edit']){
			$data['title'] 	= trans('taxonomy.edit_project_style_title');
			$data['h1'] 	= trans('taxonomy.edit_project_style_h1');
			$id_taxo 		= $_GET['edit'];
			$current 		= Taxonomy::where('ID', $id_taxo)->first();
			if($current){
				$data['result'] = $current;
			}

			$data['submit'] = trans('taxonomy.save_change');
		}

		return view('hrms.taxonomy.form', ['data' => $data]);
	}

	public function getAddProjectType(){
		$data['title'] 	= trans('taxonomy.add_project_type_title');
		$data['h1'] 	= trans('taxonomy.add_project_type_h1');
		$data['submit'] = trans('taxonomy.add_new');
		$data['cancel'] = trans('taxonomy.cancel');
		$data['page'] 	= 'project_type';
		$data['project_style'] = Taxonomy::where('taxonomy_type', 'project_style')->get();

		if(isset($_GET['edit']) && $_GET['edit']){
			$data['title'] 	= trans('taxonomy.edit_project_type_title');
			$data['h1'] 	= trans('taxonomy.edit_project_type_h1');
			$id_taxo 		= $_GET['edit'];
			$current 		= Taxonomy::where('ID', $id_taxo)->first();
			if($current){
				$data['result'] = $current;
			}

			$data['submit'] = trans('taxonomy.save_change');
		}

		return view('hrms.taxonomy.form', ['data' => $data]);
	}


	/**
	 * Add and edit - Method POST
	 */
	public function postAddProjectStyle(){
		$data = \Request::input();
		$data['taxonomy_type'] 	= 'project_style';
		$data['parent_id'] 		= 0;
		$data['order'] 			= $data['order'];
		$data['slug'] 			= str_slug($data['name']);
		unset($data['_token']);
		if(isset($data['edit'])){
			$id_taxo = $data['edit'];
			unset($data['edit']);
			Taxonomy::where('ID', $id_taxo)->update($data);
		}else{
			$data['created_at'] = \Carbon\Carbon::now();
			$data['updated_at'] = \Carbon\Carbon::now();
			Taxonomy::insert($data);
		}
		return redirect('/taxonomy/project-style');
	}

	public function postAddProjectType(){
		$data                   = \Request::input();
		$data['taxonomy_type'] 	= 'project_type';
		$parent                 = Taxonomy::find($data['parent_id']);
		$data['order'] 			= $data['order'];
		$data['slug'] 			= $parent->slug . '-' . str_slug($data['name']);
		unset($data['_token']);
		if(isset($data['edit'])){
			$id_taxo = $data['edit'];
			unset($data['edit']);
			Taxonomy::where('ID', $id_taxo)->update($data);
		}else{
			$data['created_at'] = \Carbon\Carbon::now();
			$data['updated_at'] = \Carbon\Carbon::now();
			Taxonomy::insert($data);
		}
		return redirect('/taxonomy/project-type');
	}

    public function getAddCategory($slug){

	    if($slug == 'danh-muc'){
            $title = trans('taxonomy.add_dm');
        }else if($slug == 'loai'){
            $title = trans('taxonomy.add_l');
            $list_cat = Taxonomy::where('taxonomy_type', 'danh-muc')->get();
        }else if($slug == 'bo-phan'){
            $title = trans('taxonomy.add_bp');
            $list_cat = Taxonomy::where('taxonomy_type', 'danh-muc')->get();
        }else{
            return abort(404);
        }

        return view('hrms.taxonomy.add', [
            'slug'      => $slug,
            'title'     => $title,
            'list_cat'  => (isset($list_cat) ? $list_cat : null)

        ]);
    }

    public function postAddCategory($slug){
        $this->taxo->saveCategory($slug);
        return redirect('/taxonomy/list-category/'. $slug);
    }

    public function getListCategory($slug){
	    if($slug == 'danh-muc'){
            $data = $this->taxo->listCategory($slug);
        }else if($slug == 'loai'){
            $data = $this->taxo->listCategory($slug);
        }else if($slug == 'bo-phan'){
            $data = $this->taxo->listCategory($slug);
        }else{
            return abort(404);
        }

        return view('hrms.taxonomy.list', compact('data'));
    }

    public function getEditCategory($id){

        $data = Taxonomy::findOrFail($id);
        $title = trans('taxonomy.edit');

        if($data->taxonomy_type == 'loai'){
            $list_cat   = Taxonomy::where('taxonomy_type', 'danh-muc')->get();
        }else if($data->taxonomy_type == 'bo-phan'){
            $list_cat   = Taxonomy::where('taxonomy_type', 'danh-muc')->get();
            $list_type  = Taxonomy::where('taxonomy_type', 'loai')->get();
        }else{
            if($data->taxonomy_type != 'danh-muc'){
                return abort(404);
            }
        }

        return view('hrms.taxonomy.add', [
            'slug'      => $data->taxonomy_type,
            'title'     => $title,
            'list_cat'  => (isset($list_cat) ? $list_cat : null),
            'list_type'  => (isset($list_type) ? $list_type : null),
            'data'      => $data

        ]);
    }

    public function postEditCategory($id){

        extract($_POST);

        if(isset($parent_dm) && $parent_dm){
            Taxonomy::where('ID', $id)->update([
                'name'      => $name,
                'parent_id' => $parent_id
            ]);

            Taxonomy::where('ID', $parent_id)->update([
                'parent_id' => $parent_dm
            ]);
        }else{
            Taxonomy::where('ID', $id)->update([
                'name'      => $name,
                'parent_id' => (isset($parent_id) && $parent_id) ? $parent_id : null
            ]);
        }

        return redirect(asset('taxonomy/list-category/' . $url));
    }

    public function getDeleteCategory($id){
	     $url = $this->taxo->deleteCategory($id);

        return redirect($url);
    }

}