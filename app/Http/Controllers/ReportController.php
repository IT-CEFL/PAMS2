<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Gridphp;

class ReportController extends Controller
{
    public function view(){
        $user = Auth::user();

        $grid = Gridphp::get();

        $opt["caption"] = "All Application";
        $opt["autowidth"] = false; // no change from current view
        $opt["multiselect"] = false;
        $opt["footerrow"] = true;
        $opt["cmTemplate"]["visible"] = "xs+"; // show all column on small screens
        $opt["shrinkToFit"] = false; // enable horizontal scrollbar
        $opt["view_options"]['width']='550';

        $opt["detail_grid_id"] = "list2";

        $opt["export"] = array("filename"=>"all_application_".date('Ymd'), "heading"=>"Invoice Details", "orientation"=>"landscape", "paper"=>"a4");
        $opt["export"]["sheetname"] = "Test";
        $grid->set_options($opt);

        $grid->set_actions(array(    
                                "add"=>false, // allow/disallow add
                                "edit"=>false, // allow/disallow edit
                                "rowactions"=>false,
                                "delete"=>false, // allow/disallow delete
                                "export_excel"=>true, // export excel button
                                "export_pdf"=>true, // export pdf button
                                
                            ) 
                        );

                        //base command
                        $sql = "SELECT applications.id, applications.applicationNumber, user.name, centres.CentreName, departments.DeptName, ".
                                "types.typeName, applications.status, currencies.currencyName, applications.expectedAmount, applications.file, applications.remark, applications.created_at ".
                                "FROM applications LEFT JOIN user ON applications.userID=user.id ".
                                "LEFT JOIN centres ON user.centreID=centres.id ".
                                "LEFT JOIN departments ON user.deptID=departments.id ".
                                "LEFT JOIN types ON applications.TypeID=types.id ".
                                "LEFT JOIN currencies ON applications.CurrencyID=currencies.id ".
                                "WHERE applications.status IS NOT NULL ";
                        foreach($user->role->access as $access){
                            if($access->moduleID == '4'){
                                $sql.="";
                            }elseif($access->moduleID == '7'){
                                $sql.=" AND user.deptID=".$user->deptID;
                            }elseif($access->moduleID == '6') {
                                $sql.=" OR user.deptID='11' ";
                            }
                        }
        $grid->select_command = $sql;
        
        $grid->table = "applications";
        // 
        $cols = array();

        $col1 = array();
        $col1["title"] = "ID";
        $col1["name"] = "id";
        $col1["dbname"]='tblapplication.id';
        $col1["hidden"] = true;
        $col1["view"] = false;
        $col1["show"] = array("view"=>false);
        $cols[] = $col1;


        $col2 = array();
        $col2["title"] = "Application No.";
        $col2["name"] = "applicationNumber";
        $col2["dbname"]='applications.applicationNumber';
        $col2["formatter"] = "string";
        $col2["align"] = "center";
        $col2["width"] = "94";
        $cols[] = $col2;

        $col3 = array();
        $col3["title"] = "Name";
        $col3["name"] = "name";
        $col3["dbname"] = "user.name";
        // $col3["sortname"] = ""; // render as select
        // $col3["width"] = "40";
        $cols[] = $col3;

        $col4 = array();
        $col4["title"] = "Centre";
        $col4["name"] = "CentreName";
        $col4["dbname"] = 'centres.CentreName';
        $col4["sortname"] = ""; // render as select
        // $col4["width"] = "40";
        $col4["editoptions"] = true;
        $col4["edittype"] = "lookup";
        $col4["editoptions"] = array("table"=>"centres", "id"=>"CentreName", "label"=>"CentreName");
        $cols[] = $col4;

        $col5 = array();
        $col5["title"] = "Department";
        $col5["name"] = "DeptName";
        $col5["dbname"] = 'departments.DeptName';
        $col5["sortname"] = ""; // render as select
        // $col5["width"] = "90";
        $col5["editoptions"] = true;
        // $col5["edittype"] = "lookup";
        $col5["edittype"] = "select";
        $col5["editoptions"] = array("table"=>"departments", "id"=>"DeptName", "label"=>"DeptName", "Order"=>"DeptName");
        $cols[] = $col5;

        $col6 = array();
        $col6["title"] = "Type";
        $col6["name"] = "typeName";
        $col6["dbname"] = 'types.typeName';
        $col6["sortname"] = ""; // render as select
        // $col6["width"] = "50";
        $col6["editoptions"] = true;
        $col6["align"] = "left";
        $col6["edittype"] = "lookup";
        $col6["editoptions"] = array("table"=>"types", "id"=>"TypeName", "label"=>"TypeName");
        $cols[] = $col6;

        $col7 = array();
        $col7["title"] = "Status";
        $col7["name"] = "status";
        $col7["dbname"] = 'applications.status';
        $col7["sortname"] = ""; // render as select
        // $col7["width"] = "50";
        $col7["editoptions"] = true;
        $col7["align"] = "left";
        // $col7["stype"] = "select";
        // $col7["searchoptions"] = array("value"=>'Completed:Completed;Requiring Attention:Requiring Attention;Rejected:Rejected;Approved:Approved;Approved-Pending Docs:Approved-Pending Docs');
        $cols[] = $col7;

        $col8 = array();
        $col8["title"] = "Currency";
        $col8["name"] = "currencyName";
        $col8["dbname"] = 'currencies.currencyName';
        $col8["sortname"] = ""; // render as select
        // $col8["width"] = "30";
        $col8["editoptions"] = true;
        $col8["align"] = "center";
        $col8["edittype"] = "lookup";
        $col8["editoptions"] = array("table"=>"currencies", "id"=>"CurrencyName", "label"=>"CurrencyName");
        $cols[] = $col8;

        $col9 = array();
        $col9["title"] = "Expected Amount";
        $col9["name"] = "expectedAmount";
        $col9["dbname"] = 'applications.expectedAmount';
        // $col9["width"] = "50";
        $col9["editable"] = true;
        $col9["formatter"] = "currency";
        $col9["formatoptions"] = array(
                                        "suffix" =>"",
                                        "thousandsSeparator" => ",",
                                        "decimalSeparator" => ".",
                                        "decimalPlaces" => 2);
        $cols[] = $col9;

        $url=$_SERVER['HTTP_HOST'];

        $col10 = array();
        $col10["title"] = "Uploaded Document";
        $col10["name"] = "file";
        $col10["dbname"] = 'applications.file';
        $col10["search"] = false;
        $col10["align"] = "center";
        $col10["formatter"] = "function(cellval,options,rowdata){ if(cellval!=\"\"){ return '<a target=\"_blank\" href=\"http://".$url."'+cellval+'\"><b>Document</b></a>';}else{ return '&nbsp;-&nbsp;';} }";
        $col10["unformat"] = "function(cellval,options,cell){ if(cellval!=\"\"){return $('a', cell).attr('href').replace('http://','');} }";
        $col10["view_options"]['width']='500';
        $cols[] = $col10;

        $col11 = array();
        $col11["title"] = "Remark";
        $col11["name"] = "remark";
        $col11["dbname"] = 'applications.remark';
        $col11["sortname"] = ""; // render as select
        // $col11["width"] = "500";
        $col11["editoptions"] = false;
        $col11["align"] = "left";
        $cols[] = $col11;


        $col12 = array();
        $col12["title"] = "Submission Date";
        $col12["name"] = "created_at";
        $col12["dbname"] = "applications.created_at";
        $col12["width"] = "200";
        $col12["align"] = "center";
        $col12["formatter"] = "date";
        $col12["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d/m/Y');

        $col12["editable"] = true; // this sumn is editable
        $col12["editoptions"] = array("size"=>20, "defaultValue" => date("Y-m-d"));

        // date range filter in toolbar
        $col12["stype"] = "daterange";

        // Update options for date range picker: http://tamble.github.io/jquery-ui-daterangepicker/#options
        $col12["searchoptions"]["opts"] = array("initialText"=>"Select date range...");

        // to set custom ranges
        // $col["searchoptions"]["opts"]["presetRanges"] = array( array ("text"=>'Test', "dateStart" => "function() { return moment() }", "dateEnd"=>  "function() { return moment().add('weeks', 1).endOf('week'); }" ) );

        // Update additional datepicker options: http://api.jqueryui.com/datepicker/#options
        // $col["searchoptions"]["opts"]["datepickerOptions"] = array("maxDate"=>"-1d", "numberOfMonths"=>2);

        $col12["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
        $cols[] = $col12;


        $grid->set_columns($cols,true);

        //$e = array();
        $e["on_render_pdf"] = array("set_pdf_format", null);
        // $e["on_data_display"] = array("pre_render","",true);
        //$e["on_render_pdf"] = array("render_pdf", null, true);
        $e["on_render_excel"] = array("filter_xls", null, true);
        $e["js_on_select_row"] = "grid_onselect";
        $e["js_on_load_complete"] = "grid_onload";

        $grid->set_events($e);

        
        $out_master = $grid->render("list1");

        // filter PDF output
        function filter_pdf($param)
        {
            for($x=1; $x<count($param["data"]); $x++)
                $param["data"][$x]["note"] = "<img src='http://www.phpgrid.org/wp-content/uploads/customer-logos/iba.jpg'>"; // must be jpg
        }
        // filter Excel output
        function filter_xls($param)
        {
            for($x=1; $x<count($param["data"]); $x++){
                $param["data"][$x]["note"] = $param["data"][$x]["note"];
            }
        }
        // detail grid
        $grid2 = Gridphp::get();

        $opt2 = array();	
        $opt2["datatype"] = "local"; // stop loading detail grid at start
        $opt2["height"] = ""; // autofit height of subgrid
        $opt2["caption"] = "Tracking History"; // caption of grid
        $opt2["multiselect"] = false; // allow you to multi-select through checkboxes
        $opt2["reloadedit"] = true; // reload after inline edit
        $opt2["sortname"] = "updated_at";

        $grid2->set_options($opt2);

        // receive id, selected row of parent grid
        $id = intval($_GET["rowid"]);
        $grid2->set_actions(array(    
                                "add"=>false, // allow/disallow add
                                "edit"=>false, // allow/disallow edit
                                "rowactions"=>false,
                                "delete"=>false, // allow/disallow delete
                                "export_excel"=>true, // export excel button
                                "export_pdf"=>true, // export pdf button
                            ) 
                        );
        // and use in sql for filteration
        $grid2->select_command = "SELECT applications.ApplicationNumber, user.name,application_trackings.remark,application_trackings.status,application_trackings.fileUpload,application_trackings.updated_at ".
                                "FROM application_trackings LEFT JOIN applications ON application_trackings.ApplicationID=applications.id ".
                                "LEFT JOIN user ON application_trackings.approverID=user.ID ".
                                "WHERE application_trackings.ApplicationID= $id";

        // this db table will be used for add,edit,delete
        $grid2->table = "application_trackings";
        $cols2 = array();

        $colt = array();
        $colt["title"] = "Application No.";
        $colt["name"] = "ApplicationNumber";
        $colt["formatter"] = "string";
        $colt["align"] = "center";
        $cols2[] = $colt;

        $colt2 = array();
        $colt2["title"] = "Name";
        $colt2["name"] = "name";
        $colt2["formatter"] = "string";
        $cols2[] = $colt2;

        $colt2 = array();
        $colt2["title"] = "Remark";
        $colt2["name"] = "remark";
        $colt2["formatter"] = "string";
        $cols2[] = $colt2;

        $colt4 = array();
        $colt4["title"] = "Uploaded Document";
        $colt4["name"] = "fileUpload";
        $colt4["dbname"] = "fileUpload";
        $colt4["search"] = false;
        $colt4["align"] = "center";
        $colt4["formatter"] = "function(cellval,options,rowdata){ if(cellval!=\"\"){ return '<a target=\"_blank\" href=\"http://".$url."'+cellval+'\"><b>Document</b></a>';}else{ return '&nbsp;-&nbsp;';} }";
        $colt4["unformat"] = "function(cellval,options,cell){ if(cellval!=\"\"){return $('a', cell).attr('href').replace('http://','');} }";
        $cols2[] = $colt4;

        $colt5 = array();
        $colt5["title"] = "Update At";
        $colt5["name"] = "updated_at";
        $colt5["align"] = "center";
        $cols2[] = $colt5;

        $grid2->set_columns($cols2,true);

        $out_detail = $grid2->render("list2");

        return view('report',['grid'=>$out_master, 'grid2'=>$out_detail, 'user'=>$user]);
    }
}
