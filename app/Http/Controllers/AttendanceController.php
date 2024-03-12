<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

use Rats\Zkteco\Lib\ZKTeco;
use Yajra\Datatables\Datatables;

use DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function at(){
        
        $zk = new ZKTeco('172.100.0.22',4370);
        $log = "<br/>";
        if($zk->connect()){
            $log = $log."LOG: CONECTANDO PALACIO 01.<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = 0;
            foreach (array_chunk($attendances,1000) as $a){
                $data += DB::table('attendances')->insertOrIgnore($a);
            }
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a PALACIO 01.<br/>";
        }
       

        $zk = new ZKTeco('172.100.0.29',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO PALACIO 02.<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = 0;
            foreach (array_chunk($attendances,1000) as $a){
                $data += DB::table('attendances')->insertOrIgnore($a);
            }
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a PALACIO 02.<br/>";
        }

        /*
        $zk = new ZKTeco('192.77.77.201',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO COLISEO MUNICIPAL--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a COLISEO MUNICIPAL--<br/>";
        }

        $zk = new ZKTeco('192.77.77.202',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO MERCADO MODELO--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a MERCADO MODELO--<br/>";
        }

        $zk = new ZKTeco('172.100.0.20',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO FABRICA DE TUBOS--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a FABRICA DE TUBOS--<br/>";
        }

        $zk = new ZKTeco('192.77.77.203',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO TEATRO MUNICIPAL--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a TEATRO MUNICIPAL--<br/>";
        }

        $zk = new ZKTeco('192.77.77.207',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO TERMINAL PAVAYOC--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a TERMINAL PAVAYOC--<br/>";
        }

        $zk = new ZKTeco('172.100.0.19',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO SERENAZGO--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a SERENAZGO--<br/>";
        }

        $zk = new ZKTeco('192.77.77.204',4370);
        if($zk->connect()){
            $log = $log."LOG: -- CONECTANDO ESCALAFON--<br/>";
            $zk->disableDevice();  
            $attendances = $zk->getAttendance();
            $data = DB::table('attendances')->insertOrIgnore($attendances);
            $log = $log."LOG: Se insertaron: ".$data." registros.<br/>";
        }else{
            $log = $log."LOG: -- No se pudo conectar a ESCALAFON--<br/>";
        }*/

        return view('at')->with('log', $log);
    }

    public function events(){
        return view('reports.events');
    }

    public function getEvents(Request $request){

        $data = DB::select('SELECT e.dni, CONCAT(e.plastname," ",e.mlastname,", ",e.name) NAME, a.timestamp FROM attendances as a 
        inner join employees as e ON (CAST(e.dni AS UNSIGNED) = CAST(a.id AS UNSIGNED))');        

        return Datatables::of($data)->make(true);
    }

    public function today(){
        return view('reports.today');
    }

    public function month(){
        return view('reports.month');
    }

    public function getToday(Request $request)
    {
        $data = DB::select('SELECT 
                e.dni,
                CONCAT(e.plastname," ",e.mlastname,", ",e.name) NAME, 
                GROUP_CONCAT(TIME(a.TIMESTAMP) SEPARATOR ", ") marcas 
            FROM employees AS e
            LEFT JOIN attendances AS a ON (CAST(e.dni AS UNSIGNED) = CAST(a.id AS UNSIGNED) AND DATE(a.TIMESTAMP) = DATE(CURTIME()))
            GROUP BY e.dni, e.plastname, e.mlastname, e.name');

        return Datatables::of($data)->make(true);
    }

    public function noAttendance(){
        return view('reports.noAttendanceToday');
    }

    public function getNoAttendanceToday(Request $request)
    {
        $data = DB::select('SELECT 
                e.dni,
                e.regimen,
                CONCAT(e.plastname," ",e.mlastname,", ",e.name) NAME, 
                GROUP_CONCAT(TIME(a.TIMESTAMP) SEPARATOR ", ") marcas 
            FROM employees AS e
            LEFT JOIN attendances AS a ON (CAST(e.dni AS UNSIGNED) = CAST(a.id AS UNSIGNED) AND DATE(a.TIMESTAMP) = DATE(CURTIME()))
            GROUP BY e.dni, e.plastname, e.mlastname, e.name, e.regimen
            HAVING COUNT(a.timestamp) = 0');

        return Datatables::of($data)->make(true);
    }


    public function getMonth(Request $request)
    {
        $data = DB::select('SELECT 
            e.dni,
            DATE(a.timestamp) fecha,
            CONCAT(e.plastname," ",e.mlastname,", ",e.name) name,
            e.regimen, 
            IFNULL(GROUP_CONCAT(TIME(a.TIMESTAMP) SEPARATOR ", "), 0) marcas
        FROM employees AS e
        LEFT JOIN attendances AS a ON (CAST(e.dni AS UNSIGNED) = CAST(a.id AS UNSIGNED) AND MONTH(a.TIMESTAMP) = "02" AND YEAR(a.TIMESTAMP) = "2024")
                   
        GROUP BY e.dni, DATE(a.TIMESTAMP),e.plastname, e.mlastname, e.name, e.regimen');

        return Datatables::of($data)->make(true);
    }

    public function month2(Request $request){
        return view('reports.month2');
    }


    public function getMonth2(Request $request){

        $year = $request->anio;
        $month = $request->mes;

        //echo $year; exit;
        
        $data = DB::select('SELECT 
            e.dni,
            CONCAT(e.plastname," ",e.mlastname,", ",e.name) name,
            e.regimen,
            "'.$year.'" anio,
            "'.$month.'" mes,
            IFNULL(GROUP_CONCAT(a.TIMESTAMP SEPARATOR ","), "") marcas            
        FROM employees AS e
        LEFT JOIN attendances AS a 
            ON (
                CAST(e.dni AS UNSIGNED) = CAST(a.id AS UNSIGNED) 
                AND MONTH(a.TIMESTAMP) = "'.$month.'" 
                AND YEAR(a.TIMESTAMP) = "'.$year.'")            
        GROUP BY e.dni,e.plastname, e.mlastname, e.name, e.regimen');

        return Datatables::of($data)->make(true);
        
    }
}
