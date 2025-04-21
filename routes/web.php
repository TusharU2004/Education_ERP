<?php

use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\Backend\Report\StudentIDController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\student\StudentTimeTableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\Student\attendance\StudentAttendance;
use App\Http\Controllers\student\exam\StudentResultController;
use App\Http\Controllers\student\fee\FeeController;
use App\Http\Controllers\Student\fee\PaymentController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\subject\StudentSubjectController;
use App\Http\Controllers\student\timetable\StudentClassTimeTable;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;

use App\Http\Controllers\Backend\Setup\SchoolLogoController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\FeeAmountControllere;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\SchoolSubjectController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;
use App\Http\Controllers\Backend\Setup\DesignationController;
use App\Http\Controllers\Backend\Student\StudentRegController;
use App\Http\Controllers\Backend\Student\StudentRollController;
use App\Http\Controllers\Backend\Student\RegistrationFeeController;
use App\Http\Controllers\Backend\Student\MonthlyFeeController;
use App\Http\Controllers\Backend\Student\StudentAttendanceController;

use App\Http\Controllers\Backend\Employee\EmployeeRegController;
use App\Http\Controllers\Backend\Employee\EmployeeSalaryController;
use App\Http\Controllers\Backend\Employee\EmployeeLeaveController;
use App\Http\Controllers\Backend\Employee\EmployeeAttendanceController;
use App\Http\Controllers\Backend\Employee\MonthlySalaryController;

use App\Http\Controllers\Backend\Marks\MarksController;

use App\Http\Controllers\Backend\DefaultController;

use App\Http\Controllers\Backend\Account\StudentFeeController;
use App\Http\Controllers\Backend\Account\AccountSalaryController;
use App\Http\Controllers\Backend\Account\OtherCostController;

use App\Http\Controllers\Backend\Report\ProfiteController;
use App\Http\Controllers\Backend\Report\MarkSheetController;
use App\Http\Controllers\Backend\Report\AttenReportController;


use App\Http\Controllers\Student\StudentController;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
Route::get('/student/logout', [StudentController::class, 'logout'])->name('student.logout');

Route::get('/admin/logout', [AdminController::class, 'Logout'])->name('admin.logout');

