<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  @php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
    //print_r($user_permisions);
  @endphp
  <div class="logo">
    <a href="http://abssoftech.com/" class="simple-text logo-normal">
      {{ __('Dsuit Admin') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
    <li class="nav-item{{ $activePage == 'file_manager' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('media')}}">
          <i class="material-icons">insert_drive_file</i>
          <p>{{ __('File Manager') }}</p>
        </a>
      </li>
       
      @if( in_array('list_desingation', $user_permisions ) )
        <li class="nav-item{{ $activePage == 'designation' ? ' active' : '' }}">
          <a class="nav-link" href="{{route('designation.index')}}">
            <i class="material-icons">desktop_mac</i>
            <p>{{ __('Designation') }}</p>
          </a>
        </li>
       @endif

     @if( in_array('list_shift', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'shift' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('shift.index')}}">
          <i class="material-icons">access_time_filled</i>
          <p>{{ __('Shift') }}</p>
        </a>
      </li>
      @endif

     @if( in_array('list_employee', $user_permisions ) )
      <li class="nav-item  {{ ($activePage == 'employee-list' || $activePage == 'employee-add' || $activePage == 'employee-view') ? ' active' : '' }}">
        <a class="nav-link parent-nav-link" data-toggle="collapse" href="#employee_page" aria-expanded="true">
        <i class="material-icons">people</i>
          <p>{{ __('Employees') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse hide" id="employee_page">
          <ul class="nav">
          @if( in_array('create_employee', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'employee-add' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('employee.create') }}">
              <i class="material-icons">person_add</i>
                <span class="sidebar-normal">{{ __('Add Employee') }} </span>
              </a>
            </li>
          @endif
            <li class="nav-item{{ $activePage == 'employee-list' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('employee.index') }}">
              <i class="material-icons">view_list</i>
                <span class="sidebar-normal"> {{ __(' Employee List') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li> 
      @endif

      @if( in_array('list_department', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'department' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('department.index')}}">
          <i class="material-icons">business</i>
          <p>{{ __('Department') }}</p>
        </a>
      </li>
      @endif
      
      @if( in_array('list_leave_management', $user_permisions ) )
      <li class="nav-item {{ ($activePage == 'leave_management-calender' || $activePage == 'leave_management-leave_detail') ? ' active' : '' }}">
        <a class="nav-link parent-nav-link" data-toggle="collapse" href="#LeaveManagement" aria-expanded="true">
        <i class="material-icons">perm_contact_calendar</i>
          <p>{{ __('Leave Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse hide" id="LeaveManagement">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'leave_management-calender' ? ' active' : '' }}">
              @php
                $time    = time();
                $month  = date('m', $time);
                $year  = date('Y', $time);
              @endphp
              <a class="nav-link" href="{{ route('calender', [$month,$year,'1']) }}">
              <i class="material-icons">date_range</i>
                <span class="sidebar-normal">{{ __('Calender') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'leave_management-leave_detail' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('leave-management.index') }}">
              <i class="material-icons">post_add</i>
              
                <span class="sidebar-normal"> {{ __(' Add Details in Calender') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endif
     
      @if( in_array('list_holidays', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'holiday' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('holiday.index') }}">
          <i class="material-icons">card_giftcard</i>
          <p>{{ __('Holiday') }}</p>
        </a>
      </li>  
      @endif
      
      @if( in_array('list_profile', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
          <i class="material-icons">person</i>
          <p>{{ __('My Profile') }}</p>
        </a>
      </li>
      @endif
     
      @if( in_array('list_manager_access', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('permission.index') }}">
        <i class="material-icons">manage_accounts</i>
          <p>{{ __('Manager Access Page') }}</p>
        </a>
      </li>
      @endif

      <!--
         <div class="collapse hide" id="user_page">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('home') }}">
              <i class="material-icons">person_outline</i>
                <span class="sidebar-normal">{{ __('User Page') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('home') }}">
              <i class="material-icons">person_add</i>
                <span class="sidebar-normal"> {{ __('Change Password') }} </span>
              </a>
            </li>
          </ul>
        </div> -->
        
  @if(in_array('list_genetate_salary', $user_permisions )  || in_array('list_email_format', $user_permisions )  ||  in_array('list_import_export', $user_permisions )   ||  in_array('list_offer_letter', $user_permisions ) )
    <li class="nav-item{{ ($activePage == 'generate-salary' || $activePage == 'generate_salary-email_format' || $activePage == 'generate_salary-import_export')  ? ' active' : '' }}">
      <a class="nav-link parent-nav-link" data-toggle="collapse" href="#generate_salary_page" aria-expanded="true">
         <i class="material-icons">account_balance</i>
          <p>{{ __('Salary Statement') }}
            <b class="caret"></b>
          </p>
      </a>
        <div class="collapse hide" id="generate_salary_page">
          <ul class="nav">
          @if( in_array('list_genetate_salary', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'generate-salary' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('generate-salary.index') }}">
                <i class="material-icons">currency_rupee</i>
                <p>{{ __('generate salary') }}</p>
              </a>
            </li>
          @endif
          @if( in_array('list_email_format', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'generate_salary-email_format' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('email-format.index') }}">
                <i class="material-icons">mail</i>
                <p>{{ __('Email Format') }}</p>
              </a>
            </li>
          @endif
          @if( in_array('list_offer_letter', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'generate_salary-offer_letter' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('offer-letter.index') }}">
                <i class="material-icons">drafts</i>
                <p>{{ __('Offer Letter Format') }}</p>
              </a>
            </li>
          @endif
          @if( in_array('list_import_export', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'generate_salary-import_export' ? ' active' : '' }}">
            @php
                $time    = time();
                $month  = date('m', $time);
                $year  = date('Y', $time);
                $subject_id = '1';
              @endphp
              <a class="nav-link" href="{{ route('import-export', [$month, $year, $subject_id]) }}">
                <i class="material-icons">import_export</i>
                <p>{{ __('Import/Export Salary') }}</p>
              </a>
            </li>
          @endif
          </ul>
        </div> 
      </a>
    </li> 
  @endif
            
      @if( in_array('list_leave_status', $user_permisions ) )
      <li class="nav-item{{ $activePage == 'leave-status' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('leave-status.index') }}">
          <i class="material-icons">weekend</i>
          <p>{{ __('Leave Status ') }}</p>
        </a>
      </li>  
      @endif
      @if( in_array('list_user', $user_permisions )  ||  in_array('list_user_role', $user_permisions )  ||  in_array('list_user_permission', $user_permisions ) )
      <li class="nav-item {{ ($activePage == 'user-add' || $activePage == 'user-role'  || $activePage == 'user-list') ? ' active' : '' }}">
        <a class="nav-link parent-nav-link" data-toggle="collapse" href="#user_role_page" aria-expanded="true">
        <i class="material-icons">admin_panel_settings</i>
        <p>{{ __('Users, Roles, Permission') }}
         <b class="caret"></b>
          </p>
        </a>
        <div class="collapse hide" id="user_role_page">
          <ul class="nav">
          @endif
     
          @if( in_array('list_user', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'user-add' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
              <i class="material-icons">person</i>
                <span class="sidebar-normal">{{ __('User Page') }} </span>
              </a>
            </li>
            @endif
      
            @if( in_array('list_user_role', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'user-role' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user-role.index') }}">
                <i class="material-icons">person_add</i>
                <p>{{ __('user Role') }}</p>
              </a>
            </li>  
            @endif
     
          @if( in_array('list_user_permission', $user_permisions ) )
            <li class="nav-item{{ $activePage == 'user-list' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user-permission.index') }}">
              <i class="material-icons">vpn_key</i>
                <span class="sidebar-normal">{{ __(' User Permission') }} </span>
              </a>
            </li>
           @endif
          </ul> 
        </div> 
      </li>  
    </ul>
  </div>
</div>
