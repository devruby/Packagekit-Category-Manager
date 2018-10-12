<!-------------- Sidebar - Author -------------- -->
{{-- <div class="sidebar-widget author-widget">
    <div class="media">
        <a href="/profile" class="media-left">
            @if(Auth::user()->employee->photo)
                <img src="{{Auth::user()->employee->photo}}" width="40px" height="30px" class="img-responsive">
            @else
                <img src="/assets/img/avatars/profile_pic.png" class="img-responsive">
            @endif

        </a>

        <div class="media-body">
            <div class="media-author"><a href="/profile">{{Auth::user()->name}}</a></div>
        </div>
    </div>
</div> --}}

<!-- -------------- Sidebar Menu  -------------- -->
<ul class="nav sidebar-menu scrollable">
    <li style="display: inline-flex;">
        <a class="menu-open" href="/dashboard">
            <span class="fa fa-dashboard"></span>
            <span class="sidebar-title">{{trans('hrm.dashboard')}}</span>
        </a>
        @php
            $onesignal = countOnsignal();
        @endphp
        <a class="menu-open" href="{{url($locale_url.'list-onsignal')}}">
            <span class="fa fa-bell" id="fa-bell">
                @if ($onesignal > 0)
                    <span class="count" id="notificationsCountValue">{{ $onesignal }}</span>
                @endif
            </span>
        </a>
    </li>

    @permission('bao-cao-cong-viec')
    <li>
        <a class="accordion-toggle {{((Request::is($locale_url.'add-report') || Request::is($locale_url.'report-list') || Request::is($locale_url.'my-report') || Request::is($locale_url.'edit-report')) || Request::is($locale_url.'list-evaluation') || Request::is($locale_url.'list-evaluation') || Request::is($locale_url.'team-report') ? 'menu-open' : NULL)}}"
           href="#">
            <span class="fa fa-tasks"></span>
            <span class="sidebar-title">{{trans('sidebar.report_title')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            @if (!\Auth::user()->hasRole('ke-toan'))
                <li class="{{(Request::is($locale_url.'my-report')) ? 'active' : NULL}}">
                    <a href="{{url($locale_url.'my-report')}}">
                        <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.my_task')}} </a>
                </li>
            @endif
            <li class="{{(Request::is($locale_url.'team-report')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'team-report')}}">
                    <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.team_task')}} </a>
            </li>
        </ul>
    </li>
    @endpermission

    @permission('du-an')
    <?php $check_route = \Route::currentRouteName(); ?>
    @php
        $list_project_parent = getStyleTypeProject();
    @endphp

    @foreach($list_project_parent as $style_project)
        <li>
            <a class="accordion-toggle {{(request()->fullUrl() == url($locale_url.'add-project/'. $style_project->slug) || Request::is($locale_url.'list-project/'.$style_project->slug.'*') || Request::is($locale_url.'list-project/'.$style_project->slug.'/*') || Request::is($locale_url.'list-project/'.$style_project->slug.'/*') || Request::is('show-detail-project/'.$style_project->slug.'*')) ? 'menu-open' : NULL}}"
               href="#">
                <span class="fa fa-file-text-o" aria-hidden="true"></span>
                <span class="sidebar-title">{{trans('sidebar.project') . ' ' . $style_project->name}} </span>
                <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
                <li class="{{(request()->fullUrl() == url($locale_url.'add-project/'.$style_project->slug) || Request::is('show-detail-project/'.$style_project->slug.'*')) ? 'active' : NULL}}">
                    <a href="{{url($locale_url.'add-project/'.$style_project->slug)}}">
                        <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.add_project')}} </a>
                </li>

                @php
                    $list_project_childrent = getStyleTypeProject($style_project->ID);
                @endphp

                @foreach($list_project_childrent as $project_childrent)
                    <li class="{{Request::is($locale_url.'list-project/'.$project_childrent->slug) || Request::is($locale_url.'list-project/'. $project_childrent->slug .'/*') ? 'active' : NULL}}">
                        <a href="{{url($locale_url.'list-project/'. $project_childrent->slug)}}">
                            <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.project') . ' ' . $project_childrent->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
    @endpermission

    @permission('dao-tao')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'list-training-object') || Request::is($locale_url.'add-training-object') || Request::is($locale_url.'list-training-program') || Request::is($locale_url.'add-training-program') || Request::is($locale_url.'list-training-assigment') || Request::is($locale_url.'add-training-assigment') || Request::is($locale_url.'list-training-feedback') || Request::is($locale_url.'add-training-feedback') || \Route::getFacadeRoot()->current()->uri() == 'edit-training-object/{id}' || \Route::getFacadeRoot()->current()->uri() == 'edit-training-program/{id}' || \Route::getFacadeRoot()->current()->uri() == 'list-training-assigment/search' || \Route::getFacadeRoot()->current()->uri() == 'list-training-assigment/search' || \Route::getFacadeRoot()->current()->uri() == 'edit-training-feedback/{id}' || \Route::getFacadeRoot()->current()->uri() == 'list-training-program/search' || \Route::getFacadeRoot()->current()->uri() == 'list-training-feedback/search') ? 'menu-open' : NULL}}"
           href="javasc">
            <span class="fa fa-graduation-cap"></span>
            <span class="sidebar-title">Đào tạo</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            {{-- @role(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc')) --}}
            <li class="{{(Request::is($locale_url.'list-training-object')) ? 'active' : NULL}}"><a
                        href="{{url($locale_url.'list-training-object')}}">Danh sách Chủ đề đào tạo</a></li>
            @role(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc'))
            <li class="{{(Request::is($locale_url.'add-training-object') || \Route::getFacadeRoot()->current()->uri() == 'edit-training-object/{id}') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-training-object')}}">Thêm mới chủ đề đào tạo </a></li>
            @endrole
            {{-- @endrole --}}
            <li class="{{(Request::is($locale_url.'list-training-program') || \Route::getFacadeRoot()->current()->uri() == 'list-training-program/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-training-program')}}">Danh sách Khóa học </a></li>
            {{-- @role(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc')) --}}
            @role(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc'))
            <li class="{{(Request::is($locale_url.'add-training-program') || \Route::getFacadeRoot()->current()->uri() == 'edit-training-program/{id}') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-training-program')}}">Thêm mới khóa học </a></li>
            @endrole
            <li class="{{(Request::is($locale_url.'list-training-assigment') || \Route::getFacadeRoot()->current()->uri() == 'edit-training-program/{id}' || \Route::getFacadeRoot()->current()->uri() == 'list-training-assigment/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-training-assigment')}}"> Danh sách học viên </a>
            </li>
            @role(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc'))
            <li class="{{(Request::is($locale_url.'add-training-assigment')) ? 'active' : NULL}}"><a
                        href="{{url($locale_url.'add-training-assigment')}}">Thêm mới học viên </a></li>
            @endrole
            <li class="{{(Request::is($locale_url.'list-training-feedback') || \Route::getFacadeRoot()->current()->uri() == 'list-training-feedback/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-training-feedback')}}">Danh sách học viên đánh giá </a></li>
            {{-- @endrole --}}
            @if (!\Auth::user()->hasRole(array('admin', 'team-lead','manager', 'giam-doc', 'pho-giam-doc')))
                <li class="{{(Request::is($locale_url.'add-training-feedback') || \Route::getFacadeRoot()->current()->uri() == 'edit-training-feedback/{id}') ? 'active' : NULL}}">
                    <a href="{{url($locale_url.'add-training-feedback')}}">Thêm đánh giá khóa học </a></li>
            @endif

        </ul>
    </li>
    @endpermission

    @permission('lich-overtime')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'add-overtime') || Request::is($locale_url.'list-overtime') || \Route::getFacadeRoot()->current()->uri() == 'list-overtime/search')  ? 'menu-open' : NULL}}"
           href="#">
            <span class="fa fa-clock-o" aria-hidden="true"></span>
            <span class="sidebar-title">Lịch Overtime</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'add-overtime')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-overtime')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.add_overtime')}} </a>
            </li>

            <li class="{{(Request::is($locale_url.'list-overtime') || \Route::getFacadeRoot()->current()->uri() == 'list-overtime/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-overtime')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_overtime')}}</a>
            </li>
        </ul>
    </li>
    @endpermission
    @php
        $permission_leave = permissionLeave();
    @endphp
  @permission('nghi-phep')
  <li>
    <a class="accordion-toggle {{(Request::is($locale_url.'apply-leave') || Request::is($locale_url.'my-leave-list') || Request::is($locale_url.'total-leave-list') || Request::is($locale_url.'edit-leave') || Request::is($locale_url.'statistic-leave')) ? 'menu-open' : NULL}}"
       href="#">
      <span class="fa fa-bed"></span>
      <span class="sidebar-title">{{trans('sidebar.leave_title')}}</span>
      <span class="caret"></span>
    </a>
    <ul class="nav sub-nav">
      <li class="{{(Request::is($locale_url.'apply-leave') || Request::is($locale_url.'edit-leave')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'apply-leave')}}">
          <span class="glyphicon glyphicon-shopping-cart"></span> {{trans('sidebar.apply_leave')}} </a>
      </li>
      <li class="{{(Request::is($locale_url.'my-leave-list')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'my-leave-list')}}">
          <span class="glyphicon glyphicon-calendar"></span> {{trans('sidebar.my_leave_list')}} </a>
      </li>
      @if(\Auth::user()->hasRole(['admin', 'giam-doc', 'pho-giam-doc', 'truong-phong']) || in_array(\Auth::id(), $permission_leave))
      <li class="{{(Request::is($locale_url.'total-leave-list')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'total-leave-list')}}">
          <span class="fa fa-clipboard"></span> {{trans('sidebar.total_leave_list')}} </a>
      </li>
      <li class="{{(Request::is($locale_url.'statistic-leave')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'statistic-leave')}}">
          <span class="fa fa-clipboard"></span> {{trans('sidebar.statistic')}} </a>
      </li>
      @endif

    </ul>
  </li>
  @endpermission

    @permission('nhan-vien')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'add-employee') || Request::is($locale_url.'employee-manager') || Request::is($locale_url.'edit-emp')) ? 'menu-open' : NULL}}"
           href="#">
            <span class="fa fa-users"></span>
            <span class="sidebar-title">{{trans('sidebar.employees_title')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'add-employee') || Request::is($locale_url.'edit-emp')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-employee')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.employee_add')}} </a>
            </li>
            <li class="{{(Request::is($locale_url.'employee-manager')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'employee-manager')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.employees_list')}} </a>
            </li>
        </ul>
    </li>
    @endpermission


    @permission('khach-hang')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'add-client') || Request::is($locale_url.'list-client') || \Route::getFacadeRoot()->current()->uri() == 'edit-client/{clientId}' || \Route::getFacadeRoot()->current()->uri() == 'list-client/search') ? 'menu-open' : NULL}}"
           href="#">
            <span class="fa fa-address-book-o"></span>
            <span class="sidebar-title">{{trans('sidebar.clients')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'add-client') || \Route::getFacadeRoot()->current()->uri() == 'edit-client/{clientId}') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-client')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.add_client')}} </a>
            </li>

            <li class="{{(Request::is($locale_url.'list-client') || \Route::getFacadeRoot()->current()->uri() == 'list-client/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-client')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_client')}} </a>
            </li>
        </ul>
    </li>
    @endpermission

    @permission('kpis')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'add-kpi') || Request::is($locale_url.'list-kpi') || \Route::getFacadeRoot()->current()->uri() == 'edit-kpi/{kpiId}' || \Route::getFacadeRoot()->current()->uri() == 'list-kpi/search') ? 'menu-open' : NULL}}"
           href="/dashboard">
            <span class="fa fa-line-chart"></span>
            <span class="sidebar-title">KPIs</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'add-kpi') || \Route::getFacadeRoot()->current()->uri() == 'edit-kpi/{kpiId}') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-kpi')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.add')}} </a>
            </li>

            <li class="{{(Request::is($locale_url.'list-kpi') || \Route::getFacadeRoot()->current()->uri() == 'list-kpi/search') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-kpi')}}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_kpi')}} </a>
            </li>
        </ul>
    </li>
    @endpermission

     {{--quản lý thiết bị đồ dùng--}}
    <li>
        <a class="accordion-toggle {{(Request::is('taxonomy/add-category/danh-muc') || Request::is('taxonomy/list-category/danh-muc') || Request::is('taxonomy/list-category/loai') || Request::is('taxonomy/list-category/bo-phan') || Request::is('taxonomy/add-category/loai') || Request::is('taxonomy/add-category/bo-phan')) ? 'menu-open' : NULL}}"
           href="/dashboard">
            <span class="fa fa-line-chart"></span>
            <span class="sidebar-title">{{trans('sidebar.asset_management')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is('taxonomy/list-category/danh-muc')) ? 'active' : NULL}}">
                <a href="{{ asset('taxonomy/list-category/danh-muc') }}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_dm')}} </a>
            </li>
            <li class="{{(Request::is('taxonomy/list-category/loai')) ? 'active' : NULL}}">
                <a href="{{ asset('taxonomy/list-category/loai') }}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_l')}} </a>
            </li>
            <li class="{{(Request::is('taxonomy/list-category/bo-phan')) ? 'active' : NULL}}">
                <a href="{{ asset('taxonomy/list-category/bo-phan') }}">
                    <span class="glyphicon glyphicon-tags"></span> {{trans('sidebar.list_bp')}} </a>
            </li>
        </ul>
    </li>

    @permission('tuyen-dung')
    <li>
        <a class="accordion-toggle {{
        (Request::is($locale_url.'add-recruitment') ||
        Request::is($locale_url.'list-recruitment') ||
        Request::is($locale_url.'list-apply-position') ||
        (Request::is($locale_url.'list-sources')  ) ) ? 'menu-open' : NULL
        }}" href="#" >
            <span class="fa fa-user"></span>
            <span class="sidebar-title">{{trans('hrm.recruitment')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'add-recruitment')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'add-recruitment')}}" >
                    <span class="glyphicon glyphicon-book"></span> {{trans('sidebar.add')}} </a>
            </li>
            <li class="{{(Request::is($locale_url.'list-recruitment')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-recruitment')}}" >
                    <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.list_recruitment')}} </a>
            </li>
            <li class="{{(Request::is($locale_url.'list-apply-position')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-apply-position')}}" >
                    <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.list_apply_position')}} </a>
            </li>

            <li class="{{(Request::is($locale_url.'list-sources')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-sources')}}" >
                    <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.list_sources')}} </a>
            </li>
        </ul>
    </li>
    @endpermission

    @permission('cai-dat-chung')
  <li>
    <a class="accordion-toggle {{(Request::is($locale_url.'permission') || Request::is($locale_url.'template-email') || Request::is($locale_url.'template-notification') || Request::is($locale_url.'team-listing') || Request::is($locale_url.'role-list') || Request::is($locale_url.'translate') || Request::is('taxonomy/project-style') || Request::is('taxonomy/project-type') || Request::is($locale_url.'leave-type-listing') || Request::is($locale_url.'add-leave-type') || Request::is($locale_url.'edit-leave-type')) ? 'menu-open' : NULL}}" href="#">
      <span class="fa fa-cogs"></span>
      <span class="sidebar-title"> {{trans('sidebar.settings')}} </span>
      <span class="caret"></span>
    </a>
    <ul class="nav sub-nav">
      <li class="{{(Request::is($locale_url.'permission')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'permission')}}">
          <span class="glyphicon glyphicon-book"></span> {{trans('sidebar.permission')}}</a>
      </li>
      <li class="{{(Request::is($locale_url.'template-email')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'template-email')}}">
          <span class="glyphicon glyphicon-book"></span> {{trans('sidebar.email_notification')}} </a>
      </li>
      <li class="{{(Request::is($locale_url.'template-notification')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'template-notification')}}">
          <span class="glyphicon glyphicon-book"></span> {{trans('sidebar.onesignal_notification')}}</a>
      </li>
      <li class="{{(Request::is($locale_url.'team-listing')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'team-listing')}}">
          <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.team_listing')}} </a>
      </li>
      <li class="{{(Request::is($locale_url.'role-list')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'role-list')}}">
          <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.roles_list')}} </a>
      </li>
      <li class="{{(Request::is($locale_url.'translate')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'translate')}}">
          <span class="glyphicon glyphicon-modal-window"></span> {{trans('sidebar.translate')}} </a>
      </li>
      <li>
          <a class="accordion-toggle {{($check_route == 'taxonomy') ? 'menu-open':''}}" href="javascript:void(0);">
          <span class="fa fa-file-text-o" aria-hidden="true"></span>
          <span class="sidebar-title">{{trans('sidebar.config_project')}}</span>
          <span class="caret"></span>
          
          </a>
          <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'taxonomy/project-style')) ? 'active' : NULL}}">
              <a href="{{url($locale_url.'taxonomy/project-style')}}">{{trans('sidebar.project_style')}}</a>
            </li>
            <li class="{{(Request::is($locale_url.'taxonomy/project-type')) ? 'active' : NULL}}">
              <a href="{{url($locale_url.'taxonomy/project-type')}}"> {{trans('sidebar.project_type')}} </a>
            </li>
          </ul>
      </li>

      <li class="{{(Request::is($locale_url.'add-leave-type') || Request::is($locale_url.'edit-leave-type') || Request::is($locale_url.'leave-type-listing')) ? 'active' : NULL}}">
        <a href="{{url($locale_url.'leave-type-listing')}}">
          <span class="fa fa-clipboard"></span> {{trans('sidebar.leave_type_list')}} </a>
      </li>
    </ul>
  </li>
  @endpermission

    @permission('email-sms')
    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'send-email-mkt')  || \Route::getFacadeRoot()->current()->uri() == 'edit-send-email-mkt/{notifiId}' || Request::is($locale_url.'list-notifi') || \Route::getFacadeRoot()->current()->uri() == 'list-notifi/search') ? 'menu-open' : NULL}}"
           href="#">
            <span class="fa fa-envelope"></span>
            <span class="sidebar-title">{{trans('sidebar.send_email_sms')}}</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'send-email-mkt')  || \Route::getFacadeRoot()->current()->uri() == 'edit-send-email-mkt/{notifiId}') ? 'active' : NULL}}">
                <a href="{{url($locale_url.'send-email-mkt')}}">
                    <span class="fa fa-lock pr5"></span> {{trans('sidebar.add_new')}} </a>
            </li>
            <li class="{{(Request::is($locale_url.'list-notifi')) ? 'active' : NULL}}">
                <a href="{{url($locale_url.'list-notifi')}}">
                    <span class="fa fa-lock pr5"></span> {{trans('sidebar.list')}} </a>
            </li>
        </ul>
    </li>
    @endpermission

    <li>
        <a class="accordion-toggle {{(Request::is($locale_url.'change-password') || Request::is($locale_url.'detail-emp/*') ||Request::is($locale_url.'list-onsignal')) ? 'menu-open' : NULL}}" href="#">
            <span class="fa fa-user"></span>
            <span class="sidebar-title"> {{trans('sidebar.account')}} </span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li class="{{(Request::is($locale_url.'detail-emp/*')) ? 'active' : NULL}}">
                @if(\Auth::id())
                    <a href="{{url('/detail-emp/' . \Auth::id())}}" class="overflow-hidden">
                        @if(\Auth::user()->image)
                            @if((file_exists(public_path() . '/uploads/employees/' . \Auth::user()->image)))
                                <div class="bo-tron margin-right-11">
                                    <img src="{{ \URL::asset('/uploads/employees/' . \Auth::user()->image) }}" alt="">
                                </div>
                            @else
                                <div class="bo-tron margin-right-11">
                                    <img src="{{ \URL::asset('assets/img/profile_pic.png') }}" alt="">
                                </div>
                            @endif
                        @else
                            <div class="bo-tron margin-right-11">
                                <img src="{{ \URL::asset('assets/img/profile_pic.png') }}" alt="">
                            </div>
                        @endif
                         {{\Auth::user()->name}}
                    </a>
                @endif
            </li>
            <li class="{{(Request::is($locale_url.'list-onsignal')) ? 'active' : NULL}}">
                <a href="{{\URL::asset($locale_url)}}list-onsignal">
                    <span class="fa fa-lock pr5"></span> {{trans('sidebar.notifications')}} </a>
            </li>

            <li class="{{(Request::is($locale_url.'change-password')) ? 'active' : NULL}}">
                <a href="{{\URL::asset($locale_url)}}change-password">
                    <span class="fa fa-lock pr5"></span> {{trans('sidebar.change_password')}} </a>
            </li>
            <li>
                <a href="{{\URL::asset($locale_url)}}logout">
                    <span class="fa fa-power-off pr5"></span> {{trans('sidebar.logout')}} </a>
            </li>
        </ul>
    </li>
</ul>
<!-- -------------- /Sidebar Menu  --------------