Route::group(['middleware' => 'auth'], function () {


    Route::prefix('users')->group(function () {

        //user route
        Route::get('/', [UserController::class, 'index'])->name('users.view');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('store.users');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update.users');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete.users');

    });

    //rolepermission route
    Route::prefix('rolepermission')->group(function () {

        //permissions route
        Route::get('permission/', [PermissionController::class, 'index'])->name('permission.view');
        Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('permission/store', [PermissionController::class, 'Store'])->name('store.permission');
        Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('permission/update/{id}', [PermissionController::class, 'update'])->name('update.permission');
        Route::get('permission/destroy/{id}', [PermissionController::class, 'destroy'])->name('destroy.permission');

        //roles route
        Route::get('roles/', [RoleController::class, 'index'])->name('roles.view');
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles/store', [RoleController::class, 'store'])->name('store.roles');
        Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/update/{id}', [RoleController::class, 'update'])->name('update.roles');
        Route::get('roles/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy.roles');
    });

    /// User Profile and Change Password 
    Route::prefix('profile')->group(function () {

        //user profile
        Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/edit', [ProfileController::class, 'PasswordEdit'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');

    });


    /// User Profile and Change Password
    Route::prefix('setups')->group(function () {

        Route::get('school/logo', [SchoolLogoController::class, 'edit'])->name('school.logo');
        Route::post('school/logo/update', [SchoolLogoController::class, 'update'])->name('school.logo.update');

        // Student Class Routes
        Route::get('student/class', [StudentClassController::class, 'ViewStudent'])->name('student.class.view');
        Route::get('student/class/add', [StudentClassController::class, 'StudentClassAdd'])->name('student.class.add');
        Route::post('student/class/store', [StudentClassController::class, 'StudentClassStore'])->name('store.student.class');
        Route::get('student/class/edit/{id}', [StudentClassController::class, 'StudentClassEdit'])->name('student.class.edit');
        Route::post('student/class/update/{id}', [StudentClassController::class, 'StudentClassUpdate'])->name('update.student.class');
        Route::get('student/class/delete/{id}', [StudentClassController::class, 'StudentClassDelete'])->name('student.class.delete');

        // Student Year Routes 
        Route::get('student/year', [StudentYearController::class, 'ViewYear'])->name('student.year.view');
        Route::get('student/year/add', [StudentYearController::class, 'StudentYearAdd'])->name('student.year.add');
        Route::post('student/year/store', [StudentYearController::class, 'StudentYearStore'])->name('store.student.year');
        Route::get('student/year/edit/{id}', [StudentYearController::class, 'StudentYearEdit'])->name('student.year.edit');
        Route::post('student/year/update/{id}', [StudentYearController::class, 'StudentYearUpdate'])->name('update.student.year');
        Route::get('student/year/delete/{id}', [StudentYearController::class, 'StudentYearDelete'])->name('student.year.delete');

        // Student Group Routes 
        Route::get('student/group', [StudentGroupController::class, 'ViewGroup'])->name('student.group.view');
        Route::get('student/group/add', [StudentGroupController::class, 'StudentGroupAdd'])->name('student.group.add');
        Route::post('student/group/store', [StudentGroupController::class, 'StudentGroupStore'])->name('store.student.group');
        Route::get('student/group/edit/{id}', [StudentGroupController::class, 'StudentGroupEdit'])->name('student.group.edit');
        Route::post('student/group/update/{id}', [StudentGroupController::class, 'StudentGroupUpdate'])->name('update.student.group');
        Route::get('student/group/delete/{id}', [StudentGroupController::class, 'StudentGroupDelete'])->name('student.group.delete');

        // Student Shift Routes
        Route::get('student/shift', [StudentShiftController::class, 'ViewShift'])->name('student.shift.view');
        Route::get('student/shift/add', [StudentShiftController::class, 'StudentShiftAdd'])->name('student.shift.add');
        Route::post('student/shift/store', [StudentShiftController::class, 'StudentShiftStore'])->name('store.student.shift');
        Route::get('student/shift/edit/{id}', [StudentShiftController::class, 'StudentShiftEdit'])->name('student.shift.edit');
        Route::post('student/shift/update/{id}', [StudentShiftController::class, 'StudentShiftUpdate'])->name('update.student.shift');
        Route::get('student/shift/delete/{id}', [StudentShiftController::class, 'StudentShiftDelete'])->name('student.shift.delete');

        // Fee Category Routes
        Route::get('fee/category', [FeeCategoryController::class, 'ViewFeeCat'])->name('fee.category.view');
        Route::get('fee/category/add', [FeeCategoryController::class, 'FeeCatAdd'])->name('fee.category.add');
        Route::post('fee/category/store', [FeeCategoryController::class, 'FeeCatStore'])->name('store.fee.category');
        Route::get('fee/category/edit/{id}', [FeeCategoryController::class, 'FeeCatEdit'])->name('fee.category.edit');
        Route::post('fee/category/update/{id}', [FeeCategoryController::class, 'FeeCategoryUpdate'])->name('update.fee.category');
        Route::get('fee/category/delete/{id}', [FeeCategoryController::class, 'FeeCategoryDelete'])->name('fee.category.delete');

        // Fee Category Amount Routes 
        Route::get('fee/amount', [FeeAmountControllere::class, 'ViewFeeAmount'])->name('fee.amount.view');
        Route::get('fee/amount/add', [FeeAmountControllere::class, 'AddFeeAmount'])->name('fee.amount.add');
        Route::post('fee/amount/store', [FeeAmountControllere::class, 'StoreFeeAmount'])->name('store.fee.amount');
        Route::get('fee/amount/edit/{fee_category_id}', [FeeAmountControllere::class, 'EditFeeAmount'])->name('fee.amount.edit');
        Route::post('fee/amount/update/{fee_category_id}', [FeeAmountControllere::class, 'UpdateFeeAmount'])->name('update.fee.amount');
        Route::get('fee/amount/details/{fee_category_id}', [FeeAmountControllere::class, 'DetailsFeeAmount'])->name('fee.amount.details');

        // Exam Type Routes 
        Route::get('exam/type', [ExamTypeController::class, 'ViewExamType'])->name('exam.type.view');
        Route::get('exam/type/add', [ExamTypeController::class, 'ExamTypeAdd'])->name('exam.type.add');
        Route::post('exam/type/store', [ExamTypeController::class, 'ExamTypeStore'])->name('store.exam.type');
        Route::get('exam/type/edit/{id}', [ExamTypeController::class, 'ExamTypeEdit'])->name('exam.type.edit');
        Route::post('exam/type/update/{id}', [ExamTypeController::class, 'ExamTypeUpdate'])->name('update.exam.type');
        Route::get('exam/type/delete/{id}', [ExamTypeController::class, 'ExamTypeDelete'])->name('exam.type.delete');

        // School Subject All Routes 
        Route::get('school/subject', [SchoolSubjectController::class, 'ViewSubject'])->name('school.subject.view');
        Route::get('school/subject/add', [SchoolSubjectController::class, 'SubjectAdd'])->name('school.subject.add');
        Route::post('school/subject/store', [SchoolSubjectController::class, 'SubjectStore'])->name('store.school.subject');
        Route::get('school/subject/edit/{id}', [SchoolSubjectController::class, 'SubjectEdit'])->name('school.subject.edit');
        Route::post('school/subject/update/{id}', [SchoolSubjectController::class, 'SubjectUpdate'])->name('update.school.subject');
        Route::get('school/subject/delete/{id}', [SchoolSubjectController::class, 'SubjectDelete'])->name('school.subject.delete');

        // Assign Subject Routes 
        Route::get('assign/subject', [AssignSubjectController::class, 'ViewAssignSubject'])->name('assign.subject.view');
        Route::get('assign/subject/add', [AssignSubjectController::class, 'AddAssignSubject'])->name('assign.subject.add');
        Route::post('assign/subject/store', [AssignSubjectController::class, 'StoreAssignSubject'])->name('store.assign.subject');
        Route::get('assign/subject/edit/{class_id}', [AssignSubjectController::class, 'EditAssignSubject'])->name('assign.subject.edit');
        Route::post('assign/subject/update/{class_id}', [AssignSubjectController::class, 'UpdateAssignSubject'])->name('update.assign.subject');
        Route::get('assign/subject/details/{class_id}', [AssignSubjectController::class, 'DetailsAssignSubject'])->name('assign.subject.details');

        // Designation All Routes 
        Route::get('designation', [DesignationController::class, 'ViewDesignation'])->name('designation.view');
        Route::get('designation/add', [DesignationController::class, 'DesignationAdd'])->name('designation.add');
        Route::post('designation/store', [DesignationController::class, 'DesignationStore'])->name('store.designation');
        Route::get('designation/edit/{id}', [DesignationController::class, 'DesignationEdit'])->name('designation.edit');
        Route::post('designation/update/{id}', [DesignationController::class, 'DesignationUpdate'])->name('update.designation');
        Route::get('designation/delete/{id}', [DesignationController::class, 'DesignationDelete'])->name('designation.delete');

    });


    // Student Registration Routes  
    Route::prefix('students')->group(function () {

        //Student Registration Routes
        Route::get('/reg', [StudentRegController::class, 'StudentRegView'])->name('student.registration.view');
        Route::get('/reg/Add', [StudentRegController::class, 'StudentRegAdd'])->name('student.registration.add');
        Route::post('/reg/store', [StudentRegController::class, 'StudentRegStore'])->name('store.student.registration');
        Route::get('/reg/inactive/{student_id}', [StudentRegController::class, 'StudentInactive'])->name('student.inactive');
        Route::get('/reg/edit/{student_id}', [StudentRegController::class, 'StudentRegEdit'])->name('student.registration.edit');
        Route::post('/reg/update/{student_id}', [StudentRegController::class, 'StudentRegUpdate'])->name('update.student.registration');
        Route::get('/reg/details/{student_id}', [StudentRegController::class, 'StudentRegDetails'])->name('student.registration.details');

        //Student Roll Number Routes
        Route::get('/roll/generate', [StudentRollController::class, 'StudentRollView'])->name('roll.generate.view');
        Route::post('/roll/generate/store', [StudentRollController::class, 'StudentRollStore'])->name('roll.generate.store');

        // Registration Fee Routes 
        Route::get('/reg/fee', [RegistrationFeeController::class, 'RegFeeView'])->name('registration.fee.view');
        Route::get('/reg/fee/payslip', [RegistrationFeeController::class, 'RegFeePayslip'])->name('student.registration.fee.payslip');
        Route::post('reg/fee/send-whatsapp', [RegistrationFeeController::class, 'generateAndSendReceipt'])->name('student.registration.fee.send');

        // Monthly Fee Routes
        Route::get('/monthly/fee', [MonthlyFeeController::class, 'MonthlyFeeView'])->name('monthly.fee.view');
        Route::get('/monthly/fee/payslip/{data}', [MonthlyFeeController::class, 'MonthlyFeePayslip'])->name('student.monthly.fee.payslip');
        Route::post('/send-whatsapp', [WhatsAppController::class, 'sendWhatsAppMessage'])->name('send.whatsapp');

        //Student Attendance Routes
        Route::get('attendance/student', [StudentAttendanceController::class, 'AttendanceView'])->name('student.attendance.view');
        Route::get('attendance/student/add', [StudentAttendanceController::class, 'AttendanceAdd'])->name('student.attendance.add');
        Route::get('attendance/student/getstudent', [StudentAttendanceController::class, 'getStudentdetails'])->name('student.attendance.getstudent');
        Route::post('attendance/student/store', [StudentAttendanceController::class, 'AttendanceStore'])->name('store.student.attendance');
        Route::post('send-daily-attendance-whatsapp', [StudentAttendanceController::class, 'sendDailyAttendanceWhatsApp'])->name('send.daily.attendance.whatsapp');

        //Class TimeTable Routes
        Route::get('timetable', [StudentTimeTableController::class, 'TimeTableView'])->name('student.timetable.view');
        Route::get('timetable/add', [StudentTimeTableController::class, 'TimeTableAdd'])->name('student.timetable.add');
        Route::post('timetable/store', [StudentTimeTableController::class, 'TimeTableStore'])->name('student.timetable.store');
        Route::get('timetable/edit/{id}', [StudentTimeTableController::class, 'TimeTableEdit'])->name('student.timetable.edit');
        Route::post('timetable/update/{id}', [StudentTimeTableController::class, 'TimeTableUpdate'])->name('student.timetable.update');
        Route::get('timetable/delete/{id}', [StudentTimeTableController::class, 'TimeTableDelete'])->name('student.timetable.delete');

    });


    /// Employee Registration Routes
    Route::prefix('employees')->group(function () {

        //Employee Registration Routes
        Route::get('reg/employee', [EmployeeRegController::class, 'EmployeeView'])->name('employee.registration.view');
        Route::get('reg/employee/add', [EmployeeRegController::class, 'EmployeeAdd'])->name('employee.registration.add');
        Route::post('reg/employee/store', [EmployeeRegController::class, 'EmployeeStore'])->name('store.employee.registration');
        Route::get('reg/employee/edit/{id}', [EmployeeRegController::class, 'EmployeeEdit'])->name('employee.registration.edit');
        Route::post('reg/employee/update/{id}', [EmployeeRegController::class, 'EmployeeUpdate'])->name('update.employee.registration');
        Route::get('reg/employee/details/{id}', [EmployeeRegController::class, 'EmployeeDetails'])->name('employee.registration.details');

        // Employee Salary Routes 
        Route::get('salary/employee', [EmployeeSalaryController::class, 'SalaryView'])->name('employee.salary.view');
        Route::get('salary/employee/increment/{id}', [EmployeeSalaryController::class, 'SalaryIncrement'])->name('employee.salary.increment');
        Route::post('salary/employee/store/{id}', [EmployeeSalaryController::class, 'SalaryStore'])->name('update.increment.store');
        Route::get('salary/employee/details/{id}', [EmployeeSalaryController::class, 'SalaryDetails'])->name('employee.salary.details');


        // Employee Leave All Routes 
        Route::get('leave/employee', [EmployeeLeaveController::class, 'LeaveView'])->name('employee.leave.view');
        Route::get('leave/employee/add', [EmployeeLeaveController::class, 'LeaveAdd'])->name('employee.leave.add');
        Route::post('leave/employee/store', [EmployeeLeaveController::class, 'LeaveStore'])->name('store.employee.leave');
        Route::get('leave/employee/edit/{id}', [EmployeeLeaveController::class, 'LeaveEdit'])->name('employee.leave.edit');
        Route::post('leave/employee/update/{id}', [EmployeeLeaveController::class, 'LeaveUpdate'])->name('update.employee.leave');
        Route::get('leave/employee/delete/{id}', [EmployeeLeaveController::class, 'LeaveDelete'])->name('employee.leave.delete');


        // Employee Attendance All Routes 
        Route::get('attendance/employee', [EmployeeAttendanceController::class, 'AttendanceView'])->name('employee.attendance.view');
        Route::get('attendance/employee/add', [EmployeeAttendanceController::class, 'AttendanceAdd'])->name('employee.attendance.add');
        Route::post('attendance/employee/store', [EmployeeAttendanceController::class, 'AttendanceStore'])->name('store.employee.attendance');
        Route::get('attendance/employee/edit/{date}', [EmployeeAttendanceController::class, 'AttendanceEdit'])->name('employee.attendance.edit');
        Route::get('attendance/employee/details/{date}', [EmployeeAttendanceController::class, 'AttendanceDetails'])->name('employee.attendance.details');


        // Employee Monthly Salary All Routes 
        Route::get('monthly/salary', [MonthlySalaryController::class, 'MonthlySalaryView'])->name('employee.monthly.salary');
        Route::get('monthly/salary/get', [MonthlySalaryController::class, 'MonthlySalaryGet'])->name('employee.monthly.salary.get');
        Route::get('monthly/salary/payslip/{employee_id}/{month}', [MonthlySalaryController::class, 'MonthlySalaryPayslip'])->name('employee.monthly.salary.payslip');

    });


    /// Marks Management Routes  
    Route::prefix('marks')->group(function () {

        // Marks Entry Routes
        Route::get('marks/entry', [MarksController::class, 'MarksAdd'])->name('marks.entry.add');
        Route::get('marks/entry/get', [MarksController::class, 'GetMarksData'])->name('marks.entry.get');
        Route::post('marks/entry/store', [MarksController::class, 'MarksStore'])->name('marks.entry.store');

        // Get Subject Routes
        Route::get('marks/getsubject', [DefaultController::class, 'GetSubject'])->name('marks.getsubject');
        Route::get('student/marks/getstudents', [DefaultController::class, 'GetStudents'])->name('student.marks.getstudents');

        // Marks View Routes
        Route::get('marks', [MarksController::class, 'MarksView'])->name('marks.entry.view');
    });


    /// Account Management Routes  
    Route::prefix('accounts')->group(function () {

        // Student Fee Routes
        Route::get('student/fee', [StudentFeeController::class, 'StudentFeeView'])->name('student.fee.view');
        Route::get('student/fee/add', [StudentFeeController::class, 'StudentFeeAdd'])->name('student.fee.add');
        Route::get('student/fee/getstudent', [StudentFeeController::class, 'StudentFeeGetStudent'])->name('account.fee.getstudent');
        Route::post('student/fee/store', [StudentFeeController::class, 'StudentFeeStore'])->name('account.fee.store');

        // Employee Salary Routes
        Route::get('account/salary', [AccountSalaryController::class, 'AccountSalaryView'])->name('account.salary.view');
        Route::get('account/salary/add', [AccountSalaryController::class, 'AccountSalaryAdd'])->name('account.salary.add');
        Route::get('account/salary/getemployee', [AccountSalaryController::class, 'AccountSalaryGetEmployee'])->name('account.salary.getemployee');
        Route::post('account/salary/store', [AccountSalaryController::class, 'AccountSalaryStore'])->name('account.salary.store');

        // Other Cost Routes
        Route::get('other/cost', [OtherCostController::class, 'OtherCostView'])->name('other.cost.view');
        Route::get('other/cost/add', [OtherCostController::class, 'OtherCostAdd'])->name('other.cost.add');
        Route::post('other/cost/store', [OtherCostController::class, 'OtherCostStore'])->name('store.other.cost');
        Route::get('other/cost/edit/{id}', [OtherCostController::class, 'OtherCostEdit'])->name('other.cost.edit');
        Route::post('other/cost/update/{id}', [OtherCostController::class, 'OtherCostUpdate'])->name('update.other.cost');
        Route::get('other/cost/delete/{id}', [OtherCostController::class, 'OtherCostDelete'])->name('other.cost.delete');

    });


    /// Report Management All Routes
    Route::prefix('reports')->group(function () {

        //profit report
        Route::get('monthly/profit', [ProfiteController::class, 'MonthlyProfitView'])->name('monthly.profit.view');
        Route::get('monthly/profit/pdf', [ProfiteController::class, 'MonthlyProfitPdf'])->name('report.profit.pdf');

        //genrate marksheet
        Route::get('marksheet/generate', [MarkSheetController::class, 'MarkSheetView'])->name('marksheet.generate.view');
        Route::get('marksheet/generate/get', [MarkSheetController::class, 'MarkSheetGet'])->name('report.marksheet.get');

        // employee Attendance Report 
        Route::get('employee/attendance/report', [AttenReportController::class, 'employeeAttenReportView'])->name('employeeattendance.report.view');
        Route::get('employee/report/attendance/get', [AttenReportController::class, 'employeeAttenReportGet'])->name('report.employeeattendance.get');

        // student Attendance Report
        Route::get('student/attendance/report', [AttenReportController::class, 'studentAttenReportView'])->name('studentattendance.report.view');
        Route::get('student/report/attendance/get', [AttenReportController::class, 'studentAttenReportGet'])->name('report.studentattendance.get');

        // Student ID Card Routes
        Route::get('student/idcard', [StudentIDController::class, 'IdcardView'])->name('student.idcard.view');
        Route::get('student/idcard/{id_no}/{id}', [StudentIDController::class, 'IdcardGenrate'])->name('student.idcard.get');

    });

    //Notification Routes
    Route::get('notification/create', [WhatsAppController::class, 'create'])->name('notification.create');
    Route::post('notification/send', [WhatsAppController::class, 'sendNotification'])->name('notification.send');
});


