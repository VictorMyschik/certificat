<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MrAdminBackUpController extends Controller
{
  public function index()
  {

    $out = array();
    $out['page_title'] = 'Бэкап БД';

    $file_migrations_list = DB::table('migrations')->pluck('migration')->toArray();

    $tables = array();
    foreach ($file_migrations_list as $item)
    {
      $class_name = '';
      $table_name = substr($item, 25, strlen($item));

      foreach (explode('_', $table_name) as $item_2)
      {
        $class_name .= substr_replace($item_2, mb_strtoupper(substr($item_2, 0, 1)), 0, 1);
      }


      if(class_exists("App\\Http\\Models\\" . $class_name))
      {
        $object = "App\\Http\\Models\\" . $class_name;
        $tables[] = array(
          'Name' => $item,
          'count_rows' => $object::getCount(),
        );
      }

    }

    $out['list'] = $tables;

    return View('Admin.mir_admin_backup_list')->with($out);
  }


  public function SaveDataFromTable(string $table_name)
  {


    return back();
  }

  public function RecoveryDataToTable(string $table_name)
  {


    return back();
  }

  /*
    public static function Start()
    {
      self::MrSocialNetwork();

      return redirect('/admin/default');
    }

    public static function MrSocialNetwork()
    {
      $arr = array(
        [
          'Name' => 'WhatsApp',
          'Templates' => 'whatsapp://send?phone=',
          'Description' => '',
          'Link' => 'https://www.whatsapp.com/',
          'LinkPartner' => '',
          'Postfix' => '',
        ],

      );

      foreach ($arr as $value)
      {
        $network = MrCurrency::loadBy($value['Name'], 'Name') ?: new MrSocialNetwork();

      }
    }*/
}
