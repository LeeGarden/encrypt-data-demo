<?php

namespace App\Http\Controllers;

use App\Utils\CryptoLibCustom;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $cipher_method = 'BF-ECB';

    protected $arr_type = [
        'text',
        'mediumtext',
        'longtext'
    ];
    protected $arr_column_except = [
        'password',
        'remember_token'
    ];
    protected $arr_table_not_show = [
        'failed_jobs',
        'jobs',
        'migrations'
    ];

    const ARR_DELIMETER = [
        'tab'       => "\t",
        'semicolon' => ";",
        'pipe'      => "|",
        'comma'     => ","
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_table_not_show = $this->arr_table_not_show;
        $tables = DB::select('SHOW TABLES');
        $db_name = DB::getDatabaseName();

        $list_table = [];
        foreach ($tables as $table){
            $table = $table->{'Tables_in_'.$db_name};
            if(!in_array($table, $arr_table_not_show)){
                $list_table[] = $table;
            }
        }

        return view('home', compact('list_table'));
    }

    public function showColumnEncrypt($table_name)
    {
        $columns = DB::select('show columns from ' . $table_name);
        $arr_type = $this->arr_type;

        $arr_column_except = $this->arr_column_except;
        $list_column = [];
        foreach ($columns as $column){
            $type = preg_replace('(\(.*)', '', $column->Type);
            if(in_array($type, $arr_type) && !in_array($column->Field, $arr_column_except)){
                $list_column[] = $column->Field;
            }
        }

        return view('show-column-encrypt', compact('table_name', 'list_column'));
    }
    public function showColumnDecrypt($table_name)
    {
        $columns = DB::select('show columns from ' . $table_name);
        $arr_type = $this->arr_type;

        $arr_column_except = $this->arr_column_except;
        $list_column = [];
        foreach ($columns as $column){
            $type = preg_replace('(\(.*)', '', $column->Type);
            if(in_array($type, $arr_type) && !in_array($column->Field, $arr_column_except)){
                $list_column[] = $column->Field;
            }
        }

        return view('show-column-decrypt', compact('table_name', 'list_column'));
    }

    public function startEncrypt(Request $request)
    {
        $secret_key = config('custom.secret_key');

        $arr_column = $request->column;
        $table_name = $request->table_name;

        if(empty($arr_column)){
            return redirect()->back();
        }
        $select_arr = array_merge(['id'], $arr_column);

        $data = DB::table($table_name)->select($select_arr)->get()->toArray();
        foreach ($data as $record){
            $encrypted_data = [];
            foreach ($arr_column as $column){
                $encrypted_data[$column] = $this->encryptData($record->{$column}, $secret_key);
            }
            DB::table($table_name)->where('id', $record->id)->update($encrypted_data);
        }

        return redirect()->route('home');
    }

    public function startDecrypt(Request $request)
    {
        $secret_key = config('custom.secret_key');

        $arr_column = $request->column;
        $table_name = $request->table_name;

        if(empty($arr_column)){
            return redirect()->back();
        }
        $select_arr = array_merge(['id'], $arr_column);

        $data = DB::table($table_name)->select($select_arr)->get()->toArray();
        foreach ($data as $record){
            $decrypted_data = [];
            foreach ($arr_column as $column){
                $decrypted_data[$column] = $this->decryptData($record->{$column}, $secret_key);
            }
            DB::table($table_name)->where('id', $record->id)->update($decrypted_data);
        }

        return redirect()->route('home');
    }

    /*public function uploadCSV(Request $request)
    {
        if ($request->hasFile('csv-file')) {
            $file = $request->file('csv-file');

            $file_path = $file->getRealPath();
            $openFile = fopen($file_path, 'r');
            $delimiter = $this->detectDelimeter($openFile);
        }
    }

    public function detectDelimeter($open_csv)
    {
        $data_1 = null;
        $data_2 = null;
        $delimiter = self::ARR_DELIMETER['tab'];
        foreach(self::ARR_DELIMETER as $key=>$value)
        {
            $data_1 = fgetcsv($open_csv, 100000, $value);
            $delimiter = sizeof($data_1) > sizeof($data_2) ? $key : $delimiter;
            $data_2 = $data_1;
        }

        return $delimiter;
    }*/

    public function encryptData($raw_data, $secretyKey)
    {
        $encryption = new CryptoLibCustom();

        return $encryption->encryptPlainTextWithRandomIV($raw_data, $secretyKey);
    }

    public function decryptData($encypted_data, $secretyKey)
    {
        $encryption = new CryptoLibCustom();

        return $encryption->decryptCipherTextWithRandomIV($encypted_data, $secretyKey);
    }
}
