<?php
namespace Devdojo\CategoryManager\Controllers;

use App\Models\Employee;
use App\Models\AssignProject;
use App\Models\ApplyPosition;
use App\Models\RecruitmentSources;
use App\Models\Report;
use App\Order;
use App\OrderDetail;
use App\Phases;
use App\UserPhases;
use App\User;
use App\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailNotifications;
use Carbon\Carbon;
use DB;
use Auth;
use App\Models\ContractHistory;
use App\Http\Helper\MailHelper;
use App\Models\Translate;
use App\Taxonomy;
use App\Comment;
use App\Models\Project;
use App\Models\Team;
use App\ProjectPlan;
use App\Models\PlanReport;
use App\Models\Client;
use App\UserOneSignal;
use App\UserProjectPlan;
use App\UserProject;
use App\OnesignalNotification;
use App\Models\UserNotification;
use App\Http\Controllers\FunctionsController;

class AjaxController extends Controller
{

    public function postDeleteColumn()
    {
        extract($_POST);
        unset($_POST['_token']);

        if ($table == 'translate') {
            $tb = new Translate;
        } else if ($table == 'taxonomy') {
            $tb = new Taxonomy;
        }

        if (is_array($id)) {
            $tb::whereIn('ID', $id)->delete();
        } else {
            $tb::where('ID', $id)->delete();
        }
    }

