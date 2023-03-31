<?php 
 
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\ImportExport;
use Illuminate\Http\Request;
use App\Models\LeaveStatus;
use PDF;
use App\Models\LeaveManagement;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;
use App\Models\GenrateSalary;
use App\Http\Controllers\UserPermissionController;
use Auth;
use DB;
class ImportExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('create_import_export', $user_permissions ) ){
            if(Auth()->user()->user_r == 1){
                $employees = Employee::where('deleted_date', NULL)->get();          
            }else{
                $employees = DB::table('employees') 
                ->select('*')
                ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
                ->where('permissions.manager_id', Auth()->user()->id)
                ->get();
            } 
            $emails = Email::where('deleted_date', NULL)->get();
            return view('pages.generate_salary.import_export')->with('employees', $employees);

        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImportExport  $importExport
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$month, $year,$subject_id)
    { 
        $daysInMonth = cal_days_in_month(0, $month, $year);
        //current month first day
        $end_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-'.$daysInMonth ));
        $start_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-01' ));
        $employees = Employee::where('deleted_date', NULL)->get();
        $emails = Email::where('deleted_date', NULL)->get();
        $leaves = LeaveManagement::where('deleted_date', NULL)->with('leave_info')->where('leave_date', '>=', $start_month_date )->where('leave_date', '<=', $end_month_date)->pluck('employee_id')->toArray();
        $leaves_count = 0;
        if(!empty( $leaves[0] )){
            $leaves_count = array_count_values($leaves);
        }
        // print_r('<pre>');
        // print_r($leaves);
        // die();
        return view('pages.generate_salary.import_export')->with('month', $month)->with('year', $year)->with('emails', $emails)->with('subject_id', $subject_id)->with('leaves', $leaves_count)->with('employees', $employees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImportExport  $importExport
     * @return \Illuminate\Http\Response
     */
    public function edit(ImportExport $importExport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImportExport  $importExport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportExport $importExport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImportExport  $importExport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportExport $importExport)
    {
        //
    }
}