Route::group(['middleware' => 'auth'], function () {
    
    // Student Profile Route
    Route::prefix('student/Profile/')->group(function () {

        // Student Profile Routes
        Route::get('/view', [StudentProfileController::class, 'ProfileView'])->name('student.profile.view');
        Route::get('/password/view', [StudentProfileController::class, 'PasswordView'])->name('student.password.view');
        Route::post('/password/update', [StudentProfileController::class, 'PasswordUpdate'])->name('student.password.update');
    });

    // Student Subject Route
    Route::get('student/subjects/view',[StudentSubjectController::class,'SubjectView'])->name('subject.view');

    // Student Class Time Table Route
    Route::get('student/timetable/view',[StudentClassTimeTable::class,'TimeTableView'])->name('subject.timetable.view');

    // Student Attendance Route
    Route::get('student/attendance/view',[StudentAttendance::class,'AttendanceView'])->name('attendance.view');

    // Student Result Route
    Route::get('student/result/view',[StudentResultController::class,'ResultView'])->name('student.exam.result');

    // Student Fee Route
    Route::prefix('student/fee')->group(function (){
        Route::get('registration',[FeeController::class,'RegistrationView'])->name('student.fee.registration');
        Route::get('month',[FeeController::class,'MonthlyFeeView'])->name('student.fee.monthly');
        Route::post('initiate-payment',[PaymentController::class,'initiatePayment'])->name('student.pay.monthly.fee');
        Route::post('payment-success',[PaymentController::class,'paymentSuccess'])->name('student.payment.success');
        Route::get('view-receipt/{month}',[PaymentController::class,'ViewReceipt'])->name('student.view.receipt');

    });
});

Route::get('query',[QueryController::class,'query']);