    public function postSeachMembers()
    {
        extract($_POST);
        $html = '';
        if ($text && $leader_id) {
            $users = Employee::where('name', 'like', '%' . $text . '%')->where('id', '<>', $leader_id)->get();
            if (count($users)) {
                foreach ($users as $user) {
                    $html .= '<li>';
                    $html .= '<a href="javascript:void(0);" class="add-user-click" data-id="' . $user->id . '" data-type="' . $project_id . '">';
                    $html .= '<span class="bo-tron">';
                    $html .= '<img src="' . (file_exists(public_path() . 'uploads/employees/' . (isset($user->images) && $user->images ? $user->images : null)) ? \URL::asset('uploads/employees/' . $user->images) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . $user->name . '">';
                    $html .= '</span>';
                    $html .= '<span class="tester_name">';
                    $html .= $user->name;
                    $html .= '</span>';
                    if ($type == "coder") {
                        if ($coder_id) {
                            $coders = explode(',', $coder_id);
                        } else {
                            $coders = [];
                        }
                        foreach ($coders as $coder) {
                            if ($user->id == $coder) {
                                $html .= '<span class="   glyphicon glyphicon-ok pull-right"></span>';
                            }
                        }
                    }
                    $html .= '</li>';
                }
            } else {
                $html .= '<li> <div class="alert alert-danger margin-top-20" role="alert">';
                $html .= '<strong class="text-center">Không tìm thấy..</strong>';
                $html .= '</div></li>';
            }
        } else {
            $users = Employee::where('id', '<>', $leader_id)->get();

            if (count($users)) {
                foreach ($users as $user) {
                    $coders = explode(',', $coder_id);
                    if ($type == "coder") {
                        $html .= '<li ' . ((in_array($user->id, $coders)) ? 'class="active"' : null) . '>';
                    }
                    $html .= '<a href="javascript:void(0);" class="add-user-click" data-id="' . $user->id . '" data-type="' . $project_id . '" >';
                    $html .= '<span class="bo-tron">';
                    $html .= '<img src="' . (($user->image) ? (file_exists(public_path() . '/uploads/employees/' . $user->image) ? \URL::asset('/uploads/employees/' . $user->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . $user->name . '">';
                    $html .= '</span>';
                    $html .= '<span class="tester_name">';
                    $html .= $user->name;
                    $html .= '</span>';
                    if ($type == "coder") {
                        foreach ($coders as $coder) {
                            if ($user->id == $coder) {
                                $html .= '<span class="   glyphicon glyphicon-ok pull-right"></span>';
                            }
                        }
                    }
                    $html .= '</li>';
                }
            } else {
                $html .= '<li><div class="alert alert-danger" role="alert">';
                $html .= '<strong class="text-center">Không tìm thấy..</strong>';
                $html .= '</div></li>';
            }
        }
        return $html;
    }

    public function postSeachPhasesMembers()
    {
        extract($_POST);
        $html           = '';
        $arr_project    = [];

        if ($project_id) {
            $project        = Project::findOrFail($project_id);
            $arr_project    = json_decode($project->performer_id);
        }

        if ($text) {
            if (count($arr_project)) {
                $users = Employee::whereIn('id', $arr_project)->where('name', 'like', '%' . $text . '%')->get();
            }

            if (count($users)) {
                foreach ($users as $user) {
                    $html .= '<li>';
                    $html .= '<a href="javascript:void(0);" class="add-phases-click" data-id="' . $user->id . '" data-type="' . $phases_id . '">';
                    $html .= '<span class="bo-tron">';
                    $html .= '<img src="' . (($user->image) ? (file_exists(public_path() . '/uploads/employees/' . $user->image) ? \URL::asset('/uploads/employees/' . $user->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . $user->name . '">';
                    $html .= '</span>';
                    $html .= '<span class="tester_name">';
                    $html .= $user->name;
                    $html .= '</span>';
                    if (isset($coder_id)) {
                        if ($coder_id) {
                            $coders = explode(',', $coder_id);
                        } else {
                            $coders = [];
                        }
                    } else {
                        $coders = [];
                    }

                    if (in_array($user->id, $coders)) {
                        $html .= '<span class="glyphicon glyphicon-ok pull-right"></span>';
                    }
                    $html .= '</li>';
                }
            } else {
                $html .= '<li> <div class="alert alert-danger margin-top-20" role="alert">';
                $html .= '<strong class="text-center">Không tìm thấy..</strong>';
                $html .= '</div></li>';
            }
        } else {
            $users = Employee::whereIn('id', $arr_project)->get();;

            if (count($users)) {
                foreach ($users as $user) {
                    if (isset($coder_id)) {
                        $coders = explode(',', $coder_id);
                    } else {
                        $coders = [];
                    }

                    $html .= '<li ' . ((in_array($user->id, $coders)) ? 'class="active"' : null) . '>';
                    $html .= '<a href="javascript:void(0);" class="add-phases-click" data-id="' . $user->id . '" data-type="' . $phases_id . '" >';
                    $html .= '<span class="bo-tron">';
                    $html .= '<img src="' . (($user->image) ? (file_exists(public_path() . '/uploads/employees/' . $user->image) ? \URL::asset('/uploads/employees/' . $user->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . $user->name . '">';
                    $html .= '</span>';
                    $html .= '<span class="tester_name">';
                    $html .= $user->name;
                    $html .= '</span>';
                    if (in_array($user->id, $coders)) {
                        $html .= '<span class="   glyphicon glyphicon-ok pull-right"></span>';
                    }
                    $html .= '</li>';
                }
            } else {
                $html .= '<li><div class="alert alert-danger" role="alert">';
                $html .= '<strong class="text-center">Không tìm thấy..</strong>';
                $html .= '</div></li>';
            }
        }
        return $html;
    }

    public function postAddUserClick()
    {
        extract($_POST);

        $users = AssignProject::where([
            ['user_id', $user_id],
            ['project_id', $project_id],
            ['work_plan', $type],
        ])->get();

        if (count($users)) {
            dd('tồn tại');
        } else {
            $data = new AssignProject;
            $data->user_id      = $user_id;
            $data->project_id   = $project_id;
            $data->work_plan    = $type;
            $data->save();

            $add_html_user = '<span class="glyphicon glyphicon-ok pull-right"></span>';

            return response()->json([
                'add_html_user'     => $add_html_user,
                'add_image_user'    => 'CA'
            ]);
        }
    }

    public function getAddCoder($id)
    {
        $html = '';
        $data = Employee::where('id', $id)->first();
        if (isset($data)) {
            $html .= '<div class="bo-tron" id="add_user_' . $id . '">';
            $html .= '<img src="' . (($data->image) ? (file_exists(public_path() . '/uploads/employees/' . $data->image) ? \URL::asset('/uploads/employees/' . $data->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . (isset($data->name) && $data->name ? $data->name : null) . '">';
            $html .= '</div>';
        }
        return $html;
    }


    // Ajax get all tasks by date
    public function postDataByDate()
    {
        extract($_POST);

        $result = array();

        $date['date_to']    = $to;
        $date['date_from']  = $from;

        $result = FunctionsController::dataMyReport([
            'date'          => $date,
            'project_id'    => $project_id,
            'status'        => $status,
            'department'    => $department,
        ]);

        // get HTML
        $html = '';
        if (count($result)) {
            foreach ($result as $value) {
                $html .= '<tr class="list-task-item" data-id="' . $value['task_id'] . '">';
                $html .= '  <td class="project">';
                $html .= '    <div class="wrap-img w-100">';
                $html .= '      <a target="_blank" href="/show-detail-project/' . $value['project_id'] . '"><img src="/uploads/projects/' . $value['project_img'] . '"></a>';
                $html .= '    </div>';
                $html .= '    <div class="wrap-text w-100 flex">';
                $html .= '      <span>' . $value['project_name'] . '</span>';
                $html .= '    </div>';
                $html .= '  </td>';
                $html .= '  <td class="task">';
                $html .= '    <div>';
                if ($value['parent_name']) {
                    $html .= '      <span class="task-title">' . $value['task_name'] . '</span>';
                    $html .= '      <span class="sub-task-title">' . $value['parent_name'] . '</span>';
                } else {
                    $html .= '      <span class="task-title">' . $value['task_name'] . '</span>';
                }

                $html .= '    </div>';
                $html .= '  </td>';
                $html .= '  <td class="list-employee">';
                $html .= '    <div class="flex">';
                if (isset($value['user'])) {
                    foreach ($value['user'] as $val) {
                        $html .= '      <div class="wrap-list-img">';
                        $html .= '        <img src="/uploads/employees/' . $val['img'] . '" title="' . $val['name'] . '">';
                        $html .= '      </div>';
                    }
                }
                $html .= '    </div>';
                $html .= '  </td>';
                $html .= '  <td class="start-date">';
                $html .= '    <span>' . $value['start_date'] . '</span>';
                $html .= '  </td>';
                $html .= '  <td class="expired-date">';
                $html .= '    <span>' . $value['finish_date'] . '</span>';
                $html .= '  </td>';
                $html .= '  <td class="days-remain">';
                $html .= '    <span>' . $value['day_remain'] . '</span>';
                $html .= '  </td>';
                $html .= '  <td class="total">';
                $html .= '    <div class="flex">';
                $html .= '    <div class="wrap-process">';
                $html .= '      <div class="current-process ' . $value['color'] . '" style="width:' . $value['status'] . '%">';
                $html .= '      </div>';
                $html .= '    </div>';
                $html .= '    <span>' . $value['status'] . '%</span>';
                $html .= '    <select class="report-point">';

                if (\Entrust::hasRole((['admin', 'manager', 'giam-doc', 'pho-giam-doc', 'team-lead']))) {
                    for ($m = 0; $m <= 10; $m++) {
                        if (($m * 10) == $value['status']) {
                            $html .= '      <option selected value="' . ($m * 10) . '">' . ($m * 10) . ' %</option>';
                        } else {
                            $html .= '      <option value="' . ($m * 10) . '">' . ($m * 10) . ' %</option>';
                        }
                    }
                }

                $html .= '    </select>';
                $html .= '    </div>';
                $html .= '  </td>';
                $html .= '  <td class="edit">';
                $html .= '    <input type="hidden" class="list-project-user" value="' . $value['project_user'] . '">';
                $html .= '    <input type="hidden" class="list-task-user" value="' . $value['task_user'] . '">';
                $html .= '    <input type="hidden" class="phase-id" value="' . $value['phases_id'] . '">';
                $html .= '    <a class="edit-task edit-report" title="' . trans('report.edit') . '" data-id="' . $value['task_id'] . '"  data-toggle="modal" data-target="#reportModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                $html .= '  </td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr style="text-align:center"><td colspan="6">' . trans('report.no_results') . '</td></tr>';
        }

        return $html;

    }

    public function getAddPhasesCoder($id)
    {
        $html = '';
        $data = Employee::where('id', $id)->first();
        if (isset($data) && count($data)) {
            $html = '<span class="bo-tron" id="performer_' . $id . '">';
            $html .= '<img src="' . (($data->image) ? (file_exists(public_path() . '/uploads/employees/' . $data->image) ? \URL::asset('/uploads/employees/' . $data->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '" alt="" title="' . $data->name . '">';
            $html .= '</span>';
        }
        return $html;
    }

    public function postSaveEditPhase()
    {
        extract($_POST);
        $data       = new \stdClass();
        $user_old   = [];

        $phases = Phases::findOrFail($id);
        UserPhases::where('phases_id', $id)->get()->map(function ($item) use (&$user_old) {
            $user_old[] = $item->user_id;
        });
        $phases->description    = $description;
        $phases->name           = $name;
        $phases->date_from      = $date_from;
        $phases->date_to        = $date_to;
        $phases->eta            = isset($eta) ? $eta : '';
        $phases->save();

        if ($performer_id) {
            saveMember('user_phases', $performer_id, $id);
            $user_new = explode(',', trim($performer_id, ', '));
        }

        //Send notify
        $user_del = array_diff($user_old, $user_new);
        $user_add = array_diff($user_new, $user_old);

        $user_del = array_diff($user_del, [\Auth::id()]);
        $user_add = array_diff($user_add, [\Auth::id()]);

        $project = $phases->project;

        if ($project) {
            $project_type   = Taxonomy::find($project->project_type_id);
            $slug           = $project_type->slug;
        }

        $new_player_id = UserOneSignal::whereIn('user_id', $user_add)->pluck('player_id')->toArray();
        if ($new_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?phase_id=' . $phases->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($new_player_id, $image, $url, $user_name, $project_name);
        }

        $old_player_id = UserOneSignal::whereIn('user_id', $user_del)->pluck('player_id')->toArray();
        if ($old_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?phase_id=' . $phases->id;

            OnesignalNotification::sendNotifyRemoveEmployeePhase($old_player_id, $image, $url, $user_name, $project_name);
        }

        $data->name = $name;

        return response()->json($data);
    }

    public function postAddNewPhases()
    {
        extract($_POST);

        $trim_str           = "";
        $html               = "";
        $data_json          = new \stdClass();
        $arr_user_project   = [];

        $users          = Employee::get();
        $list_project   = Project::findOrFail($project_id);

        if (isset($list_project) && $list_project) {
            $arr_user_project = json_decode($list_project->performer_id);
        }

        if (isset($performer_id) || isset($description) || isset($date_from) || isset($date_to)) {
            $data = Phases::create([
                'description'   => (isset($description) ? $description : null),
                'project_id'    => (isset($project_id) ? $project_id : null),
                'name'          => (isset($name) ? $name : null),
                'date_from'     => (isset($date_from) ? $date_from : null),
                'date_to'       => (isset($date_to) ? $date_to : null),
                'eta'           => $eta,
            ]);

            saveMember('user_phases', $performer_id, $data->id);
            updateByType($data->id, 'phase', $data->status_point, false);

            $count_days     = getdateate($date_from, $date_to, 'd/m/Y');
            $project        = Project::findOrFail($project_id);
            $avg_phases     = intval(Phases::where('project_id', $project_id)->avg('status_point'));
            $project_update = UpdateStatusPoint($project, $avg_phases);

            //Send notify
            if ($list_project->project_type_id) {
                $project_type   = Taxonomy::find($list_project->project_type_id);
                $slug           = $project_type->slug;
            }

            $user_id    = explode(',', trim($performer_id, ', '));
            $user_id    = array_diff($user_id, [\Auth::id()]);
            $player_id  = UserOneSignal::whereIn('user_id', $user_id)->pluck('player_id')->toArray();

            if ($player_id) {
                $user_name      = \Auth::user()->name;
                $project_name   = $name;
                $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
                $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project_id . '?phase_id=' . $data->id;

                OnesignalNotification::sendNotifyAddEmployeePhase($player_id, $image, $url, $user_name, $project_name);
            }

            $html = '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= '<h4 class="panel-title">';
            $html .= '<a data-toggle="collapse" class="add_phases_' . $data->id . ' " data-parent="#add_phases" href="#add_phases_' . $data->id . '">';
            $html .= ((isset($data->name)) ? $data->name : null);
            $html .= '</a>';
            $html .= '</h4>';
            $html .= '</div>';
            $html .= '<div id="add_phases_' . $data->id . '" class="panel-collapse collapse in">';
            $html .= '<div class="panel-body">';

            $arr_lists                  = [];
            $arr_lists['id']            = (($data->id) ? $data->id : null);
            $arr_lists['name']          = (($data->name) ? $data->name : null);
            $arr_lists['description']   = (($data->description) ? $data->description : null);
            $arr_lists['date_from']     = (($data->date_from) ? $data->date_from : null);
            $arr_lists['date_to']       = (($data->date_to) ? $data->date_to : null);
            $arr_lists['class_date']    = 'date-range-one';
            $arr_lists['eta']           = $data->eta;
            $arr_lists['count_days']    = (($count_days) ? $count_days : null);

            $str = 'click-add-phases';

            $project_mem_list   = json_encode(DB::table('user_projects')->select('user_id')->where('project_id', $project_id)->pluck('user_id'));
            $phase_mem_list     = json_encode(DB::table('user_phases')->select('user_id')->where('phases_id', $data->id)->pluck('user_id'));


            $html .= '<div class="css-modal-form">';
            $html .= \Modules::AddEditFormPopup($str, $arr_lists, $project_mem_list, $phase_mem_list);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $data_json->html = $html;
        $data_json->date_from = $list_project->date_from;
        $data_json->date_to = $list_project->date_to;

        return response()->json($data_json);
    }

    public function postListUser()
    {
        extract($_POST);

        $str_list_id = trim($list_id, ',');
        $arr_list_id = explode(',', $str_list_id);

        $str_user_working = trim($user_working, ',');
        $arr_user_working = explode(',', $str_user_working);

        $current_user = Employee::where('name', 'LIKE', '%' . $name . '%');
        if (count($arr_list_id) > 1) {
            $current_user = $current_user->whereIn('id', $arr_list_id);
        }
        $current_user = $current_user->get();
        $html = '';
        if (count($current_user) > 0) {
            foreach ($current_user as $key => $value) {
                $class = '';
                if (in_array($value->id, $arr_user_working)) {
                    $class = 'active';
                }
                $html .= '<li class="flex item-user ' . $class . '" data-id="' . $value->id . '">';
                $html .= '<div class="bo-tron">';
                $html .= '  <img src="' . (($value->image) ? (file_exists(public_path() . '/uploads/employees/' . $value->image) ? \URL::asset('/uploads/employees/' . $value->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '">';
                $html .= '</div>';
                $html .= '  <span>' . $value->name . '</span>';
                $html .= '  <i class="fa fa-check"></i>';
                $html .= '</li>';
            }
        } else {
            $html .= '<li><span>' . trans('hrm.no_results') . '</span></li>';
        }

        return $html;
    }

    public function postAddMember()
    {
        extract($_POST);

        $current_user = Employee::where('id', $user_id)->first();
        $html = '';
        if ($current_user) {
            $html .= '<div class="wrap-img user-' . $current_user->id . '" data-id="' . $current_user->id . '">';
            $html .= '<img src="' . (($current_user->image) ? (file_exists(public_path() . '/uploads/employees/' . $current_user->image) ? \URL::asset('/uploads/employees/' . $current_user->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '">';
            $html .= '</div>';
        }

        return $html;
    }


    /**
     * Ajax Add member to project / phase / parent / task
     * Method: POST
     */
    public function postAddMemberAjax()
    {
        extract($_POST);

        $str_list_id = trim($list_id, ',');
        $arr_list_id = explode(',', $str_list_id);
        $current_user = Employee::whereIn('id', $arr_list_id)->get();

        $html = '';

        $html .= '<div class="form-group parent">';
        $html .= '  <label class="member-label"><h6 class="mb5 mt10">' . trans('hrm.member') . '</h6></label>';
        $html .= '  <div class="wrap-member">';
        $html .= '  </div>';
        $html .= '  <div class="wrap-list-user">';
        $html .= '    <div class="wrap-button-add">';
        $html .= '      <i class="fa fa-plus"></i>';
        $html .= '    </div>';
        $html .= '    <div class="drop-list-user">';
        $html .= '       <h3>' . trans('hrm.add_member') . '</h3>';
        $html .= '       <input class="input-text" value="" type="text">';
        $html .= '       <ul class="ul-lists-user">';
        if (count($current_user) > 0) {
            foreach ($current_user as $key => $value) {
                $html .= '        <li class="flex item-user" data-id="' . $value->id . '">';
                $html .= '  <img src="' . (($value->image) ? (file_exists(public_path() . '/uploads/employees/' . $value->image) ? \URL::asset('/uploads/employees/' . $value->image) : \URL::asset('assets/img/profile_pic.png')) : \URL::asset('assets/img/profile_pic.png')) . '">';
                $html .= '            <span>' . $value->name . '</span>';
                $html .= '            <i class="fa fa-check"></i>';
                $html .= '        </li>';
            }
        }
        $html .= '        </ul>';
        $html .= '      </div>';
        $html .= '  </div>';
        $html .= '  <input type="hidden" value="" class="list_user_id form-control" name="' . $name . '" required>';
        $html .= '  <input type="hidden" value="' . $list_id . '" class="current_user_id">';
        $html .= '</div>';

        return $html;
    }


    /**
     * Ajax update my report
     * Method: POST
     */
    public function postUpdateReport()
    {
        extract($_POST);

        $current_plan = ProjectPlan::where('id', $task_id)->first();
        $date = strtotime(date('Y-m-d'));
        $update_task = array();
        $update_parent = array();
        if ($current_plan) {
            if ($current_plan->parent_id) {
                // update task
                $this->updatePointColor(new ProjectPlan, false, $current_plan, new ProjectPlan, $task_id, $point, false, false, false);

                // update parent
                $this->updatePointColor(new ProjectPlan, false, $current_plan, new ProjectPlan, $current_plan->parent_id, $point, new ProjectPlan, 'parent_id', $current_plan->parent_id);
            } else {
                // update parent
                $this->updatePointColor(new ProjectPlan, false, $current_plan, new ProjectPlan, $task_id, $point, new ProjectPlan, 'parent_id', $current_plan->id);
            }

            // update phases
            $this->updatePointColor(new ProjectPlan, 'phases_id', $current_plan, new Phases, $current_plan->phases_id, 1, new ProjectPlan, 'phases_id', $current_plan->phases_id);

            // update project
            $current_phases = Phases::where('id', $current_plan->phases_id)->first();
            $this->updatePointColor(new Phases, 'project_id', $current_phases, new Project, $current_phases->project_id, 1, new Project, 'id', $current_phases->project_id);
        }
    }


    public function updatePointColor($table = false, $column_id = false, $data, $table_update, $id_update, $point = 1, $table_color = false, $column_color = false, $column_color_id = false)
    {
        $date = strtotime(date('d/m/Y'));
        if ($point != 1) {
            $point_update = $point;
        } else {
            $point_update = round($table::where($column_id, $data->$column_id)->avg('status_point'));
        }
        $update['status_point'] = $point_update;

        if (!$table_color) {
            // update task color
            $data_update = $table_update->where('id', $id_update)->first();

            if ($point_update == '100') {
                $update['status_color'] = 3;
                if ($date > strtotime($data_update->date_to)) {
                    $update['status_color'] = 1;
                }
            } else {
                $update['status_color'] = 2;
                if ($date > strtotime($data_update->date_to)) {
                    $update['status_color'] = 1;
                }
            }
        } else {

            $current_color = $table_color->where($column_color, $column_color_id)->get();
            if (count($current_color) > 0) {
                if ($point_update == 100) {
                    $update['status_color'] = 3;
                }
                foreach ($current_color as $value) {
                    if ($value->status_color == 1) {
                        $update['status_color'] = 1;
                        break;
                    }
                    if ($value->status_color == 2) {
                        $update['status_color'] = 2;
                        break;
                    }
                }
            } else { // parent, haven't task

                $data_update = $table_update->where('id', $id_update)->first();
                if ($point_update == 100) {
                    $update['status_color'] = 3;
                    if ($date > strtotime($data_update->date_to)) {
                        $update['status_color'] = 1;
                    }

                } else {
                    $update['status_color'] = 2;
                    if ($date > strtotime($data_update->date_to)) {
                        $update['status_color'] = 1;
                    }
                }
            }
        }

        $id = FunctionsController::insertUpdate('update', $table_update, $id_update, $update);
    }


    /**
     * AJAX get week of year
     * Method: POST
     */
    public function postWeekOfYear()
    {
        extract($_POST);

        $ddate  = Carbon::now()->format('Y-m-d');
        $result = array();
        $year   = date('Y');
        $current_week = date("W", strtotime($ddate));
        if ($type == 'next') {
            $week = $week + 1;
        } else {
            $week = $week - 1;
        }
        $current = getStartAndEndDate($week, $year);

        $result['start']        = $current['week_start'];
        $result['end']          = $current['week_end'];
        $result['week']         = $week;
        $result['start_date']   = date('d/m/Y', strtotime($result['start']));
        $result['end_date']     = date('d/m/Y', strtotime($result['end']));
        $result['current_week'] = $current_week;

        return json_encode($result);
    }

    /**
     * AJAX get week of year
     * Method: POST
     */
    public function postDayOfYear()
    {
        extract($_POST);

        $result = array();
        if ($type == 'next') {
            $day        = date('l', strtotime('+1 day', strtotime($date)));
            $date_now   = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            $str_date   = date('d/m/Y', strtotime('+1 day', strtotime($date)));
        } else {
            $day        = date('l', strtotime('-1 day', strtotime($date)));
            $date_now   = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $str_date   = date('d/m/Y', strtotime('-1 day', strtotime($date)));
        }

        $result['day']      = translateDay($day);
        $result['date']     = $date_now;
        $result['str_date'] = $str_date;

        return json_encode($result);
    }

    /**
     * AJAX show popup
     * Method: POST
     */
    public function postShowTaskPopup()
    {
        extract($_POST);

        $result = array();
        $html   = '';

        $arr_lists = [];

        if ($task_id) {
            $current_task = ProjectPlan::where('id', $task_id)->first();
        }

        $str                        = 'click-save-report';
        $arr_lists['id']            = (($current_task->id) ? $current_task->id : null);
        $arr_lists['name']          = (($current_task->name) ? $current_task->name : null);
        $arr_lists['description']   = (($current_task->description) ? $current_task->description : null);
        $arr_lists['date_from']     = (($current_task->date_from) ? $current_task->date_from : null);
        $arr_lists['date_to']       = (($current_task->date_to) ? $current_task->date_to : null);
        $arr_lists['count_days']    = (($current_task->count_days) ? $current_task->count_days : null);
        $arr_lists['eta']           = (($current_task->eta) ? $current_task->eta : null);
        $arr_lists['time_use']      = (isset($current_task->children) && count($current_task->children)) ? $current_task->children()->sum('spend_time') : $current_task->spend_time;

        $sum = $current_task->report()->where([
            ['date', Carbon::today()->toDateString()],
            ['user_id', Auth::id()]
        ])->sum('spend_time');

        $arr_lists['time_today']            = $sum;
        $arr_lists['user_id']               = ((count($current_task->user->pluck('id')->toArray())) ? $current_task->user->pluck('id')->toArray() : 0);
        $arr_lists['working_hours_plan']    = (($current_task->working_hours_plan) ? $current_task->working_hours_plan : null);
        $arr_lists['status_color']          = $current_task->status_color;
        $arr_lists['status_point']          = $current_task->status_point;
        $arr_lists['class_date']            = 'date-range-one';
        $arr_lists['hidden_report']         = true;

        if ($current_task->parent) {
            $parent_mem_list = json_encode(DB::table('user_project_plans')->select('user_id')->where('project_plan_id', $current_task->parent->id)->pluck('user_id'));
        } else {
            $parent_mem_list = json_encode(DB::table('user_phases')->select('user_id')->where('phases_id', $current_task->phase->id)->pluck('user_id'));
        }
        $task_mem_list = json_encode(DB::table('user_project_plans')->select('user_id')->where('project_plan_id', $current_task->id)->pluck('user_id'));

        $check_procees = true;

        $date_from     = $current_task->date_from;
        $date_to       = $current_task->date_to;

        $s = \Modules::AddAttachmentPopup($current_task);
        $m = \Modules::AddEditFormPopup($str, $arr_lists, $parent_mem_list, $task_mem_list, $check_procees);
        $l = \Modules::AddCommentFormPopup($task_id);

        $html .= '<div class="modal-header report">';
        $html .= '  <h1 class="modal-title report">' . $current_task->name . '</h1>';
        $html .= '</div>';
        $html .= '<div class="modal-body">';
        $html .= '  <div class="clearfix edit-report">';
        $html .= '    <div class="css-modal-form css-modal-detail">';
        $html .= '      <div class="' . (!in_array(\Auth::id(), $current_task->user->pluck('id')->toArray()) ? 'hidden-popup-member' : null) . '">';
        $html .= $m;
        $html .= '      </div>';
        $html .= '    </div>';
        $html .= '  </div>';

        $html .= '  <div class="clearfix">';
        $html .= $s;
        $html .= '  </div>';

        $html .= '  <div class="clearfix">';
        $html .= '    <div class="module-comment">';
        $html .= $l;
        $html .= '    </div>';
        $html .= '  </div>';

        $html .= '</div>';

        $html .= '<div class="modal-footer">';
        $html .= '  <a href="' . url($url) . '" type="button" class="btn btn-default close-modal">' . trans('report.close') . '</a>';
        $html .= '  <input type="hidden" class="task_id" value="' . $task_id . '">';
        $html .= '</div>';

        $result['html']         = $html;
        $result['date_from']    = $date_from;
        $result['date_to']      = $date_to;

        return json_encode($result);
    }


    /**
     * AJAX edit task
     * Method: POST
     */
    public function postEditTask()
    {
        extract($_POST);

        $data           = array();
        $arr_list_id    = array();

        if ($list_id) {
            $str_list_id = trim($list_id, ',');
            $arr_list_id = explode(',', $str_list_id);
        }
        $arr_date_range         = explode(' - ', $date_range);
        $data['name']           = $task_name;
        $data['date_from']      = Carbon::createFromFormat('d/m/Y', $arr_date_range[0])->format('Y-m-d');
        $data['date_to']        = Carbon::createFromFormat('d/m/Y', $arr_date_range[1])->format('Y-m-d');
        $data['performer_id']   = json_encode($arr_list_id);
        $data['note']           = $des;

        $update = ProjectPlan::where('id', $task_id)->update($data);
        if ($update) {
            return 1;
        }

    }

    public function postSaveClient(Request $request)
    {
        $client = new Client();
        // Lưu các đối tượng request lên server
        $client->name = $request->name;
        $client->address = $request->address;
        $client->company = $request->company;
        $client->phone_number = $request->phone_number;
        $client->email = $request->email;
        $client->code = $request->code;
        $client->vip = $request->vip;
        $client->save();


        if (isset($client->id) && $client->id) {

            // Lưu lại hình ảnh vào thư mục uploads/clients
            $filename = uploadImage($request->file('logo'), 'clients', $client->id);

            // Lưu lại tên file ảnh
            Client::where('id', $client->id)->update(['logo' => $filename]);
        }

        return response()->json($client, 200);
    }

    public function getTaxonomyType($id)
    {
        if ($id) {
            $html = "";
            $taxonomy_style = Taxonomy::find($id);
            if (isset($taxonomy_style->children)) {
                $html .= '<option value="">Tất cả</option>';
                foreach ($taxonomy_style->children as $item) {
                    $html .= '<option value="' . ((isset($item->id)) ? $item->id : null) . '">' . ((isset($item->name)) ? $item->name : null) . '</option>';
                }
                return $html;
            }
        }
    }

    public function postSaveEditTask()
    {
        extract($_POST);
        $arr_performer_id = [];
        $str_performer_id = '';

        $user_old = [];
        $task_project_childrent = ProjectPlan::findOrFail($id);
        UserProjectPlan::where('project_plan_id', $id)->get()->map(function ($item) use (&$user_old) {
            $user_old[] = $item->user_id;
        });

        if ($name) {
            $task_project_childrent->name = $name;
        }
        if ($description) {
            $task_project_childrent->description = $description;
        }

        if ($performer_id) {
            $user_id = explode(',', trim($performer_id, ', '));
            $task_project_childrent->user()->sync($user_id);
        }

        if ($date_from) {
            $task_project_childrent->date_from = $date_from;
        }

        if ($eta) {
            $task_project_childrent->eta = $eta;
        }

        if ($date_to) {
            $task_project_childrent->date_to = $date_to;
        }

        if (isset($spend_time)) {
            $task_project_childrent->spend_time = $spend_time;
            PlanReport::where(['plan_id' => $task_project_childrent->id, 'user_id' => Auth::user()->id, 'date' => Carbon::now()->format('Y-m-d')])->update(['spend_time' => $spend_time]);
        }

        $task_project_childrent->save();

        updateByType($task_project_childrent->id, 'plan', $task_project_childrent->status_point, false);

        //Send notify
        $user_new = explode(',', trim($performer_id, ', '));
        $user_del = array_diff($user_old, $user_new);
        $user_add = array_diff($user_new, $user_old);

        $user_del = array_diff($user_del, [\Auth::id()]);
        $user_add = array_diff($user_add, [\Auth::id()]);

        $phases     = Phases::findOrFail($task_project_childrent->phases_id);
        $project    = $phases->project;

        if ($project) {
            $project_type   = Taxonomy::find($project->project_type_id);
            $slug           = $project_type->slug;
        }

        $new_player_id = UserOneSignal::whereIn('user_id', $user_add)->pluck('player_id')->toArray();

        if ($new_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?task_id=' . $task_project_childrent->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($new_player_id, $image, $url, $user_name, $project_name);
        }

        $old_player_id = UserOneSignal::whereIn('user_id', $user_del)->pluck('player_id')->toArray();

        if ($old_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?task_id=' . $task_project_childrent->id;

            OnesignalNotification::sendNotifyRemoveEmployeePhase($old_player_id, $image, $url, $user_name, $project_name);
        }
    }

    public function postAddNewCommentChildrent($value = '')
    {
        extract($_POST);

        $html = '';
        if ($id && $user_id && $content) {
            $data = new Comment;
            $data->project_plan_id  = $id;
            $data->user_id          = $user_id;
            $data->content          = nl2br($content);
            $data->comment_time     = Carbon::now()->format('d/m/Y H:i:s');
            $data->save();

            $html = \Modules::ShowEditCommentPopup($data);

            $plan = ProjectPlan::findOrFail($id);

            if ($plan->parent) {
                $param = 'task_id';
            } else {
                $param = 'parent_id';
            }

            $phases     = Phases::findOrFail($plan->phases_id);
            $project    = Project::findOrFail($phases->project_id);

            if ($project) {
                $project_type   = Taxonomy::find($project->project_type_id);
                $slug           = $project_type->slug;
            }

            $user = [];

            UserProject::where('project_id', $project->id)->get()->map(function ($item) use (&$user) {
                $user[] = $item->user_id;
            });

            $user = array_diff($user, [\Auth::id()]);

            $player_id = UserOneSignal::whereIn('user_id', $user)->pluck('player_id')->toArray();
            if ($player_id) {
                $user_name  = Employee::find($user_id)->name;
                $plan_name  = $plan->name;
                $image      = asset('uploads/employees') . '/' . \Auth::user()->image;
                $url        = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?' . $param . '=' . $id;
                OnesignalNotification::sendNotifyComment($player_id, $image, $url, $user_name, $plan_name);
            }
        }

        return $html;
    }

    public function getDeleteComment($id)
    {

        $comment = Comment::find($id)->delete();
    }

    public function postEditCommentChildrent()
    {
        extract($_POST);
        $comment                = Comment::find($id);
        $comment->content       = nl2br($content);
        $comment->updated_at    = Carbon::now()->format('Y-m-d H:i:s');
        $comment->save();

        return response()->json($comment);
    }

    public function postCheckCode(Request $request)
    {
        $result = DB::table($request->table)->where('code', $request->code)->first();
        if ($result) {
            return $result->id == $request->id ? 'true' : 'false';
        }
        return 'true';
    }

    public function getAuthAttempt(Request $request)
    {
        Auth::logout();
        $user = User::find($request->id);
        Auth::login($user);
        return redirect('/dashboard');
    }

    public function postCheckEmail(Request $request)
    {
        $result = DB::table($request->table)->where('email', $request->email)->first();
        if ($result) {
            return $result->id == $request->id ? 'true' : 'false';
        }
        return 'true';
    }

    public function postCheckCodeProject(Request $request)
    {
        $result = DB::table($request->table)->where('project_code', $request->project_code)->first();
        if ($result) {
            return $result->id == $request->id ? 'true' : 'false';
        }
        return 'true';
    }

    public function postCommentAttachment(Request $request)
    {
        extract($_POST);

        $data       = new \stdClass();
        $data->html = '';
        $file_type  = $request->file('attachment')->getClientOriginalExtension();
        $file_name  = str_replace('.' . $file_type, '', $request->file('attachment')->getClientOriginalName());
        $filename   = uploadAttachment($request->file('attachment'), 'attachments');

        if (isset($filename) && $filename) {
            $data = Attachment::create([
                'name'              => $file_name,
                'image'             => $filename,
                'user_id'           => \Auth::id(),
                'project_plan_id'   => $id,
                'attachment_time'   => Carbon::now()->format("d/m/Y H:i:s")
            ]);

            $data->html     = \Modules::ShowImagePopup($data);
            $data->html_new = \Modules::ShowFormAttachment($id);

            $plan = ProjectPlan::findOrFail($id);
            if ($plan->parent) {
                $param = 'task_id';
            } else {
                $param = 'parent_id';
            }
            $phases     = Phases::findOrFail($plan->phases_id);
            $project    = Project::findOrFail($phases->project_id);

            if ($project) {
                $project_type   = Taxonomy::find($project->project_type_id);
                $slug           = $project_type->slug;
            }

            $user_id = [];

            UserProject::where('project_id', $project->id)->get()->map(function ($item) use (&$user_id) {
                $user_id[] = $item->user_id;
            });

            $user_id    = array_diff($user_id, [\Auth::id()]);
            $player_id  = UserOneSignal::whereIn('user_id', $user_id)->pluck('player_id')->toArray();

            if ($player_id) {
                $user_name  = Employee::find($data->user_id)->name;
                $plan_name  = $plan->name;
                $file       = $filename;
                $image      = asset('uploads/employees') . '/' . \Auth::user()->image;
                $url        = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?' . $param . '=' . $id;
                OnesignalNotification::sendNotifyUpload($player_id, $image, $url, $user_name, $plan_name, $file);
            }
            return response()->json($data);
        }
    }

    // delete attachment
    public function getDeleteAttachment($id)
    {
        $html = '';

        if (isset($id) && $id) {
            $data = Attachment::findOrFail($id);
            $data->delete();

            $pro_plan = ProjectPlan::findOrFail($data->project_plan_id);

            $html .= '<div class="bo-attachment">';
            $html .= \Modules::ShowFormAttachment($pro_plan->id);
            $html .= '</div>';

            return $html;
        }
    }

    //    add ajax parent
    public function postAddNewParent(Request $request)
    {

        extract($_POST);

        $data           = new \stdClass();
        $html           = "";
        $html_proccess  = "";
        $count_days     = "";
        $phases         = "";

        $count_days     = getdateate($date_from, $date_to, 'd/m/Y');

        $check_phases   = ProjectPlan::where([
            ['phases_id', $phases_id],
            ['parent_id', 0],
        ])->get();

        $project_plan   = ProjectPlan::create([
            'name'                  => $name,
            'phases_id'             => $phases_id,
            'date_from'             => $date_from,
            'date_to'               => $date_to,
            'eta'                   => $eta,
            'working_hours_result'  => 0,
            'link_task'             => '',
            'status_point'          => 0,
            'status_color'          => 1,
            'parent_id'             => 0,
            'emp_id'                => '',
            'tester_id'             => '',
            'description'           => (isset($description) && $description) ? $description : ''

        ]);

        $count_parent = ProjectPlan::where([
            ['phases_id', $phases_id],
            ['parent_id', 0],
        ])->pluck('working_hours_plan')->toArray();

        $user_id    = explode(',', trim($performer_id, ', '));
        $project_plan->user()->sync($user_id);
        $project_id = $project_plan->phase->project_id;
        $color      = changeColor($project_plan->date_from, $project_plan->date_to, $project_plan->status_point);
        $project_plan->user->map(function ($user) use ($project_plan, $project_id, $color) {
            for ($i = Carbon::createFromFormat('d/m/Y', $project_plan->date_from); $i->lte(Carbon::createFromFormat('d/m/Y', $project_plan->date_to)); $i->addDay(1)) {
                $report = PlanReport::create([
                    'project_id'    => $project_id,
                    'plan_id'       => $project_plan->id,
                    'date'          => $i->format('Y-m-d'),
                    'status_point'  => $project_plan->status_point ?: 0,
                    'status_color'  => $color,
                    'user_id'       => $user->id,
                    'spend_time'    => 0,
                ]);
            }
        });

        if ($project_plan->children) {
            updateByType($project_plan->id, 'plan', $project_plan->status_point, true);
        } else {
            updateByType($project_plan->id, 'plan', $project_plan->status_point, false);
        }

        $phases             = Phases::findOrFail($phases_id);
        $data->real_time    = getTimeDaysEta($phases, $phases->projectplanparent);
        $project            = Project::findOrFail($phases->project_id);

        //Send notify
        if ($project->project_type_id) {
            $project_type = Taxonomy::find($project->project_type_id);
            $slug = $project_type->slug;
        }

        $user_id    = array_diff($user_id, [\Auth::id()]);
        $player_id  = UserOneSignal::whereIn('user_id', $user_id)->pluck('player_id')->toArray();

        if ($player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?parent_id=' . $project_plan->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($player_id, $image, $url, $user_name, $project_name);
        }

        if (isset($phases) && $phases) {
            $html .= '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= '<h4 class="panel-title">';
            $html .= '<a data-toggle="collapse" 
                                        data-parent="#get-parent-' . $phases->id . '" 
                                        class="add_parent_' . $project_plan->id . '"
                                        href="#add_phases_' . $project_plan->id . '">';
            $html .= $project_plan->name;
            $html .= '</a>';
            $html .= '</h4>';
            $html .= '</div>';

            $arr_lists = [];
            $arr_lists['id']                = (($project_plan->id) ? $project_plan->id : null);
            $arr_lists['name']              = (($project_plan->name) ? $project_plan->name : null);
            $arr_lists['description']       = (($project_plan->description) ? $project_plan->description : null);
            $arr_lists['date_from']         = (($project_plan->date_from) ? $project_plan->date_from : null);
            $arr_lists['date_to']           = (($project_plan->date_to) ? $project_plan->date_to : null);
            $arr_lists['eta']               = $project_plan->eta;
            $arr_lists['check_today_time']  = true;
            $arr_lists['count_days']        = ((isset($count_days) && $count_days) ? $count_days : null);

            $phases_mem_list    = json_encode(DB::table('user_phases')->select('user_id')->where('phases_id', $phases->id)->pluck('user_id'));
            $parent_mem_list    = json_encode(DB::table('user_project_plans')->select('user_id')->where('project_plan_id', $project_plan->id)->pluck('user_id'));
            $str                = 'add-edit-parent';

            $html .= '<div id="add_phases_' . $project_plan->id . '" class="panel-collapse collapse in">';
            $html .= '<div class="panel-body">';
            $html .= '<div class="css-modal-form">';
            $html .= \Modules::AddEditFormPopup($str, $arr_lists, $phases_mem_list, $parent_mem_list);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            if (isset($check_phases) && count($check_phases) == 0) {
                $data->count_proplan = count($check_phases);

                $html_proccess .= '<div class="progress">';

                $html_proccess .= '<div
                            class="progress-bar ' . ((isset($phases->status_color) && $phases->status_color) ? getColor($phases->status_color) : null) . '"
                            role="progressbar"
                            aria-valuenow="' . ((isset($phases->status_point) && $phases->status_point) ? $phases->status_point : 0) . '"
                            aria-valuemin="0" aria-valuemax="100"
                            style="width: ' . ((isset($phases->status_point) && $phases->status_point) ? $phases->status_point : 0) . '%">';
                $html_proccess .= '</div>';
                $html_proccess .= '</div>';

                $html_proccess .= '<p class="no-margin">' . ((isset($phases->status_point) && $phases->status_point) ? $phases->status_point : 0) . '%</p>';
                $data->html_proccess = $html_proccess;
            }

            $data->html = $html;
        }

        $data->date_from = $phases->date_from;
        $data->date_to = $phases->date_to;

        return response()->json($data);
    }


    public function postEditDetailPhases()
    {
        extract($_POST);
        $user_old = [];
        $phases = Phases::findOrFail($id);
        UserPhases::where('phases_id', $id)->get()->map(function ($item) use (&$user_old) {
            $user_old[] = $item->user_id;
        });
        $phases->update([
            'name' => $name,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'eta' => $eta,
            'description' => (isset($description) && $description) ? $description : ''
        ]);
        getTimeDaysEta($phases->project, $phases->project->phases);

        saveMember('user_phases', $performer_id, $id);
        $user_new = explode(',', trim($performer_id, ', '));

        //Send notify
        $user_del = array_diff($user_old, $user_new);
        $user_add = array_diff($user_new, $user_old);

        $user_del = array_diff($user_del, [\Auth::id()]);
        $user_add = array_diff($user_add, [\Auth::id()]);

        $project = $phases->project;

        if ($project) {
            $project_type = Taxonomy::find($project->project_type_id);
            $slug = $project_type->slug;
        }

        $new_player_id = UserOneSignal::whereIn('user_id', $user_add)->pluck('player_id')->toArray();
        if ($new_player_id) {
            $user_name = \Auth::user()->name;
            $project_name = $name;
            $image = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?phase_id=' . $phases->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($new_player_id, $image, $url, $user_name, $project_name);
        }

        $old_player_id = UserOneSignal::whereIn('user_id', $user_del)->pluck('player_id')->toArray();
        if ($old_player_id) {
            $user_name = \Auth::user()->name;
            $project_name = $name;
            $image = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?phase_id=' . $phases->id;

            OnesignalNotification::sendNotifyRemoveEmployeePhase($old_player_id, $image, $url, $user_name, $project_name);
        }
        $phases = Phases::findOrFail($id);

        $project_parent = ProjectPlan::where([
            ['phases_id', $id],
            ['parent_id', 0],
        ])->get();

        $data = getDaysProgress($phases, $project_parent, $date_from, $date_to);

        return response()->json($data);

    }

    public function postAddEditParent()
    {
        extract($_POST);
        $data = new \stdClass();

        $user_old = [];
        $parent = ProjectPlan::findOrFail($id);
        UserProjectPlan::where('project_plan_id', $id)->get()->map(function ($item) use (&$user_old) {
            $user_old[] = $item->user_id;
        });

        $parent->update([
            'name' => $name,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'eta' => $eta,
            'description' => (isset($description) && $description) ? $description : ''
        ]);
        $phases = Phases::findOrFail($parent->phases_id);
        $real_phases = getTimeDaysEta($phases, $phases->projectplanparent);

        $user_id = explode(',', trim($performer_id, ', '));
        $parent->user()->sync($user_id);
        if ($parent->children) {
            updateByType($parent->id, 'plan', $parent->status_point, true);
        } else {
            updateByType($parent->id, 'plan', $parent->status_point, false);
        }

        $user_new = explode(',', trim($performer_id, ', '));

        //Send notify
        $user_del = array_diff($user_old, $user_new);
        $user_add = array_diff($user_new, $user_old);

        $user_del = array_diff($user_del, [\Auth::id()]);
        $user_add = array_diff($user_add, [\Auth::id()]);

        $project = $phases->project;

        if ($project) {
            $project_type   = Taxonomy::find($project->project_type_id);
            $slug           = $project_type->slug;
        }

        $new_player_id = UserOneSignal::whereIn('user_id', $user_add)->pluck('player_id')->toArray();
        if ($new_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?parent_id=' . $parent->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($new_player_id, $image, $url, $user_name, $project_name);
        }

        $old_player_id = UserOneSignal::whereIn('user_id', $user_del)->pluck('player_id')->toArray();
        if ($old_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?parent_id=' . $parent->id;

            OnesignalNotification::sendNotifyRemoveEmployeePhase($old_player_id, $image, $url, $user_name, $project_name);
        }

        $data->count_eta = $real_phases;
        $data->id = $parent->phases_id;

        return response()->json($data);
    }

    public function postAddEditTask()
    {
        extract($_POST);

        $data       = new \stdClass();
        $chidlrent  = ProjectPlan::findOrFail($id);

        $chidlrent->update([
            'name'          => $name,
            'date_from'     => $date_from,
            'date_to'       => $date_to,
            'eta'           => $eta,
            'description'   => (isset($description) && $description) ? $description : ''
        ]);

        $real_time          = getTimeDaysEta($chidlrent->parent, $chidlrent->parent->children);
        $data->real_time    = $real_time;
        $data->id = $chidlrent->parent->id;
        $user_id = explode(',', trim($performer_id, ', '));
        $chidlrent->user()->sync($user_id);
        updateByType($chidlrent->id, 'plan', $chidlrent->status_point, false);
        return response()->json($data);
    }

    public function postEditDetailParent()
    {
        extract($_POST);
        $user_old   = [];
        $parent     = ProjectPlan::findOrFail($id);
        UserProjectPlan::where('project_plan_id', $id)->get()->map(function ($item) use (&$user_old) {
            $user_old[] = $item->user_id;
        });

        if (isset($status_point) && $status_point) {
            $parent_update = $parent->update([
                'name'          => $name,
                'date_from'     => $date_from,
                'date_to'       => $date_to,
                'eta'           => $eta,
                'description'   => (isset($description) && $description) ? $description : ''
            ]);
        } else {
            $parent_udpate = $parent->update([
                'name'          => $name,
                'date_from'     => $date_from,
                'date_to'       => $date_to,
                'eta'           => $eta,
                'description'   => (isset($description) && $description) ? $description : ''
            ]);
        }
        $user_id = explode(',', trim($performer_id, ', '));
        $parent->user()->sync($user_id);
        if ($parent->children) {
            updateByType($parent->id, 'plan', $parent->status_point, true);
        } else {
            updateByType($parent->id, 'plan', $parent->status_point, false);
        }
        $phases = Phases::findOrFail($parent->phases_id);
        getTimeDaysEta($phases, $phases->projectplanparent);
        getTimeDaysEta($phases->project, $phases->project->phases);

        $user_new = explode(',', trim($performer_id, ', '));

        //Send notify
        $user_del = array_diff($user_old, $user_new);
        $user_add = array_diff($user_new, $user_old);

        $user_del = array_diff($user_del, [\Auth::id()]);
        $user_add = array_diff($user_add, [\Auth::id()]);
        $project  = $phases->project;

        if ($project) {
            $project_type   = Taxonomy::find($project->project_type_id);
            $slug           = $project_type->slug;
        }

        $new_player_id = UserOneSignal::whereIn('user_id', $user_add)->pluck('player_id')->toArray();
        if ($new_player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?parent_id=' . $parent->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($new_player_id, $image, $url, $user_name, $project_name);
        }

        $old_player_id = UserOneSignal::whereIn('user_id', $user_del)->pluck('player_id')->toArray();
        if ($old_player_id) {
            $user_name = \Auth::user()->name;
            $project_name = $name;
            $image = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?parent_id=' . $parent->id;

            OnesignalNotification::sendNotifyRemoveEmployeePhase($old_player_id, $image, $url, $user_name, $project_name);
        }

        $count_chilrent = ProjectPlan::where('parent_id', $id)->get();
        $data = getDaysProgress($parent, $count_chilrent, $date_from, $date_to);

        return response()->json($data);
    }

    public function postAddNewTask()
    {
        extract($_POST);

        $data = new \stdClass();
        $html = "";
        $html_proccess = "";

        $check_parent   = ProjectPlan::where('parent_id', $parent_id)->get();
        $count_days     = getdateate($date_from, $date_to, 'd/m/Y');
        $parent         = ProjectPlan::findOrFail($parent_id);

        $task           = ProjectPlan::create([
            'name'          => $name,
            'date_from'     => $date_from,
            'parent_id'     => $parent_id,
            'phases_id'     => $parent->phases_id,
            'date_to'       => $date_to,
            'eta'           => $eta,
            'description'   => (isset($description) && $description) ? $description : ''
        ]);

        $data->real_time = getTimeDaysEta($parent, $parent->children);
        getTimeDaysEta($parent->phase, $parent->phase->projectplanparent);
        getTimeDaysEta($parent->phase->project, $parent->phase->project->phases);
        $user_id    = explode(',', trim($performer_id, ', '));
        $task->user()->sync($user_id);
        $project_id = $task->phase->project_id;
        $color      = changeColor($task->date_from, $task->date_to, $task->status_point);
        $task->user->map(function ($user) use ($task, $project_id, $color) {
            if (!PlanReport::where(['plan_id' => $task->id, 'user_id' => $user->id])->first()) {
                for ($i = Carbon::createFromFormat('d/m/Y', $task->date_from); $i->lte(Carbon::createFromFormat('d/m/Y', $task->date_to)); $i->addDay(1)) {
                    $report = PlanReport::create([
                        'project_id'    => $project_id,
                        'plan_id'       => $task->id,
                        'date'          => $i->format('Y-m-d'),
                        'status_point'  => $task->status_point ?: 0,
                        'status_color'  => $color,
                        'user_id'       => $user->id,
                        'spend_time'    => 0,
                    ]);
                }
            }
        });
        updateByType($task->id, 'plan', $task->status_point, false);

        $avg_childrent = intval(ProjectPlan::where('parent_id', $parent_id)->avg('status_point'));
        $parent_update = UpdateStatusPoint($parent, $avg_childrent);

        $phases     = Phases::findOrFail($parent->phases_id);
        $avg_parent = intval(ProjectPlan::where([
            ['phases_id', $parent->phases_id],
            ['parent_id', 0]
        ])->avg('status_point'));

        $phases_update  = UpdateStatusPoint($phases, $avg_parent);
        $project        = Project::findOrFail($phases->project_id);
        $avg_phases     = intval(Phases::where('project_id', $phases->project_id)->avg('status_point'));
        $project_update = UpdateStatusPoint($project, $avg_phases);

        //Send notify
        if ($project->project_type_id) {
            $project_type   = Taxonomy::find($project->project_type_id);
            $slug           = $project_type->slug;
        }

        $user_id = array_diff($user_id, [\Auth::id()]);

        $player_id = UserOneSignal::whereIn('user_id', $user_id)->pluck('player_id')->toArray();

        if ($player_id) {
            $user_name      = \Auth::user()->name;
            $project_name   = $name;
            $image          = asset('uploads/employees') . '/' . \Auth::user()->image;
            $url            = asset('/show-detail-project') . '/' . $slug . '/' . $project->id . '?task_id=' . $task->id;

            OnesignalNotification::sendNotifyAddEmployeePhase($player_id, $image, $url, $user_name, $project_name);
        }

        if (isset($task) && $task) {
            $html .= '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= '<h4 class="panel-title">';
            $html .= '<a class="add_task_{{ $reports->id }}" data-toggle="collapse" data-parent="#get-childrent-' . $parent->id . '"
                                href="#add_parent_' . $task->id . '">';
            $html .= $task->name;
            $html .= '</a>';
            $html .= '</h4>';
            $html .= '</div>';

            $arr_lists                  = [];
            $arr_lists['id']            = (($task->id) ? $task->id : null);
            $arr_lists['name']          = (($task->name) ? $task->name : null);
            $arr_lists['description']   = (($task->description) ? $task->description : null);
            $arr_lists['date_from']     = (($task->date_from) ? $task->date_from : null);
            $arr_lists['date_to']       = (($task->date_to) ? $task->date_to : null);
            $arr_lists['count_days']    = (($count_days) ? $count_days : 0);
            $arr_lists['eta']           = $task->eta;

            $task_mem_list      = json_encode(DB::table('user_project_plans')->select('user_id')->where('project_plan_id', $task->id)->pluck('user_id'));
            $parent_mem_list    = json_encode(DB::table('user_project_plans')->select('user_id')->where('project_plan_id', $parent->id)->pluck('user_id'));
            $str = 'add-edit-task';

            $html .= '<div id="add_parent_' . (($task->id) ? $task->id : null) . '" class="panel-collapse collapse in">';
            $html .= '<div class="panel-body">';
            $html .= '<div class="css-modal-form">';
            $html .= \Modules::AddEditFormPopup($str, $arr_lists, $parent_mem_list, $task_mem_list);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';


            if (isset($check_parent) && count($check_parent) == 0) {
                $data->count_proplan = count($check_parent);

                $html_proccess .= '<div class="progress">';

                $html_proccess .= '<div
                          class="progress-bar ' . ((isset($parent->status_color) && $parent->status_color) ? getColor($parent->status_color) : null) . '"
                          role="progressbar"
                          aria-valuenow="' . ((isset($parent->status_point) && $parent->status_point) ? $parent->status_point : 0) . '"
                          aria-valuemin="0" aria-valuemax="100"
                          style="width: ' . ((isset($parent->status_point) && $parent->status_point) ? $parent->status_point : 0) . '%">';
                $html_proccess .= '</div>';
                $html_proccess .= '</div>';

                $html_proccess .= '<p class="no-margin">' . ((isset($parent->status_point) && $parent->status_point) ? $parent->status_point : 0) . '%</p>';
                $data->html_proccess = $html_proccess;
            }
            $data->html = $html;
        }

        $data->date_from    = $parent->date_from;
        $data->date_to      = $parent->date_to;
        return response()->json($data);

    }

    public function postUpdateColor(Request $request)
    {
        if (!$request->type) {
            updateByType($request->id, 'plan', $request->point, false);
            $plan = ProjectPlan::find($request->id);
        } else {
            updateByType($request->id, 'phase', $request->point, false);
            $phase = Phases::find($request->id);
        }
        return response()->json(['color' => isset($plan) ? $plan->status_color : $phase->status_color]);
    }

    public function postReportData(Request $request)
    {
        $user = Auth::user();
        $data = [];

        $report = PlanReport::has('plan')->where(function ($query) use ($request) {
            $query->where('date', $request->to);
        });
        $page   = $request->page;
        $now    = Carbon::now()->format('d/m/Y');

        if ($request->page == 'my') {
            $report = $report->where('user_id', $user->id);
        } else {
            $department = [];
            if (\Entrust::hasRole((['truong-phong']))) {
                $team       = Team::find($user->team_id)->child->pluck('id')->toArray();
                $team[]     = $user->team_id;
                $department = Employee::whereIn('team_id', $team)->get()->pluck('id')->toArray();
                $report     = $report->whereIn('user_id', $department);
            } elseif (\Entrust::hasRole((['admin'])) || \Entrust::hasRole((['pho-giam-doc'])) || \Entrust::hasRole((['giam-doc']))) {
                $department = Employee::get()->pluck('id')->toArray();
                $report     = $report->whereIn('user_id', $department);
            }
            if (!$request->project_id) {
                $project = UserProject::where('user_id', $user->id)->get()->pluck('project_id')->toArray();
                $request->merge(['project' => $project]);
            }

            if ($request->employee) {
                $employee   = $request->employee;
                $report     = $report->where('user_id', $employee);
            }
        }

        if ($request->project_id) {
            $request->merge(['project' => [$request->project_id]]);
        }

        if ($request->status) {
            $report = $report->whereHas('plan', function ($q) use ($request) {
                if ($request->status == 'done') {
                    $q->where('status_point', 100);
                } else {
                    $q->where('status_point', '!=', 100);
                }
            });
        }

        if ($request->project) {
            $report = $report->whereIn('project_id', $request->project);
        }
        $report = $report->with('project', 'plan')->get();

        return view('hrms.reports._table', compact('report', 'user', 'page', 'now'))->render();
    }

    public function postEditReport(Request $request)
    {
        $report             = PlanReport::find($request->pk);
        $report->spend_time = $request->value;
        $report->save();
        updateByType($report->plan_id, 'plan', $report->plan->status_point, false);
        return response()->json(['code' => 200], 200);
    }

    public function getUpdatePoint(Request $request)
    {
        $report                 = PlanReport::find($request->id);
        $report->status_point   = $request->point;
        $report->save();
        updateByType($report->plan_id, 'plan', $report->plan->status_point, true);
    }

    public function postUpdateStatus(Request $request)
    {
        $onesignal = UserNotification::find($request->id);
        $onesignal->update(['status' => '1']);
        return response()->json(['code' => 200], 200);
    }

    public function postAddApplyPosition()
    {
        extract($_POST);
        $html = '';
        $data = ApplyPosition::create([
            'name' => $name,
        ]);

        $html .= '<div id="apply-position-' . $data->id . '" class="panel panel-default content-apply background-none box-shawdow-none">';
        $html .= '<div class=" panel-heading flex">';
        $html .= '<h4 class="panel-title">';
        $html .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $data->id . '">';
        $html .= (($data->name) ? $data->name : null);
        $html .= '</a>';
        $html .= '</h4>';
        $html .= '</div>';
        $html .= '<div id="collapse' . $data->id . '" class=" panel-collapse collapse ">';
        $html .= '<div class="  panel-body no-margin background-white">';
        $html .= '<div class="row">';
        $html .= '<div class="form-group">';
        $html .= '<div class="clearfix">';
        $html .= '<input type="text" class="form-control" name="name" value="' . (($data->name) ? $data->name : null) . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<button class="btn btn-primary edit-apply-position" data-id="' . $data->id . '">' . trans('hrm.save') . '</button>';
        $html .= '<a href="' . asset('delete-apply-position/' . $data->id) . '" class="delete-apply-position"> ';
        $html .= '<button class="btn btn-danger">' . trans('hrm.delete') . '</button>';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return response()->json($html);
    }

    public function postEditSources()
    {
        extract($_POST);
        $data = RecruitmentSources::findOrFail($id);
        $data->update(['name' => $name]);

        return response()->json($data->name);
    }

    public function postDeletePhaseTask()
    {
        $data = new \stdClass();
        extract($_POST);

        if (isset($task_id)) {
            ProjectPlan::whereIn('id', $task_id)->delete();
            PlanReport::whereIn('plan_id', $task_id)->delete();
            $data->task_id = $task_id;
        }

        if (isset($phase_id)) {
            Phases::whereIn('id', $phase_id)->delete();
            $data->phase_id = $phase_id;
        }

        return response()->json($data);
    }

    public function getSelectLoai(Request $request)
    {
        $html   = '';
        $input  = $request->all();
        if(isset($input['id']) && $input['id']){
            $list_l = Taxonomy::where('parent_id', $input['id'])->get();
        }

        $html   .= '<option>'. trans('hrm.select') .'</option>';

        if(isset($input['id']) && $input['id']) {
            foreach ($list_l as $item) {
                $html .= '<option value="' . $item->ID . '">' . $item->name . '</option>';
            }
        }

        return $html;
    }

    public function getSelectBoPhan(Request $request)
    {
        $html   = '';
        $input  = $request->all();
        if(isset($input['id']) && $input['id']){
            $list_l = Taxonomy::where('parent_id', $input['id'])->get();
        }

        $html   .= '<option>'. trans('hrm.select') .'</option>';

        if(isset($input['id']) && $input['id']) {
            foreach ($list_l as $item) {
                $html .= '<option value="' . $item->ID . '">' . $item->name . '</option>';
            }
        }

        return $html;
    }

    public function getOrderShow($id)
    {
        $data = Order::findOrFail($id);

        return view('hrms.order.show', compact('data'));
    }

    public function getOrderDetailShow($id)
    {
        $data = OrderDetail::findOrFail($id);

        return view('hrms.order.show-detail', compact('data'));
    }
}