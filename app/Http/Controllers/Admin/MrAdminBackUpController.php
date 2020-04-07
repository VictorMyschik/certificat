<?php


namespace App\Http\Controllers\Admin;


use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\MrBackup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MrAdminBackUpController extends Controller
{
  public function index()
  {
    $out = array();
    $out['page_title'] = 'Бэкап БД';

    $file_migrations_list = DB::table('migrations')->pluck('migration')->toArray();
    $tables = array();
    foreach ($file_migrations_list as $key => $item)
    {
      $class_name = substr($item, 25, strlen($item));
      $class_name = substr($class_name, 0, strlen($class_name) - 6);
      $class_name_out = '';

      foreach (explode('_', $class_name) as $tmp_str)
      {
        $class_name_out .= ucfirst($tmp_str);
      }

      $object = null;

      if(class_exists("App\\Models\\" . $class_name_out))
      {
        $object = "App\\Models\\" . $class_name_out;
      }
      elseif(class_exists("App\\Models\\References\\" . $class_name_out))
      {
        $object = "App\\Models\\References\\" . $class_name_out;
      }

      if($object)
      {
        $tables[] = array(
          'Name' => $object::$mr_table,
          'FileName' => $item,
          'has' => isset(self::$tables[$object::$mr_table]),
          'count_rows' => $object::getCount(),
        );
      }

    }

    $out['list'] = $tables;

    return View('Admin.mir_admin_backup_list')->with($out);
  }

  /**
   * Страница просмотра записей в БД
   *
   * @param string $table_name
   * @return Factory|View
   */
  public function ViewTable(string $table_name)
  {
    $out = array();
    $out['page_title'] = 'Таблица ' . $table_name;
    $out['route_name'] = route('list_db_table_table', ['table_name' => $table_name]);

    return View('Admin.mir_admin_table_view')->with($out);
  }

  /**
   * Генератор построения таблиц
   * @param string $table_name
   * @return array
   */
  public function GetTable(string $table_name)
  {
    $arr = array(
      $table_name => 'MrDbMrFaqTableController',
    );

    if(isset($arr[$table_name]))
    {
      if(class_exists("App\\Http\\Controllers\\TableControllers\\Admin\\" . $arr[$table_name], true))
      {
        $object = "App\\Http\\Controllers\\TableControllers\\Admin\\" . $arr[$table_name];
        return $object::buildTable();
      }
    }

    return null;
  }

  public static function getTableNameFromFileName(string $item)
  {
    return substr($item, 25, strlen($item));
  }

  public function SaveDataFromTable(string $table_name)
  {


    return back();
  }

  /**
   * Запись в таблицу
   *
   * @param string $table_name
   * @return RedirectResponse
   */
  public function RecoveryDataToTable(string $table_name)
  {
    if(isset(self::$tables[$table_name]))
    {
      MrBackup::recovery(self::$tables[$table_name], $table_name);
    }
    else
    {
      MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Данных для восстановления в коде не найдены.');
    }

    return back();
  }

  public static $tables = array(
    'mr_currency' => array(
      array('ID' => '1', 'Code' => '784', 'TextCode' => 'AED', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Дирхам (ОАЭ)', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '2', 'Code' => '971', 'TextCode' => 'AFN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Афгани', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '3', 'Code' => '008', 'TextCode' => 'ALL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Лек', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '4', 'Code' => '051', 'TextCode' => 'AMD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Армянский драм', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '5', 'Code' => '532', 'TextCode' => 'ANG', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Нидерландский антильский гульден', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '6', 'Code' => '973', 'TextCode' => 'AOA', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кванза', 'Rounding' => '2', 'Description' => 'Ангольская '),
      array('ID' => '7', 'Code' => '032', 'TextCode' => 'ARS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Аргентинское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '8', 'Code' => '040', 'TextCode' => 'ATS', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Австрийский шиллинг', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '9', 'Code' => '036', 'TextCode' => 'AUD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Австралийский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '10', 'Code' => '533', 'TextCode' => 'AWG', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Арубанский флорин', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '11', 'Code' => '944', 'TextCode' => 'AZN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Азербайджанский манат', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '12', 'Code' => '977', 'TextCode' => 'BAM', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Конвертируемая марка ', 'Rounding' => '2', 'Description' => '(Босния и Герцеговина)'),
      array('ID' => '13', 'Code' => '052', 'TextCode' => 'BBD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => ' Барбадосский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '14', 'Code' => '050', 'TextCode' => 'BDT', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Така', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '15', 'Code' => '056', 'TextCode' => 'BEF', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Бельгийский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '16', 'Code' => '975', 'TextCode' => 'BGN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Болгарский лев', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '17', 'Code' => '048', 'TextCode' => 'BHD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бахрейнский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '18', 'Code' => '108', 'TextCode' => 'BIF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бурундийский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '19', 'Code' => '060', 'TextCode' => 'BMD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бермудский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '20', 'Code' => '096', 'TextCode' => 'BND', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Брунейский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '21', 'Code' => '068', 'TextCode' => 'BOB', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Боливиано', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '22', 'Code' => '986', 'TextCode' => 'BRL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бразильский реал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '23', 'Code' => '044', 'TextCode' => 'BSD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Багамский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '24', 'Code' => '064', 'TextCode' => 'BTN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Нгултрум', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '25', 'Code' => '072', 'TextCode' => 'BWP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Пула', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '26', 'Code' => '974', 'TextCode' => 'BYR', 'DateFrom' => NULL, 'DateTo' => '2016-06-30 00:00:00', 'Name' => 'Белорусский рубль <1>', 'Rounding' => '0', 'Description' => 'Применяется для денежных средств, уплаченных до 30 июня 2016 г. включительно.'),
      array('ID' => '27', 'Code' => '933', 'TextCode' => 'BYN', 'DateFrom' => '2016-07-01 00:00:00', 'DateTo' => NULL, 'Name' => 'Белорусский рубль', 'Rounding' => '2', 'Description' => 'новый, с 1.07.2016'),
      array('ID' => '28', 'Code' => '084', 'TextCode' => 'BZD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Белизский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '29', 'Code' => '124', 'TextCode' => 'CAD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Канадский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '30', 'Code' => '976', 'TextCode' => 'CDF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Конголезский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '31', 'Code' => '756', 'TextCode' => 'CHF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Швейцарский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '32', 'Code' => '152', 'TextCode' => 'CLP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Чилийское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '33', 'Code' => '156', 'TextCode' => 'CNY', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Юань', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '34', 'Code' => '170', 'TextCode' => 'COP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Колумбийское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '35', 'Code' => '970', 'TextCode' => 'COU', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Единица реальной стоимости ', 'Rounding' => '2', 'Description' => '(Колумбия)'),
      array('ID' => '36', 'Code' => '188', 'TextCode' => 'CRC', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Костариканский колон', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '37', 'Code' => '931', 'TextCode' => 'CUC', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Конвертируемое песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '38', 'Code' => '192', 'TextCode' => 'CUP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кубинское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '39', 'Code' => '132', 'TextCode' => 'CVE', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Эскудо  Кабо-Верде ', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '40', 'Code' => '203', 'TextCode' => 'CZK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Чешская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '41', 'Code' => '276', 'TextCode' => 'DEM', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Немецкая марка', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '42', 'Code' => '262', 'TextCode' => 'DJF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Франк Джибути', 'Rounding' => '2', 'Description' => ' '),
      array('ID' => '43', 'Code' => '208', 'TextCode' => 'DKK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Датская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '44', 'Code' => '214', 'TextCode' => 'DOP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доминиканское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '45', 'Code' => '012', 'TextCode' => 'DZD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Алжирский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '46', 'Code' => '233', 'TextCode' => 'EEK', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Эстонская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '47', 'Code' => '818', 'TextCode' => 'EGP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Египетский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '48', 'Code' => '232', 'TextCode' => 'ERN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Накфа ', 'Rounding' => '2', 'Description' => '(Эритрея)'),
      array('ID' => '49', 'Code' => '724', 'TextCode' => 'ESP', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Испанская песета', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '50', 'Code' => '230', 'TextCode' => 'ETB', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Эфиопский быр', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '51', 'Code' => '978', 'TextCode' => 'EUR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Евро', 'Rounding' => '2', 'Description' => '(Единая европейская валюта)'),
      array('ID' => '52', 'Code' => '246', 'TextCode' => 'FIM', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Финляндская марка', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '53', 'Code' => '242', 'TextCode' => 'FJD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар Фиджи', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '54', 'Code' => '238', 'TextCode' => 'FKP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Фунт Фолклендских островов', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '55', 'Code' => '250', 'TextCode' => 'FRF', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Французский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '56', 'Code' => '826', 'TextCode' => 'GBP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Фунт стерлингов ', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '57', 'Code' => '981', 'TextCode' => 'GEL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Лари', 'Rounding' => '2', 'Description' => 'Грузинский '),
      array('ID' => '58', 'Code' => '936', 'TextCode' => 'GHS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Ганский седи', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '59', 'Code' => '292', 'TextCode' => 'GIP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гибралтарский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '60', 'Code' => '270', 'TextCode' => 'GMD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Даласи', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '61', 'Code' => '324', 'TextCode' => 'GNF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гвинейский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '62', 'Code' => '300', 'TextCode' => 'GRD', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Греческая драхма', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '63', 'Code' => '320', 'TextCode' => 'GTQ', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кетсаль', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '64', 'Code' => '328', 'TextCode' => 'GYD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гайанский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '65', 'Code' => '344', 'TextCode' => 'HKD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гонконгский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '66', 'Code' => '340', 'TextCode' => 'HNL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Лемпира', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '67', 'Code' => '191', 'TextCode' => 'HRK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Куна', 'Rounding' => '2', 'Description' => ' (Хорватия)'),
      array('ID' => '68', 'Code' => '332', 'TextCode' => 'HTG', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гурд', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '69', 'Code' => '348', 'TextCode' => 'HUF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Форинт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '70', 'Code' => '360', 'TextCode' => 'IDR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '71', 'Code' => '372', 'TextCode' => 'IEP', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Ирландский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '72', 'Code' => '376', 'TextCode' => 'ILS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Новый израильский шекель', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '73', 'Code' => '356', 'TextCode' => 'INR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Индийская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '74', 'Code' => '368', 'TextCode' => 'IQD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Иракский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '75', 'Code' => '364', 'TextCode' => 'IRR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Иранский риал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '76', 'Code' => '352', 'TextCode' => 'ISK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Исландская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '77', 'Code' => '380', 'TextCode' => 'ITL', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Итальянская лира', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '78', 'Code' => '388', 'TextCode' => 'JMD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Ямайский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '79', 'Code' => '400', 'TextCode' => 'JOD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Иорданский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '80', 'Code' => '392', 'TextCode' => 'JPY', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Иена', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '81', 'Code' => '404', 'TextCode' => 'KES', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кенийский шиллинг', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '82', 'Code' => '417', 'TextCode' => 'KGS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сом', 'Rounding' => '2', 'Description' => '(Киргизский)'),
      array('ID' => '83', 'Code' => '116', 'TextCode' => 'KHR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Риель', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '84', 'Code' => '174', 'TextCode' => 'KMF', 'DateFrom' => NULL, 'DateTo' => '2017-10-12 00:00:00', 'Name' => 'Франк Комор', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '85', 'Code' => '408', 'TextCode' => 'KPW', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Северокорейская вона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '86', 'Code' => '410', 'TextCode' => 'KRW', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Вона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '87', 'Code' => '414', 'TextCode' => 'KWD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кувейтский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '88', 'Code' => '136', 'TextCode' => 'KYD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар островов Кайман', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '89', 'Code' => '398', 'TextCode' => 'KZT', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Тенге', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '90', 'Code' => '418', 'TextCode' => 'LAK', 'DateFrom' => NULL, 'DateTo' => '2017-10-12 00:00:00', 'Name' => 'Кип', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '91', 'Code' => '422', 'TextCode' => 'LBP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Ливанский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '92', 'Code' => '144', 'TextCode' => 'LKR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Шри-Ланкийская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '93', 'Code' => '430', 'TextCode' => 'LRD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Либерийский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '94', 'Code' => '426', 'TextCode' => 'LSL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Лоти ', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '95', 'Code' => '440', 'TextCode' => 'LTL', 'DateFrom' => NULL, 'DateTo' => '2018-06-23 00:00:00', 'Name' => 'Литовский лит <3>', 'Rounding' => '2', 'Description' => 'Не применяется с 1 января 2015 г.'),
      array('ID' => '96', 'Code' => '442', 'TextCode' => 'LUF', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Люксембургский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '97', 'Code' => '428', 'TextCode' => 'LVL', 'DateFrom' => NULL, 'DateTo' => '2014-01-14 00:00:00', 'Name' => 'Латвийский лат <2>', 'Rounding' => '2', 'Description' => 'Не применяется с 15 января 2014 г.'),
      array('ID' => '98', 'Code' => '434', 'TextCode' => 'LYD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Ливийский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '99', 'Code' => '504', 'TextCode' => 'MAD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Марокканский дирхам', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '100', 'Code' => '498', 'TextCode' => 'MDL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Молдавский лей', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '101', 'Code' => '969', 'TextCode' => 'MGA', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Малагасийский ариари', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '102', 'Code' => '807', 'TextCode' => 'MKD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Денар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '103', 'Code' => '104', 'TextCode' => 'MMK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кьят', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '104', 'Code' => '496', 'TextCode' => 'MNT', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Тугрик', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '105', 'Code' => '446', 'TextCode' => 'MOP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Патака', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '106', 'Code' => '478', 'TextCode' => 'MRO', 'DateFrom' => NULL, 'DateTo' => '2018-06-23 00:00:00', 'Name' => 'Угия <4>', 'Rounding' => '2', 'Description' => 'Мавританская Не применяется с 1 января 2018 г.'),
      array('ID' => '107', 'Code' => '480', 'TextCode' => 'MUR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Маврикийская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '108', 'Code' => '462', 'TextCode' => 'MVR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Руфия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '109', 'Code' => '454', 'TextCode' => 'MWK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Малавийская квача', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '110', 'Code' => '484', 'TextCode' => 'MXN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Мексиканское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '111', 'Code' => '458', 'TextCode' => 'MYR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Малайзийский ринггит', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '112', 'Code' => '943', 'TextCode' => 'MZN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Мозамбикский метикал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '113', 'Code' => '516', 'TextCode' => 'NAD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар Намибии', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '114', 'Code' => '566', 'TextCode' => 'NGN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Найра', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '115', 'Code' => '558', 'TextCode' => 'NIO', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Золотая кордоба', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '116', 'Code' => '528', 'TextCode' => 'NLG', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Нидерландский гульден', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '117', 'Code' => '578', 'TextCode' => 'NOK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Норвежская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '118', 'Code' => '524', 'TextCode' => 'NPR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Непальская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '119', 'Code' => '554', 'TextCode' => 'NZD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Новозеландский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '120', 'Code' => '512', 'TextCode' => 'OMR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Оманский риал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '121', 'Code' => '590', 'TextCode' => 'PAB', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бальбоа', 'Rounding' => '2', 'Description' => 'Панамский '),
      array('ID' => '122', 'Code' => '604', 'TextCode' => 'PEN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Соль', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '123', 'Code' => '598', 'TextCode' => 'PGK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Кина', 'Rounding' => '2', 'Description' => ' Папуа-Новой Гвинеи'),
      array('ID' => '124', 'Code' => '608', 'TextCode' => 'PHP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Филиппинское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '125', 'Code' => '586', 'TextCode' => 'PKR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Пакистанская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '126', 'Code' => '985', 'TextCode' => 'PLN', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Злотый', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '127', 'Code' => '620', 'TextCode' => 'PTE', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Португальский эскудо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '128', 'Code' => '600', 'TextCode' => 'PYG', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гуарани', 'Rounding' => '2', 'Description' => 'Парагвайский '),
      array('ID' => '129', 'Code' => '634', 'TextCode' => 'QAR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Катарский риал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '130', 'Code' => '946', 'TextCode' => 'RON', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Румынский Лей ', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '131', 'Code' => '941', 'TextCode' => 'RSD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сербский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '132', 'Code' => '643', 'TextCode' => 'RUB', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Российский рубль', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '133', 'Code' => '646', 'TextCode' => 'RWF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Франк Руанды', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '134', 'Code' => '682', 'TextCode' => 'SAR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Саудовский риял', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '135', 'Code' => '090', 'TextCode' => 'SBD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар Соломоновых островов', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '136', 'Code' => '690', 'TextCode' => 'SCR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сейшельская рупия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '137', 'Code' => '938', 'TextCode' => 'SDG', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Суданский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '138', 'Code' => '752', 'TextCode' => 'SEK', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Шведская крона', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '139', 'Code' => '702', 'TextCode' => 'SGD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сингапурский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '140', 'Code' => '654', 'TextCode' => 'SHP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Фунт Святой Елены ', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '141', 'Code' => '705', 'TextCode' => 'SIT', 'DateFrom' => NULL, 'DateTo' => '2016-12-31 00:00:00', 'Name' => 'Толар (Словения)', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '142', 'Code' => '694', 'TextCode' => 'SLL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => ' Леоне', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '143', 'Code' => '706', 'TextCode' => 'SOS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сомалийский шиллинг', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '144', 'Code' => '968', 'TextCode' => 'SRD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Суринамский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '145', 'Code' => '678', 'TextCode' => 'STD', 'DateFrom' => NULL, 'DateTo' => '2018-06-23 00:00:00', 'Name' => 'Добра <4>', 'Rounding' => '2', 'Description' => '<4> Не применяется с 1 января 2018 г.'),
      array('ID' => '146', 'Code' => '222', 'TextCode' => 'SVC', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сальвадорский колон', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '147', 'Code' => '760', 'TextCode' => 'SYP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сирийский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '148', 'Code' => '748', 'TextCode' => 'SZL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Лилангени', 'Rounding' => '2', 'Description' => 'Свазилендский'),
      array('ID' => '149', 'Code' => '764', 'TextCode' => 'THB', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Бат', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '150', 'Code' => '972', 'TextCode' => 'TJS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Сомони', 'Rounding' => '2', 'Description' => 'Таджикский '),
      array('ID' => '151', 'Code' => '934', 'TextCode' => 'TMT', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Новый туркменский манат', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '152', 'Code' => '788', 'TextCode' => 'TND', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Тунисский динар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '153', 'Code' => '776', 'TextCode' => 'TOP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Паанга', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '154', 'Code' => '949', 'TextCode' => 'TRY', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Турецкая лира', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '155', 'Code' => '780', 'TextCode' => 'TTD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар Тринидада и Тобаго', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '156', 'Code' => '901', 'TextCode' => 'TWD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Новый Тайваньский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '157', 'Code' => '834', 'TextCode' => 'TZS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Танзанийский шиллинг', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '158', 'Code' => '980', 'TextCode' => 'UAH', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Гривна', 'Rounding' => '2', 'Description' => 'Украинская '),
      array('ID' => '159', 'Code' => '800', 'TextCode' => 'UGX', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Угандийский шиллинг', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '160', 'Code' => '840', 'TextCode' => 'USD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар США', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '161', 'Code' => '940', 'TextCode' => 'UYI', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Уругвайское песо в индексированных единицах', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '162', 'Code' => '858', 'TextCode' => 'UYU', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Уругвайское песо', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '163', 'Code' => '860', 'TextCode' => 'UZS', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Узбекский Сум', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '164', 'Code' => '937', 'TextCode' => 'VEF', 'DateFrom' => NULL, 'DateTo' => '2019-06-15 00:00:00', 'Name' => 'Боливар <5>', 'Rounding' => '2', 'Description' => '<5> Не применяется с 20 августа 2018 г.'),
      array('ID' => '165', 'Code' => '704', 'TextCode' => 'VND', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Донг', 'Rounding' => '2', 'Description' => 'Ветнамский '),
      array('ID' => '166', 'Code' => '548', 'TextCode' => 'VUV', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Вату', 'Rounding' => '2', 'Description' => 'Республики  Вануату '),
      array('ID' => '167', 'Code' => '882', 'TextCode' => 'WST', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Тала', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '168', 'Code' => '950', 'TextCode' => 'XAF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Франк КФА ВЕАС  <6>', 'Rounding' => '2', 'Description' => '<6>- денежная единица Банка государств Центральной Африки'),
      array('ID' => '169', 'Code' => '951', 'TextCode' => 'XCD', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Восточно-карибский доллар', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '170', 'Code' => '960', 'TextCode' => 'XDR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'СДР (Специальные права заимствования)', 'Rounding' => '2', 'Description' => ' Международный валютный фонд'),
      array('ID' => '171', 'Code' => '952', 'TextCode' => 'XOF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Франк КФА BCEAO <7>', 'Rounding' => '2', 'Description' => '<7> - денежная единица Центрального Банка государств Западной Африки.'),
      array('ID' => '172', 'Code' => '953', 'TextCode' => 'XPF', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => ' Франк КФП', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '173', 'Code' => '886', 'TextCode' => 'YER', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Йеменский риал', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '174', 'Code' => '710', 'TextCode' => 'ZAR', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Рэнд', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '175', 'Code' => '967', 'TextCode' => 'ZMW', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Замбийская квача', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '176', 'Code' => '932', 'TextCode' => 'ZWL', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Доллар Зимбабве', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '177', 'Code' => '728', 'TextCode' => 'SSP', 'DateFrom' => NULL, 'DateTo' => NULL, 'Name' => 'Южносуданский фунт', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '178', 'Code' => '174', 'TextCode' => 'KMF', 'DateFrom' => '2017-10-13 00:00:00', 'DateTo' => NULL, 'Name' => 'Коморский франк', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '179', 'Code' => '418', 'TextCode' => 'LAK', 'DateFrom' => '2017-10-13 00:00:00', 'DateTo' => NULL, 'Name' => 'Лаосский кип', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '180', 'Code' => '929', 'TextCode' => 'MRU', 'DateFrom' => '2018-06-24 00:00:00', 'DateTo' => NULL, 'Name' => 'Угия', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '181', 'Code' => '930', 'TextCode' => 'STN', 'DateFrom' => '2018-06-24 00:00:00', 'DateTo' => NULL, 'Name' => 'Добра', 'Rounding' => '2', 'Description' => ''),
      array('ID' => '182', 'Code' => '928', 'TextCode' => 'VES', 'DateFrom' => '2019-06-16 00:00:00', 'DateTo' => NULL, 'Name' => 'Боливар Соберано', 'Rounding' => '2', 'Description' => NULL)
    ),
    'mr_country' => array(
      array('id' => '1', 'Name' => 'Andorra', 'ISO3166alpha2' => 'AD', 'ISO3166alpha3' => 'AND', 'ISO3166numeric' => '20', 'Capital' => 'Andorra la Vella', 'Continent' => '3'),
      array('id' => '2', 'Name' => 'United Arab Emirates', 'ISO3166alpha2' => 'AE', 'ISO3166alpha3' => 'ARE', 'ISO3166numeric' => '784', 'Capital' => 'Abu Dhabi', 'Continent' => '2'),
      array('id' => '3', 'Name' => 'Afghanistan', 'ISO3166alpha2' => 'AF', 'ISO3166alpha3' => 'AFG', 'ISO3166numeric' => '4', 'Capital' => 'Kabul', 'Continent' => '2'),
      array('id' => '4', 'Name' => 'Antigua and Barbuda', 'ISO3166alpha2' => 'AG', 'ISO3166alpha3' => 'ATG', 'ISO3166numeric' => '28', 'Capital' => 'St. John`s', 'Continent' => '4'),
      array('id' => '5', 'Name' => 'Anguilla', 'ISO3166alpha2' => 'AI', 'ISO3166alpha3' => 'AIA', 'ISO3166numeric' => '660', 'Capital' => 'The Valley', 'Continent' => '4'),
      array('id' => '6', 'Name' => 'Albania', 'ISO3166alpha2' => 'AL', 'ISO3166alpha3' => 'ALB', 'ISO3166numeric' => '8', 'Capital' => 'Tirana', 'Continent' => '3'),
      array('id' => '7', 'Name' => 'Armenia', 'ISO3166alpha2' => 'AM', 'ISO3166alpha3' => 'ARM', 'ISO3166numeric' => '51', 'Capital' => 'Yerevan', 'Continent' => '2'),
      array('id' => '8', 'Name' => 'Netherlands Antilles', 'ISO3166alpha2' => 'AN', 'ISO3166alpha3' => 'ANT', 'ISO3166numeric' => '530', 'Capital' => 'Willemstad', 'Continent' => '4'),
      array('id' => '9', 'Name' => 'Angola', 'ISO3166alpha2' => 'AO', 'ISO3166alpha3' => 'AGO', 'ISO3166numeric' => '24', 'Capital' => 'Luanda', 'Continent' => '1'),
      array('id' => '10', 'Name' => 'Antarctica', 'ISO3166alpha2' => 'AQ', 'ISO3166alpha3' => 'ATA', 'ISO3166numeric' => '10', 'Capital' => 'Antarctica', 'Continent' => '7'),
      array('id' => '11', 'Name' => 'Argentina', 'ISO3166alpha2' => 'AR', 'ISO3166alpha3' => 'ARG', 'ISO3166numeric' => '32', 'Capital' => 'Buenos Aires', 'Continent' => '6'),
      array('id' => '12', 'Name' => 'American Samoa', 'ISO3166alpha2' => 'AS', 'ISO3166alpha3' => 'ASM', 'ISO3166numeric' => '16', 'Capital' => 'Pago Pago', 'Continent' => '5'),
      array('id' => '13', 'Name' => 'Austria', 'ISO3166alpha2' => 'AT', 'ISO3166alpha3' => 'AUT', 'ISO3166numeric' => '40', 'Capital' => 'Vienna', 'Continent' => '3'),
      array('id' => '14', 'Name' => 'Australia', 'ISO3166alpha2' => 'AU', 'ISO3166alpha3' => 'AUS', 'ISO3166numeric' => '36', 'Capital' => 'Canberra', 'Continent' => '5'),
      array('id' => '15', 'Name' => 'Aruba', 'ISO3166alpha2' => 'AW', 'ISO3166alpha3' => 'ABW', 'ISO3166numeric' => '533', 'Capital' => 'Oranjestad', 'Continent' => '4'),
      array('id' => '16', 'Name' => 'Azerbaijan', 'ISO3166alpha2' => 'AZ', 'ISO3166alpha3' => 'AZE', 'ISO3166numeric' => '31', 'Capital' => 'Baku', 'Continent' => '2'),
      array('id' => '17', 'Name' => 'Bosnia and Herzegovina', 'ISO3166alpha2' => 'BA', 'ISO3166alpha3' => 'BIH', 'ISO3166numeric' => '70', 'Capital' => 'Sarajevo', 'Continent' => '3'),
      array('id' => '18', 'Name' => 'Barbados', 'ISO3166alpha2' => 'BB', 'ISO3166alpha3' => 'BRB', 'ISO3166numeric' => '52', 'Capital' => 'Bridgetown', 'Continent' => '4'),
      array('id' => '19', 'Name' => 'Bangladesh', 'ISO3166alpha2' => 'BD', 'ISO3166alpha3' => 'BGD', 'ISO3166numeric' => '50', 'Capital' => 'Dhaka', 'Continent' => '2'),
      array('id' => '20', 'Name' => 'Belgium', 'ISO3166alpha2' => 'BE', 'ISO3166alpha3' => 'BEL', 'ISO3166numeric' => '56', 'Capital' => 'Brussels', 'Continent' => '3'),
      array('id' => '21', 'Name' => 'Burkina Faso', 'ISO3166alpha2' => 'BF', 'ISO3166alpha3' => 'BFA', 'ISO3166numeric' => '854', 'Capital' => 'Ouagadougou', 'Continent' => '1'),
      array('id' => '22', 'Name' => 'Bulgaria', 'ISO3166alpha2' => 'BG', 'ISO3166alpha3' => 'BGR', 'ISO3166numeric' => '100', 'Capital' => 'Sofia', 'Continent' => '3'),
      array('id' => '23', 'Name' => 'Bahrain', 'ISO3166alpha2' => 'BH', 'ISO3166alpha3' => 'BHR', 'ISO3166numeric' => '48', 'Capital' => 'Manama', 'Continent' => '2'),
      array('id' => '24', 'Name' => 'Burundi', 'ISO3166alpha2' => 'BI', 'ISO3166alpha3' => 'BDI', 'ISO3166numeric' => '108', 'Capital' => 'Gitega', 'Continent' => '1'),
      array('id' => '25', 'Name' => 'Benin', 'ISO3166alpha2' => 'BJ', 'ISO3166alpha3' => 'BEN', 'ISO3166numeric' => '204', 'Capital' => 'Porto-Novo', 'Continent' => '1'),
      array('id' => '26', 'Name' => 'Saint Barth?lemy', 'ISO3166alpha2' => 'BL', 'ISO3166alpha3' => 'BLM', 'ISO3166numeric' => '652', 'Capital' => 'Gustavia', 'Continent' => '4'),
      array('id' => '27', 'Name' => 'Bermuda', 'ISO3166alpha2' => 'BM', 'ISO3166alpha3' => 'BMU', 'ISO3166numeric' => '60', 'Capital' => 'Hamilton', 'Continent' => '4'),
      array('id' => '28', 'Name' => 'Brunei', 'ISO3166alpha2' => 'BN', 'ISO3166alpha3' => 'BRN', 'ISO3166numeric' => '96', 'Capital' => 'Bandar Seri Begawan', 'Continent' => '2'),
      array('id' => '29', 'Name' => 'Bolivia', 'ISO3166alpha2' => 'BO', 'ISO3166alpha3' => 'BOL', 'ISO3166numeric' => '68', 'Capital' => 'Sucre', 'Continent' => '6'),
      array('id' => '30', 'Name' => 'Brazil', 'ISO3166alpha2' => 'BR', 'ISO3166alpha3' => 'BRA', 'ISO3166numeric' => '76', 'Capital' => 'Brasilia', 'Continent' => '6'),
      array('id' => '31', 'Name' => 'Bahamas', 'ISO3166alpha2' => 'BS', 'ISO3166alpha3' => 'BHS', 'ISO3166numeric' => '44', 'Capital' => 'Nassau', 'Continent' => '4'),
      array('id' => '32', 'Name' => 'Bhutan', 'ISO3166alpha2' => 'BT', 'ISO3166alpha3' => 'BTN', 'ISO3166numeric' => '64', 'Capital' => 'Thimphu', 'Continent' => '2'),
      array('id' => '33', 'Name' => 'Bouvet Island', 'ISO3166alpha2' => 'BV', 'ISO3166alpha3' => 'BVT', 'ISO3166numeric' => '74', 'Capital' => 'Bouvet Island', 'Continent' => '7'),
      array('id' => '34', 'Name' => 'Botswana', 'ISO3166alpha2' => 'BW', 'ISO3166alpha3' => 'BWA', 'ISO3166numeric' => '72', 'Capital' => 'Gaborone', 'Continent' => '1'),
      array('id' => '35', 'Name' => 'Belarus', 'ISO3166alpha2' => 'BY', 'ISO3166alpha3' => 'BLR', 'ISO3166numeric' => '112', 'Capital' => 'Minsk', 'Continent' => '3'),
      array('id' => '36', 'Name' => 'Belize', 'ISO3166alpha2' => 'BZ', 'ISO3166alpha3' => 'BLZ', 'ISO3166numeric' => '84', 'Capital' => 'Belmopan', 'Continent' => '4'),
      array('id' => '37', 'Name' => 'Canada', 'ISO3166alpha2' => 'CA', 'ISO3166alpha3' => 'CAN', 'ISO3166numeric' => '124', 'Capital' => 'Ottawa', 'Continent' => '4'),
      array('id' => '38', 'Name' => 'Cocos [Keeling] Islands', 'ISO3166alpha2' => 'CC', 'ISO3166alpha3' => 'CCK', 'ISO3166numeric' => '166', 'Capital' => 'West Island', 'Continent' => '2'),
      array('id' => '39', 'Name' => 'DR Congo', 'ISO3166alpha2' => 'CD', 'ISO3166alpha3' => 'COD', 'ISO3166numeric' => '180', 'Capital' => 'Kinshasa', 'Continent' => '1'),
      array('id' => '40', 'Name' => 'Central African Republic', 'ISO3166alpha2' => 'CF', 'ISO3166alpha3' => 'CAF', 'ISO3166numeric' => '140', 'Capital' => 'Bangui', 'Continent' => '1'),
      array('id' => '41', 'Name' => 'Congo Republic', 'ISO3166alpha2' => 'CG', 'ISO3166alpha3' => 'COG', 'ISO3166numeric' => '178', 'Capital' => 'Brazzaville', 'Continent' => '1'),
      array('id' => '42', 'Name' => 'Switzerland', 'ISO3166alpha2' => 'CH', 'ISO3166alpha3' => 'CHE', 'ISO3166numeric' => '756', 'Capital' => 'Bern', 'Continent' => '3'),
      array('id' => '43', 'Name' => 'Ivory Coast', 'ISO3166alpha2' => 'CI', 'ISO3166alpha3' => 'CIV', 'ISO3166numeric' => '384', 'Capital' => 'Yamoussoukro', 'Continent' => '1'),
      array('id' => '44', 'Name' => 'China', 'ISO3166alpha2' => 'CN', 'ISO3166alpha3' => 'CHN', 'ISO3166numeric' => '156', 'Capital' => 'Beijing', 'Continent' => '2'),
      array('id' => '45', 'Name' => 'Colombia', 'ISO3166alpha2' => 'CO', 'ISO3166alpha3' => 'COL', 'ISO3166numeric' => '170', 'Capital' => 'Bogota', 'Continent' => '6'),
      array('id' => '46', 'Name' => 'Costa Rica', 'ISO3166alpha2' => 'CR', 'ISO3166alpha3' => 'CRI', 'ISO3166numeric' => '188', 'Capital' => 'San Jose', 'Continent' => '4'),
      array('id' => '47', 'Name' => 'Serbia and Montenegro', 'ISO3166alpha2' => 'CS', 'ISO3166alpha3' => 'SCG', 'ISO3166numeric' => '891', 'Capital' => 'Belgrade', 'Continent' => '3'),
      array('id' => '48', 'Name' => 'Cuba', 'ISO3166alpha2' => 'CU', 'ISO3166alpha3' => 'CUB', 'ISO3166numeric' => '192', 'Capital' => 'Havana', 'Continent' => '4'),
      array('id' => '49', 'Name' => 'Cabo Verde', 'ISO3166alpha2' => 'CV', 'ISO3166alpha3' => 'CPV', 'ISO3166numeric' => '132', 'Capital' => 'Praia', 'Continent' => '1'),
      array('id' => '50', 'Name' => 'Cura?ao', 'ISO3166alpha2' => 'CW', 'ISO3166alpha3' => 'CUW', 'ISO3166numeric' => '531', 'Capital' => 'Willemstad', 'Continent' => '4'),
      array('id' => '51', 'Name' => 'Christmas Island', 'ISO3166alpha2' => 'CX', 'ISO3166alpha3' => 'CXR', 'ISO3166numeric' => '162', 'Capital' => 'Flying Fish Cove', 'Continent' => '5'),
      array('id' => '52', 'Name' => 'Cyprus', 'ISO3166alpha2' => 'CY', 'ISO3166alpha3' => 'CYP', 'ISO3166numeric' => '196', 'Capital' => 'Nicosia', 'Continent' => '3'),
      array('id' => '53', 'Name' => 'Czechia', 'ISO3166alpha2' => 'CZ', 'ISO3166alpha3' => 'CZE', 'ISO3166numeric' => '203', 'Capital' => 'Prague', 'Continent' => '3'),
      array('id' => '54', 'Name' => 'Germany', 'ISO3166alpha2' => 'DE', 'ISO3166alpha3' => 'DEU', 'ISO3166numeric' => '276', 'Capital' => 'Berlin', 'Continent' => '3'),
      array('id' => '55', 'Name' => 'Djibouti', 'ISO3166alpha2' => 'DJ', 'ISO3166alpha3' => 'DJI', 'ISO3166numeric' => '262', 'Capital' => 'Djibouti', 'Continent' => '1'),
      array('id' => '56', 'Name' => 'Denmark', 'ISO3166alpha2' => 'DK', 'ISO3166alpha3' => 'DNK', 'ISO3166numeric' => '208', 'Capital' => 'Copenhagen', 'Continent' => '3'),
      array('id' => '57', 'Name' => 'Dominica', 'ISO3166alpha2' => 'DM', 'ISO3166alpha3' => 'DMA', 'ISO3166numeric' => '212', 'Capital' => 'Roseau', 'Continent' => '4'),
      array('id' => '58', 'Name' => 'Dominican Republic', 'ISO3166alpha2' => 'DO', 'ISO3166alpha3' => 'DOM', 'ISO3166numeric' => '214', 'Capital' => 'Santo Domingo', 'Continent' => '4'),
      array('id' => '59', 'Name' => 'Algeria', 'ISO3166alpha2' => 'DZ', 'ISO3166alpha3' => 'DZA', 'ISO3166numeric' => '12', 'Capital' => 'Algiers', 'Continent' => '1'),
      array('id' => '60', 'Name' => 'Ecuador', 'ISO3166alpha2' => 'EC', 'ISO3166alpha3' => 'ECU', 'ISO3166numeric' => '218', 'Capital' => 'Quito', 'Continent' => '6'),
      array('id' => '61', 'Name' => 'Estonia', 'ISO3166alpha2' => 'EE', 'ISO3166alpha3' => 'EST', 'ISO3166numeric' => '233', 'Capital' => 'Tallinn', 'Continent' => '3'),
      array('id' => '62', 'Name' => 'Egypt', 'ISO3166alpha2' => 'EG', 'ISO3166alpha3' => 'EGY', 'ISO3166numeric' => '818', 'Capital' => 'Cairo', 'Continent' => '1'),
      array('id' => '63', 'Name' => 'Western Sahara', 'ISO3166alpha2' => 'EH', 'ISO3166alpha3' => 'ESH', 'ISO3166numeric' => '732', 'Capital' => 'El-Aaiun', 'Continent' => '1'),
      array('id' => '64', 'Name' => 'Eritrea', 'ISO3166alpha2' => 'ER', 'ISO3166alpha3' => 'ERI', 'ISO3166numeric' => '232', 'Capital' => 'Asmara', 'Continent' => '1'),
      array('id' => '65', 'Name' => 'Spain', 'ISO3166alpha2' => 'ES', 'ISO3166alpha3' => 'ESP', 'ISO3166numeric' => '724', 'Capital' => 'Madrid', 'Continent' => '3'),
      array('id' => '66', 'Name' => 'Ethiopia', 'ISO3166alpha2' => 'ET', 'ISO3166alpha3' => 'ETH', 'ISO3166numeric' => '231', 'Capital' => 'Addis Ababa', 'Continent' => '1'),
      array('id' => '67', 'Name' => 'Finland', 'ISO3166alpha2' => 'FI', 'ISO3166alpha3' => 'FIN', 'ISO3166numeric' => '246', 'Capital' => 'Helsinki', 'Continent' => '3'),
      array('id' => '68', 'Name' => 'Fiji', 'ISO3166alpha2' => 'FJ', 'ISO3166alpha3' => 'FJI', 'ISO3166numeric' => '242', 'Capital' => 'Suva', 'Continent' => '5'),
      array('id' => '69', 'Name' => 'Falkland Islands', 'ISO3166alpha2' => 'FK', 'ISO3166alpha3' => 'FLK', 'ISO3166numeric' => '238', 'Capital' => 'Stanley', 'Continent' => '6'),
      array('id' => '70', 'Name' => 'Micronesia', 'ISO3166alpha2' => 'FM', 'ISO3166alpha3' => 'FSM', 'ISO3166numeric' => '583', 'Capital' => 'Palikir', 'Continent' => '5'),
      array('id' => '71', 'Name' => 'Faroe Islands', 'ISO3166alpha2' => 'FO', 'ISO3166alpha3' => 'FRO', 'ISO3166numeric' => '234', 'Capital' => 'Torshavn', 'Continent' => '3'),
      array('id' => '72', 'Name' => 'France', 'ISO3166alpha2' => 'FR', 'ISO3166alpha3' => 'FRA', 'ISO3166numeric' => '250', 'Capital' => 'Paris', 'Continent' => '3'),
      array('id' => '73', 'Name' => 'Gabon', 'ISO3166alpha2' => 'GA', 'ISO3166alpha3' => 'GAB', 'ISO3166numeric' => '266', 'Capital' => 'Libreville', 'Continent' => '1'),
      array('id' => '74', 'Name' => 'United Kingdom', 'ISO3166alpha2' => 'GB', 'ISO3166alpha3' => 'GBR', 'ISO3166numeric' => '826', 'Capital' => 'London', 'Continent' => '3'),
      array('id' => '75', 'Name' => 'Grenada', 'ISO3166alpha2' => 'GD', 'ISO3166alpha3' => 'GRD', 'ISO3166numeric' => '308', 'Capital' => 'St. George`s', 'Continent' => '4'),
      array('id' => '76', 'Name' => 'Georgia', 'ISO3166alpha2' => 'GE', 'ISO3166alpha3' => 'GEO', 'ISO3166numeric' => '268', 'Capital' => 'Tbilisi', 'Continent' => '2'),
      array('id' => '77', 'Name' => 'French Guiana', 'ISO3166alpha2' => 'GF', 'ISO3166alpha3' => 'GUF', 'ISO3166numeric' => '254', 'Capital' => 'Cayenne', 'Continent' => '6'),
      array('id' => '78', 'Name' => 'Guernsey', 'ISO3166alpha2' => 'GG', 'ISO3166alpha3' => 'GGY', 'ISO3166numeric' => '831', 'Capital' => 'St Peter Port', 'Continent' => '3'),
      array('id' => '79', 'Name' => 'Ghana', 'ISO3166alpha2' => 'GH', 'ISO3166alpha3' => 'GHA', 'ISO3166numeric' => '288', 'Capital' => 'Accra', 'Continent' => '1'),
      array('id' => '80', 'Name' => 'Gibraltar', 'ISO3166alpha2' => 'GI', 'ISO3166alpha3' => 'GIB', 'ISO3166numeric' => '292', 'Capital' => 'Gibraltar', 'Continent' => '3'),
      array('id' => '81', 'Name' => 'Greenland', 'ISO3166alpha2' => 'GL', 'ISO3166alpha3' => 'GRL', 'ISO3166numeric' => '304', 'Capital' => 'Nuuk', 'Continent' => '4'),
      array('id' => '82', 'Name' => 'Gambia', 'ISO3166alpha2' => 'GM', 'ISO3166alpha3' => 'GMB', 'ISO3166numeric' => '270', 'Capital' => 'Banjul', 'Continent' => '1'),
      array('id' => '83', 'Name' => 'Guinea', 'ISO3166alpha2' => 'GN', 'ISO3166alpha3' => 'GIN', 'ISO3166numeric' => '324', 'Capital' => 'Conakry', 'Continent' => '1'),
      array('id' => '84', 'Name' => 'Guadeloupe', 'ISO3166alpha2' => 'GP', 'ISO3166alpha3' => 'GLP', 'ISO3166numeric' => '312', 'Capital' => 'Basse-Terre', 'Continent' => '4'),
      array('id' => '85', 'Name' => 'Equatorial Guinea', 'ISO3166alpha2' => 'GQ', 'ISO3166alpha3' => 'GNQ', 'ISO3166numeric' => '226', 'Capital' => 'Malabo', 'Continent' => '1'),
      array('id' => '86', 'Name' => 'Greece', 'ISO3166alpha2' => 'GR', 'ISO3166alpha3' => 'GRC', 'ISO3166numeric' => '300', 'Capital' => 'Athens', 'Continent' => '3'),
      array('id' => '87', 'Name' => 'South Georgia and South Sandwich Islands', 'ISO3166alpha2' => 'GS', 'ISO3166alpha3' => 'SGS', 'ISO3166numeric' => '239', 'Capital' => 'Grytviken', 'Continent' => '7'),
      array('id' => '88', 'Name' => 'Guatemala', 'ISO3166alpha2' => 'GT', 'ISO3166alpha3' => 'GTM', 'ISO3166numeric' => '320', 'Capital' => 'Guatemala City', 'Continent' => '4'),
      array('id' => '89', 'Name' => 'Guam', 'ISO3166alpha2' => 'GU', 'ISO3166alpha3' => 'GUM', 'ISO3166numeric' => '316', 'Capital' => 'Hagatna', 'Continent' => '5'),
      array('id' => '90', 'Name' => 'Guinea-Bissau', 'ISO3166alpha2' => 'GW', 'ISO3166alpha3' => 'GNB', 'ISO3166numeric' => '624', 'Capital' => 'Bissau', 'Continent' => '1'),
      array('id' => '91', 'Name' => 'Guyana', 'ISO3166alpha2' => 'GY', 'ISO3166alpha3' => 'GUY', 'ISO3166numeric' => '328', 'Capital' => 'Georgetown', 'Continent' => '6'),
      array('id' => '92', 'Name' => 'Hong Kong', 'ISO3166alpha2' => 'HK', 'ISO3166alpha3' => 'HKG', 'ISO3166numeric' => '344', 'Capital' => 'Hong Kong', 'Continent' => '2'),
      array('id' => '93', 'Name' => 'Heard Island and McDonald Islands', 'ISO3166alpha2' => 'HM', 'ISO3166alpha3' => 'HMD', 'ISO3166numeric' => '334', 'Capital' => 'Heard Island and McDonald Islands', 'Continent' => '7'),
      array('id' => '94', 'Name' => 'Honduras', 'ISO3166alpha2' => 'HN', 'ISO3166alpha3' => 'HND', 'ISO3166numeric' => '340', 'Capital' => 'Tegucigalpa', 'Continent' => '4'),
      array('id' => '95', 'Name' => 'Croatia', 'ISO3166alpha2' => 'HR', 'ISO3166alpha3' => 'HRV', 'ISO3166numeric' => '191', 'Capital' => 'Zagreb', 'Continent' => '3'),
      array('id' => '96', 'Name' => 'Haiti', 'ISO3166alpha2' => 'HT', 'ISO3166alpha3' => 'HTI', 'ISO3166numeric' => '332', 'Capital' => 'Port-au-Prince', 'Continent' => '4'),
      array('id' => '97', 'Name' => 'Hungary', 'ISO3166alpha2' => 'HU', 'ISO3166alpha3' => 'HUN', 'ISO3166numeric' => '348', 'Capital' => 'Budapest', 'Continent' => '3'),
      array('id' => '98', 'Name' => 'Indonesia', 'ISO3166alpha2' => 'ID', 'ISO3166alpha3' => 'IDN', 'ISO3166numeric' => '360', 'Capital' => 'Jakarta', 'Continent' => '2'),
      array('id' => '99', 'Name' => 'Ireland', 'ISO3166alpha2' => 'IE', 'ISO3166alpha3' => 'IRL', 'ISO3166numeric' => '372', 'Capital' => 'Dublin', 'Continent' => '3'),
      array('id' => '100', 'Name' => 'Israel', 'ISO3166alpha2' => 'IL', 'ISO3166alpha3' => 'ISR', 'ISO3166numeric' => '376', 'Capital' => 'Jerusalem', 'Continent' => '2'),
      array('id' => '101', 'Name' => 'Isle of Man', 'ISO3166alpha2' => 'IM', 'ISO3166alpha3' => 'IMN', 'ISO3166numeric' => '833', 'Capital' => 'Douglas', 'Continent' => '3'),
      array('id' => '102', 'Name' => 'India', 'ISO3166alpha2' => 'IN', 'ISO3166alpha3' => 'IND', 'ISO3166numeric' => '356', 'Capital' => 'New Delhi', 'Continent' => '2'),
      array('id' => '103', 'Name' => 'British Indian Ocean Territory', 'ISO3166alpha2' => 'IO', 'ISO3166alpha3' => 'IOT', 'ISO3166numeric' => '86', 'Capital' => 'Diego Garcia', 'Continent' => '2'),
      array('id' => '104', 'Name' => 'Iraq', 'ISO3166alpha2' => 'IQ', 'ISO3166alpha3' => 'IRQ', 'ISO3166numeric' => '368', 'Capital' => 'Baghdad', 'Continent' => '2'),
      array('id' => '105', 'Name' => 'Iran', 'ISO3166alpha2' => 'IR', 'ISO3166alpha3' => 'IRN', 'ISO3166numeric' => '364', 'Capital' => 'Tehran', 'Continent' => '2'),
      array('id' => '106', 'Name' => 'Iceland', 'ISO3166alpha2' => 'IS', 'ISO3166alpha3' => 'ISL', 'ISO3166numeric' => '352', 'Capital' => 'Reykjavik', 'Continent' => '3'),
      array('id' => '107', 'Name' => 'Italy', 'ISO3166alpha2' => 'IT', 'ISO3166alpha3' => 'ITA', 'ISO3166numeric' => '380', 'Capital' => 'Rome', 'Continent' => '3'),
      array('id' => '108', 'Name' => 'Jersey', 'ISO3166alpha2' => 'JE', 'ISO3166alpha3' => 'JEY', 'ISO3166numeric' => '832', 'Capital' => 'Saint Helier', 'Continent' => '3'),
      array('id' => '109', 'Name' => 'Jamaica', 'ISO3166alpha2' => 'JM', 'ISO3166alpha3' => 'JAM', 'ISO3166numeric' => '388', 'Capital' => 'Kingston', 'Continent' => '4'),
      array('id' => '110', 'Name' => 'Jordan', 'ISO3166alpha2' => 'JO', 'ISO3166alpha3' => 'JOR', 'ISO3166numeric' => '400', 'Capital' => 'Amman', 'Continent' => '2'),
      array('id' => '111', 'Name' => 'Japan', 'ISO3166alpha2' => 'JP', 'ISO3166alpha3' => 'JPN', 'ISO3166numeric' => '392', 'Capital' => 'Tokyo', 'Continent' => '2'),
      array('id' => '112', 'Name' => 'Kenya', 'ISO3166alpha2' => 'KE', 'ISO3166alpha3' => 'KEN', 'ISO3166numeric' => '404', 'Capital' => 'Nairobi', 'Continent' => '1'),
      array('id' => '113', 'Name' => 'Kyrgyzstan', 'ISO3166alpha2' => 'KG', 'ISO3166alpha3' => 'KGZ', 'ISO3166numeric' => '417', 'Capital' => 'Bishkek', 'Continent' => '2'),
      array('id' => '114', 'Name' => 'Cambodia', 'ISO3166alpha2' => 'KH', 'ISO3166alpha3' => 'KHM', 'ISO3166numeric' => '116', 'Capital' => 'Phnom Penh', 'Continent' => '2'),
      array('id' => '115', 'Name' => 'Kiribati', 'ISO3166alpha2' => 'KI', 'ISO3166alpha3' => 'KIR', 'ISO3166numeric' => '296', 'Capital' => 'Tarawa', 'Continent' => '5'),
      array('id' => '116', 'Name' => 'Comoros', 'ISO3166alpha2' => 'KM', 'ISO3166alpha3' => 'COM', 'ISO3166numeric' => '174', 'Capital' => 'Moroni', 'Continent' => '1'),
      array('id' => '117', 'Name' => 'St Kitts and Nevis', 'ISO3166alpha2' => 'KN', 'ISO3166alpha3' => 'KNA', 'ISO3166numeric' => '659', 'Capital' => 'Basseterre', 'Continent' => '4'),
      array('id' => '118', 'Name' => 'North Korea', 'ISO3166alpha2' => 'KP', 'ISO3166alpha3' => 'PRK', 'ISO3166numeric' => '408', 'Capital' => 'Pyongyang', 'Continent' => '2'),
      array('id' => '119', 'Name' => 'South Korea', 'ISO3166alpha2' => 'KR', 'ISO3166alpha3' => 'KOR', 'ISO3166numeric' => '410', 'Capital' => 'Seoul', 'Continent' => '2'),
      array('id' => '120', 'Name' => 'Kuwait', 'ISO3166alpha2' => 'KW', 'ISO3166alpha3' => 'KWT', 'ISO3166numeric' => '414', 'Capital' => 'Kuwait City', 'Continent' => '2'),
      array('id' => '121', 'Name' => 'Cayman Islands', 'ISO3166alpha2' => 'KY', 'ISO3166alpha3' => 'CYM', 'ISO3166numeric' => '136', 'Capital' => 'George Town', 'Continent' => '4'),
      array('id' => '122', 'Name' => 'Kazakhstan', 'ISO3166alpha2' => 'KZ', 'ISO3166alpha3' => 'KAZ', 'ISO3166numeric' => '398', 'Capital' => 'Nur-Sultan', 'Continent' => '2'),
      array('id' => '123', 'Name' => 'Laos', 'ISO3166alpha2' => 'LA', 'ISO3166alpha3' => 'LAO', 'ISO3166numeric' => '418', 'Capital' => 'Vientiane', 'Continent' => '2'),
      array('id' => '124', 'Name' => 'Lebanon', 'ISO3166alpha2' => 'LB', 'ISO3166alpha3' => 'LBN', 'ISO3166numeric' => '422', 'Capital' => 'Beirut', 'Continent' => '2'),
      array('id' => '125', 'Name' => 'Saint Lucia', 'ISO3166alpha2' => 'LC', 'ISO3166alpha3' => 'LCA', 'ISO3166numeric' => '662', 'Capital' => 'Castries', 'Continent' => '4'),
      array('id' => '126', 'Name' => 'Liechtenstein', 'ISO3166alpha2' => 'LI', 'ISO3166alpha3' => 'LIE', 'ISO3166numeric' => '438', 'Capital' => 'Vaduz', 'Continent' => '3'),
      array('id' => '127', 'Name' => 'Sri Lanka', 'ISO3166alpha2' => 'LK', 'ISO3166alpha3' => 'LKA', 'ISO3166numeric' => '144', 'Capital' => 'Colombo', 'Continent' => '2'),
      array('id' => '128', 'Name' => 'Liberia', 'ISO3166alpha2' => 'LR', 'ISO3166alpha3' => 'LBR', 'ISO3166numeric' => '430', 'Capital' => 'Monrovia', 'Continent' => '1'),
      array('id' => '129', 'Name' => 'Lesotho', 'ISO3166alpha2' => 'LS', 'ISO3166alpha3' => 'LSO', 'ISO3166numeric' => '426', 'Capital' => 'Maseru', 'Continent' => '1'),
      array('id' => '130', 'Name' => 'Lithuania', 'ISO3166alpha2' => 'LT', 'ISO3166alpha3' => 'LTU', 'ISO3166numeric' => '440', 'Capital' => 'Vilnius', 'Continent' => '3'),
      array('id' => '131', 'Name' => 'Luxembourg', 'ISO3166alpha2' => 'LU', 'ISO3166alpha3' => 'LUX', 'ISO3166numeric' => '442', 'Capital' => 'Luxembourg', 'Continent' => '3'),
      array('id' => '132', 'Name' => 'Latvia', 'ISO3166alpha2' => 'LV', 'ISO3166alpha3' => 'LVA', 'ISO3166numeric' => '428', 'Capital' => 'Riga', 'Continent' => '3'),
      array('id' => '133', 'Name' => 'Libya', 'ISO3166alpha2' => 'LY', 'ISO3166alpha3' => 'LBY', 'ISO3166numeric' => '434', 'Capital' => 'Tripoli', 'Continent' => '1'),
      array('id' => '134', 'Name' => 'Morocco', 'ISO3166alpha2' => 'MA', 'ISO3166alpha3' => 'MAR', 'ISO3166numeric' => '504', 'Capital' => 'Rabat', 'Continent' => '1'),
      array('id' => '135', 'Name' => 'Monaco', 'ISO3166alpha2' => 'MC', 'ISO3166alpha3' => 'MCO', 'ISO3166numeric' => '492', 'Capital' => 'Monaco', 'Continent' => '3'),
      array('id' => '136', 'Name' => 'Moldova', 'ISO3166alpha2' => 'MD', 'ISO3166alpha3' => 'MDA', 'ISO3166numeric' => '498', 'Capital' => 'Chisinau', 'Continent' => '3'),
      array('id' => '137', 'Name' => 'Montenegro', 'ISO3166alpha2' => 'ME', 'ISO3166alpha3' => 'MNE', 'ISO3166numeric' => '499', 'Capital' => 'Podgorica', 'Continent' => '3'),
      array('id' => '138', 'Name' => 'Saint Martin', 'ISO3166alpha2' => 'MF', 'ISO3166alpha3' => 'MAF', 'ISO3166numeric' => '663', 'Capital' => 'Marigot', 'Continent' => '4'),
      array('id' => '139', 'Name' => 'Madagascar', 'ISO3166alpha2' => 'MG', 'ISO3166alpha3' => 'MDG', 'ISO3166numeric' => '450', 'Capital' => 'Antananarivo', 'Continent' => '1'),
      array('id' => '140', 'Name' => 'Marshall Islands', 'ISO3166alpha2' => 'MH', 'ISO3166alpha3' => 'MHL', 'ISO3166numeric' => '584', 'Capital' => 'Majuro', 'Continent' => '5'),
      array('id' => '141', 'Name' => 'North Macedonia', 'ISO3166alpha2' => 'MK', 'ISO3166alpha3' => 'MKD', 'ISO3166numeric' => '807', 'Capital' => 'Skopje', 'Continent' => '3'),
      array('id' => '142', 'Name' => 'Mali', 'ISO3166alpha2' => 'ML', 'ISO3166alpha3' => 'MLI', 'ISO3166numeric' => '466', 'Capital' => 'Bamako', 'Continent' => '1'),
      array('id' => '143', 'Name' => 'Myanmar', 'ISO3166alpha2' => 'MM', 'ISO3166alpha3' => 'MMR', 'ISO3166numeric' => '104', 'Capital' => 'Nay Pyi Taw', 'Continent' => '2'),
      array('id' => '144', 'Name' => 'Mongolia', 'ISO3166alpha2' => 'MN', 'ISO3166alpha3' => 'MNG', 'ISO3166numeric' => '496', 'Capital' => 'Ulaanbaatar', 'Continent' => '2'),
      array('id' => '145', 'Name' => 'Macao', 'ISO3166alpha2' => 'MO', 'ISO3166alpha3' => 'MAC', 'ISO3166numeric' => '446', 'Capital' => 'Macao', 'Continent' => '2'),
      array('id' => '146', 'Name' => 'Northern Mariana Islands', 'ISO3166alpha2' => 'MP', 'ISO3166alpha3' => 'MNP', 'ISO3166numeric' => '580', 'Capital' => 'Saipan', 'Continent' => '5'),
      array('id' => '147', 'Name' => 'Martinique', 'ISO3166alpha2' => 'MQ', 'ISO3166alpha3' => 'MTQ', 'ISO3166numeric' => '474', 'Capital' => 'Fort-de-France', 'Continent' => '4'),
      array('id' => '148', 'Name' => 'Mauritania', 'ISO3166alpha2' => 'MR', 'ISO3166alpha3' => 'MRT', 'ISO3166numeric' => '478', 'Capital' => 'Nouakchott', 'Continent' => '1'),
      array('id' => '149', 'Name' => 'Montserrat', 'ISO3166alpha2' => 'MS', 'ISO3166alpha3' => 'MSR', 'ISO3166numeric' => '500', 'Capital' => 'Plymouth', 'Continent' => '4'),
      array('id' => '150', 'Name' => 'Malta', 'ISO3166alpha2' => 'MT', 'ISO3166alpha3' => 'MLT', 'ISO3166numeric' => '470', 'Capital' => 'Valletta', 'Continent' => '3'),
      array('id' => '151', 'Name' => 'Mauritius', 'ISO3166alpha2' => 'MU', 'ISO3166alpha3' => 'MUS', 'ISO3166numeric' => '480', 'Capital' => 'Port Louis', 'Continent' => '1'),
      array('id' => '152', 'Name' => 'Maldives', 'ISO3166alpha2' => 'MV', 'ISO3166alpha3' => 'MDV', 'ISO3166numeric' => '462', 'Capital' => 'Male', 'Continent' => '2'),
      array('id' => '153', 'Name' => 'Malawi', 'ISO3166alpha2' => 'MW', 'ISO3166alpha3' => 'MWI', 'ISO3166numeric' => '454', 'Capital' => 'Lilongwe', 'Continent' => '1'),
      array('id' => '154', 'Name' => 'Mexico', 'ISO3166alpha2' => 'MX', 'ISO3166alpha3' => 'MEX', 'ISO3166numeric' => '484', 'Capital' => 'Mexico City', 'Continent' => '4'),
      array('id' => '155', 'Name' => 'Malaysia', 'ISO3166alpha2' => 'MY', 'ISO3166alpha3' => 'MYS', 'ISO3166numeric' => '458', 'Capital' => 'Kuala Lumpur', 'Continent' => '2'),
      array('id' => '156', 'Name' => 'Mozambique', 'ISO3166alpha2' => 'MZ', 'ISO3166alpha3' => 'MOZ', 'ISO3166numeric' => '508', 'Capital' => 'Maputo', 'Continent' => '1'),
      array('id' => '157', 'Name' => 'Namibia', 'ISO3166alpha2' => 'NA', 'ISO3166alpha3' => 'NAM', 'ISO3166numeric' => '516', 'Capital' => 'Windhoek', 'Continent' => '1'),
      array('id' => '158', 'Name' => 'New Caledonia', 'ISO3166alpha2' => 'NC', 'ISO3166alpha3' => 'NCL', 'ISO3166numeric' => '540', 'Capital' => 'Noumea', 'Continent' => '5'),
      array('id' => '159', 'Name' => 'Niger', 'ISO3166alpha2' => 'NE', 'ISO3166alpha3' => 'NER', 'ISO3166numeric' => '562', 'Capital' => 'Niamey', 'Continent' => '1'),
      array('id' => '160', 'Name' => 'Norfolk Island', 'ISO3166alpha2' => 'NF', 'ISO3166alpha3' => 'NFK', 'ISO3166numeric' => '574', 'Capital' => 'Kingston', 'Continent' => '5'),
      array('id' => '161', 'Name' => 'Nigeria', 'ISO3166alpha2' => 'NG', 'ISO3166alpha3' => 'NGA', 'ISO3166numeric' => '566', 'Capital' => 'Abuja', 'Continent' => '1'),
      array('id' => '162', 'Name' => 'Nicaragua', 'ISO3166alpha2' => 'NI', 'ISO3166alpha3' => 'NIC', 'ISO3166numeric' => '558', 'Capital' => 'Managua', 'Continent' => '4'),
      array('id' => '163', 'Name' => 'Netherlands', 'ISO3166alpha2' => 'NL', 'ISO3166alpha3' => 'NLD', 'ISO3166numeric' => '528', 'Capital' => 'Amsterdam', 'Continent' => '3'),
      array('id' => '164', 'Name' => 'Norway', 'ISO3166alpha2' => 'NO', 'ISO3166alpha3' => 'NOR', 'ISO3166numeric' => '578', 'Capital' => 'Oslo', 'Continent' => '3'),
      array('id' => '165', 'Name' => 'Nepal', 'ISO3166alpha2' => 'NP', 'ISO3166alpha3' => 'NPL', 'ISO3166numeric' => '524', 'Capital' => 'Kathmandu', 'Continent' => '2'),
      array('id' => '166', 'Name' => 'Nauru', 'ISO3166alpha2' => 'NR', 'ISO3166alpha3' => 'NRU', 'ISO3166numeric' => '520', 'Capital' => 'Yaren', 'Continent' => '5'),
      array('id' => '167', 'Name' => 'Niue', 'ISO3166alpha2' => 'NU', 'ISO3166alpha3' => 'NIU', 'ISO3166numeric' => '570', 'Capital' => 'Alofi', 'Continent' => '5'),
      array('id' => '168', 'Name' => 'New Zealand', 'ISO3166alpha2' => 'NZ', 'ISO3166alpha3' => 'NZL', 'ISO3166numeric' => '554', 'Capital' => 'Wellington', 'Continent' => '5'),
      array('id' => '169', 'Name' => 'Oman', 'ISO3166alpha2' => 'OM', 'ISO3166alpha3' => 'OMN', 'ISO3166numeric' => '512', 'Capital' => 'Muscat', 'Continent' => '2'),
      array('id' => '170', 'Name' => 'Panama', 'ISO3166alpha2' => 'PA', 'ISO3166alpha3' => 'PAN', 'ISO3166numeric' => '591', 'Capital' => 'Panama City', 'Continent' => '4'),
      array('id' => '171', 'Name' => 'Peru', 'ISO3166alpha2' => 'PE', 'ISO3166alpha3' => 'PER', 'ISO3166numeric' => '604', 'Capital' => 'Lima', 'Continent' => '6'),
      array('id' => '172', 'Name' => 'French Polynesia', 'ISO3166alpha2' => 'PF', 'ISO3166alpha3' => 'PYF', 'ISO3166numeric' => '258', 'Capital' => 'Papeete', 'Continent' => '5'),
      array('id' => '173', 'Name' => 'Papua New Guinea', 'ISO3166alpha2' => 'PG', 'ISO3166alpha3' => 'PNG', 'ISO3166numeric' => '598', 'Capital' => 'Port Moresby', 'Continent' => '5'),
      array('id' => '174', 'Name' => 'Philippines', 'ISO3166alpha2' => 'PH', 'ISO3166alpha3' => 'PHL', 'ISO3166numeric' => '608', 'Capital' => 'Manila', 'Continent' => '2'),
      array('id' => '175', 'Name' => 'Pakistan', 'ISO3166alpha2' => 'PK', 'ISO3166alpha3' => 'PAK', 'ISO3166numeric' => '586', 'Capital' => 'Islamabad', 'Continent' => '2'),
      array('id' => '176', 'Name' => 'Poland', 'ISO3166alpha2' => 'PL', 'ISO3166alpha3' => 'POL', 'ISO3166numeric' => '616', 'Capital' => 'Warsaw', 'Continent' => '3'),
      array('id' => '177', 'Name' => 'Saint Pierre and Miquelon', 'ISO3166alpha2' => 'PM', 'ISO3166alpha3' => 'SPM', 'ISO3166numeric' => '666', 'Capital' => 'Saint-Pierre', 'Continent' => '4'),
      array('id' => '178', 'Name' => 'Pitcairn Islands', 'ISO3166alpha2' => 'PN', 'ISO3166alpha3' => 'PCN', 'ISO3166numeric' => '612', 'Capital' => 'Adamstown', 'Continent' => '5'),
      array('id' => '179', 'Name' => 'Puerto Rico', 'ISO3166alpha2' => 'PR', 'ISO3166alpha3' => 'PRI', 'ISO3166numeric' => '630', 'Capital' => 'San Juan', 'Continent' => '4'),
      array('id' => '180', 'Name' => 'Palestine', 'ISO3166alpha2' => 'PS', 'ISO3166alpha3' => 'PSE', 'ISO3166numeric' => '275', 'Capital' => 'East Jerusalem', 'Continent' => '2'),
      array('id' => '181', 'Name' => 'Portugal', 'ISO3166alpha2' => 'PT', 'ISO3166alpha3' => 'PRT', 'ISO3166numeric' => '620', 'Capital' => 'Lisbon', 'Continent' => '3'),
      array('id' => '182', 'Name' => 'Palau', 'ISO3166alpha2' => 'PW', 'ISO3166alpha3' => 'PLW', 'ISO3166numeric' => '585', 'Capital' => 'Melekeok', 'Continent' => '5'),
      array('id' => '183', 'Name' => 'Paraguay', 'ISO3166alpha2' => 'PY', 'ISO3166alpha3' => 'PRY', 'ISO3166numeric' => '600', 'Capital' => 'Asuncion', 'Continent' => '6'),
      array('id' => '184', 'Name' => 'Qatar', 'ISO3166alpha2' => 'QA', 'ISO3166alpha3' => 'QAT', 'ISO3166numeric' => '634', 'Capital' => 'Doha', 'Continent' => '2'),
      array('id' => '185', 'Name' => 'R?union', 'ISO3166alpha2' => 'RE', 'ISO3166alpha3' => 'REU', 'ISO3166numeric' => '638', 'Capital' => 'Saint-Denis', 'Continent' => '1'),
      array('id' => '186', 'Name' => 'Romania', 'ISO3166alpha2' => 'RO', 'ISO3166alpha3' => 'ROU', 'ISO3166numeric' => '642', 'Capital' => 'Bucharest', 'Continent' => '3'),
      array('id' => '187', 'Name' => 'Serbia', 'ISO3166alpha2' => 'RS', 'ISO3166alpha3' => 'SRB', 'ISO3166numeric' => '688', 'Capital' => 'Belgrade', 'Continent' => '3'),
      array('id' => '188', 'Name' => 'Russia', 'ISO3166alpha2' => 'RU', 'ISO3166alpha3' => 'RUS', 'ISO3166numeric' => '643', 'Capital' => 'Moscow', 'Continent' => '3'),
      array('id' => '189', 'Name' => 'Rwanda', 'ISO3166alpha2' => 'RW', 'ISO3166alpha3' => 'RWA', 'ISO3166numeric' => '646', 'Capital' => 'Kigali', 'Continent' => '1'),
      array('id' => '190', 'Name' => 'Saudi Arabia', 'ISO3166alpha2' => 'SA', 'ISO3166alpha3' => 'SAU', 'ISO3166numeric' => '682', 'Capital' => 'Riyadh', 'Continent' => '2'),
      array('id' => '191', 'Name' => 'Solomon Islands', 'ISO3166alpha2' => 'SB', 'ISO3166alpha3' => 'SLB', 'ISO3166numeric' => '90', 'Capital' => 'Honiara', 'Continent' => '5'),
      array('id' => '192', 'Name' => 'Seychelles', 'ISO3166alpha2' => 'SC', 'ISO3166alpha3' => 'SYC', 'ISO3166numeric' => '690', 'Capital' => 'Victoria', 'Continent' => '1'),
      array('id' => '193', 'Name' => 'Sudan', 'ISO3166alpha2' => 'SD', 'ISO3166alpha3' => 'SDN', 'ISO3166numeric' => '729', 'Capital' => 'Khartoum', 'Continent' => '1'),
      array('id' => '194', 'Name' => 'Sweden', 'ISO3166alpha2' => 'SE', 'ISO3166alpha3' => 'SWE', 'ISO3166numeric' => '752', 'Capital' => 'Stockholm', 'Continent' => '3'),
      array('id' => '195', 'Name' => 'Singapore', 'ISO3166alpha2' => 'SG', 'ISO3166alpha3' => 'SGP', 'ISO3166numeric' => '702', 'Capital' => 'Singapore', 'Continent' => '2'),
      array('id' => '196', 'Name' => 'Saint Helena', 'ISO3166alpha2' => 'SH', 'ISO3166alpha3' => 'SHN', 'ISO3166numeric' => '654', 'Capital' => 'Jamestown', 'Continent' => '1'),
      array('id' => '197', 'Name' => 'Slovenia', 'ISO3166alpha2' => 'SI', 'ISO3166alpha3' => 'SVN', 'ISO3166numeric' => '705', 'Capital' => 'Ljubljana', 'Continent' => '3'),
      array('id' => '198', 'Name' => 'Svalbard and Jan Mayen', 'ISO3166alpha2' => 'SJ', 'ISO3166alpha3' => 'SJM', 'ISO3166numeric' => '744', 'Capital' => 'Longyearbyen', 'Continent' => '3'),
      array('id' => '199', 'Name' => 'Slovakia', 'ISO3166alpha2' => 'SK', 'ISO3166alpha3' => 'SVK', 'ISO3166numeric' => '703', 'Capital' => 'Bratislava', 'Continent' => '3'),
      array('id' => '200', 'Name' => 'Sierra Leone', 'ISO3166alpha2' => 'SL', 'ISO3166alpha3' => 'SLE', 'ISO3166numeric' => '694', 'Capital' => 'Freetown', 'Continent' => '1'),
      array('id' => '201', 'Name' => 'San Marino', 'ISO3166alpha2' => 'SM', 'ISO3166alpha3' => 'SMR', 'ISO3166numeric' => '674', 'Capital' => 'San Marino', 'Continent' => '3'),
      array('id' => '202', 'Name' => 'Senegal', 'ISO3166alpha2' => 'SN', 'ISO3166alpha3' => 'SEN', 'ISO3166numeric' => '686', 'Capital' => 'Dakar', 'Continent' => '1'),
      array('id' => '203', 'Name' => 'Somalia', 'ISO3166alpha2' => 'SO', 'ISO3166alpha3' => 'SOM', 'ISO3166numeric' => '706', 'Capital' => 'Mogadishu', 'Continent' => '1'),
      array('id' => '204', 'Name' => 'Suriname', 'ISO3166alpha2' => 'SR', 'ISO3166alpha3' => 'SUR', 'ISO3166numeric' => '740', 'Capital' => 'Paramaribo', 'Continent' => '6'),
      array('id' => '205', 'Name' => 'South Sudan', 'ISO3166alpha2' => 'SS', 'ISO3166alpha3' => 'SSD', 'ISO3166numeric' => '728', 'Capital' => 'Juba', 'Continent' => '1'),
      array('id' => '206', 'Name' => 'S?o Tom? and Pr?ncipe', 'ISO3166alpha2' => 'ST', 'ISO3166alpha3' => 'STP', 'ISO3166numeric' => '678', 'Capital' => 'Sao Tome', 'Continent' => '1'),
      array('id' => '207', 'Name' => 'El Salvador', 'ISO3166alpha2' => 'SV', 'ISO3166alpha3' => 'SLV', 'ISO3166numeric' => '222', 'Capital' => 'San Salvador', 'Continent' => '4'),
      array('id' => '208', 'Name' => 'Sint Maarten', 'ISO3166alpha2' => 'SX', 'ISO3166alpha3' => 'SXM', 'ISO3166numeric' => '534', 'Capital' => 'Philipsburg', 'Continent' => '4'),
      array('id' => '209', 'Name' => 'Syria', 'ISO3166alpha2' => 'SY', 'ISO3166alpha3' => 'SYR', 'ISO3166numeric' => '760', 'Capital' => 'Damascus', 'Continent' => '2'),
      array('id' => '210', 'Name' => 'Eswatini', 'ISO3166alpha2' => 'SZ', 'ISO3166alpha3' => 'SWZ', 'ISO3166numeric' => '748', 'Capital' => 'Mbabane', 'Continent' => '1'),
      array('id' => '211', 'Name' => 'Turks and Caicos Islands', 'ISO3166alpha2' => 'TC', 'ISO3166alpha3' => 'TCA', 'ISO3166numeric' => '796', 'Capital' => 'Cockburn Town', 'Continent' => '4'),
      array('id' => '212', 'Name' => 'Chad', 'ISO3166alpha2' => 'TD', 'ISO3166alpha3' => 'TCD', 'ISO3166numeric' => '148', 'Capital' => 'N`Djamena', 'Continent' => '1'),
      array('id' => '213', 'Name' => 'French Southern Territories', 'ISO3166alpha2' => 'TF', 'ISO3166alpha3' => 'ATF', 'ISO3166numeric' => '260', 'Capital' => 'Port-aux-Francais', 'Continent' => '7'),
      array('id' => '214', 'Name' => 'Togo', 'ISO3166alpha2' => 'TG', 'ISO3166alpha3' => 'TGO', 'ISO3166numeric' => '768', 'Capital' => 'Lome', 'Continent' => '1'),
      array('id' => '215', 'Name' => 'Thailand', 'ISO3166alpha2' => 'TH', 'ISO3166alpha3' => 'THA', 'ISO3166numeric' => '764', 'Capital' => 'Bangkok', 'Continent' => '2'),
      array('id' => '216', 'Name' => 'Tajikistan', 'ISO3166alpha2' => 'TJ', 'ISO3166alpha3' => 'TJK', 'ISO3166numeric' => '762', 'Capital' => 'Dushanbe', 'Continent' => '2'),
      array('id' => '217', 'Name' => 'Tokelau', 'ISO3166alpha2' => 'TK', 'ISO3166alpha3' => 'TKL', 'ISO3166numeric' => '772', 'Capital' => 'Tokelau', 'Continent' => '5'),
      array('id' => '218', 'Name' => 'Timor-Leste', 'ISO3166alpha2' => 'TL', 'ISO3166alpha3' => 'TLS', 'ISO3166numeric' => '626', 'Capital' => 'Dili', 'Continent' => '5'),
      array('id' => '219', 'Name' => 'Turkmenistan', 'ISO3166alpha2' => 'TM', 'ISO3166alpha3' => 'TKM', 'ISO3166numeric' => '795', 'Capital' => 'Ashgabat', 'Continent' => '2'),
      array('id' => '220', 'Name' => 'Tunisia', 'ISO3166alpha2' => 'TN', 'ISO3166alpha3' => 'TUN', 'ISO3166numeric' => '788', 'Capital' => 'Tunis', 'Continent' => '1'),
      array('id' => '221', 'Name' => 'Tonga', 'ISO3166alpha2' => 'TO', 'ISO3166alpha3' => 'TON', 'ISO3166numeric' => '776', 'Capital' => 'Nuku`alofa', 'Continent' => '5'),
      array('id' => '222', 'Name' => 'Turkey', 'ISO3166alpha2' => 'TR', 'ISO3166alpha3' => 'TUR', 'ISO3166numeric' => '792', 'Capital' => 'Ankara', 'Continent' => '2'),
      array('id' => '223', 'Name' => 'Trinidad and Tobago', 'ISO3166alpha2' => 'TT', 'ISO3166alpha3' => 'TTO', 'ISO3166numeric' => '780', 'Capital' => 'Port of Spain', 'Continent' => '4'),
      array('id' => '224', 'Name' => 'Tuvalu', 'ISO3166alpha2' => 'TV', 'ISO3166alpha3' => 'TUV', 'ISO3166numeric' => '798', 'Capital' => 'Funafuti', 'Continent' => '5'),
      array('id' => '225', 'Name' => 'Taiwan', 'ISO3166alpha2' => 'TW', 'ISO3166alpha3' => 'TWN', 'ISO3166numeric' => '158', 'Capital' => 'Taipei', 'Continent' => '2'),
      array('id' => '226', 'Name' => 'Tanzania', 'ISO3166alpha2' => 'TZ', 'ISO3166alpha3' => 'TZA', 'ISO3166numeric' => '834', 'Capital' => 'Dodoma', 'Continent' => '1'),
      array('id' => '227', 'Name' => 'Ukraine', 'ISO3166alpha2' => 'UA', 'ISO3166alpha3' => 'UKR', 'ISO3166numeric' => '804', 'Capital' => 'Kyiv', 'Continent' => '3'),
      array('id' => '228', 'Name' => 'Uganda', 'ISO3166alpha2' => 'UG', 'ISO3166alpha3' => 'UGA', 'ISO3166numeric' => '800', 'Capital' => 'Kampala', 'Continent' => '1'),
      array('id' => '229', 'Name' => 'United States', 'ISO3166alpha2' => 'US', 'ISO3166alpha3' => 'USA', 'ISO3166numeric' => '840', 'Capital' => 'Washington', 'Continent' => '4'),
      array('id' => '230', 'Name' => 'Uruguay', 'ISO3166alpha2' => 'UY', 'ISO3166alpha3' => 'URY', 'ISO3166numeric' => '858', 'Capital' => 'Montevideo', 'Continent' => '6'),
      array('id' => '231', 'Name' => 'Uzbekistan', 'ISO3166alpha2' => 'UZ', 'ISO3166alpha3' => 'UZB', 'ISO3166numeric' => '860', 'Capital' => 'Tashkent', 'Continent' => '2'),
      array('id' => '232', 'Name' => 'Vatican City', 'ISO3166alpha2' => 'VA', 'ISO3166alpha3' => 'VAT', 'ISO3166numeric' => '336', 'Capital' => 'Vatican City', 'Continent' => '3'),
      array('id' => '233', 'Name' => 'St Vincent and Grenadines', 'ISO3166alpha2' => 'VC', 'ISO3166alpha3' => 'VCT', 'ISO3166numeric' => '670', 'Capital' => 'Kingstown', 'Continent' => '4'),
      array('id' => '234', 'Name' => 'Venezuela', 'ISO3166alpha2' => 'VE', 'ISO3166alpha3' => 'VEN', 'ISO3166numeric' => '862', 'Capital' => 'Caracas', 'Continent' => '6'),
      array('id' => '235', 'Name' => 'British Virgin Islands', 'ISO3166alpha2' => 'VG', 'ISO3166alpha3' => 'VGB', 'ISO3166numeric' => '92', 'Capital' => 'Road Town', 'Continent' => '4'),
      array('id' => '236', 'Name' => 'U.S. Virgin Islands', 'ISO3166alpha2' => 'VI', 'ISO3166alpha3' => 'VIR', 'ISO3166numeric' => '850', 'Capital' => 'Charlotte Amalie', 'Continent' => '4'),
      array('id' => '237', 'Name' => 'Vietnam', 'ISO3166alpha2' => 'VN', 'ISO3166alpha3' => 'VNM', 'ISO3166numeric' => '704', 'Capital' => 'Hanoi', 'Continent' => '2'),
      array('id' => '238', 'Name' => 'Vanuatu', 'ISO3166alpha2' => 'VU', 'ISO3166alpha3' => 'VUT', 'ISO3166numeric' => '548', 'Capital' => 'Port Vila', 'Continent' => '5'),
      array('id' => '239', 'Name' => 'Wallis and Futuna', 'ISO3166alpha2' => 'WF', 'ISO3166alpha3' => 'WLF', 'ISO3166numeric' => '876', 'Capital' => 'Mata Utu', 'Continent' => '5'),
      array('id' => '240', 'Name' => 'Samoa', 'ISO3166alpha2' => 'WS', 'ISO3166alpha3' => 'WSM', 'ISO3166numeric' => '882', 'Capital' => 'Apia', 'Continent' => '5'),
      array('id' => '241', 'Name' => 'Kosovo', 'ISO3166alpha2' => 'XK', 'ISO3166alpha3' => 'XKX', 'ISO3166numeric' => '0', 'Capital' => 'Pristina', 'Continent' => '3'),
      array('id' => '242', 'Name' => 'Yemen', 'ISO3166alpha2' => 'YE', 'ISO3166alpha3' => 'YEM', 'ISO3166numeric' => '887', 'Capital' => 'Sanaa', 'Continent' => '2'),
      array('id' => '243', 'Name' => 'Mayotte', 'ISO3166alpha2' => 'YT', 'ISO3166alpha3' => 'MYT', 'ISO3166numeric' => '175', 'Capital' => 'Mamoudzou', 'Continent' => '1'),
      array('id' => '244', 'Name' => 'South Africa', 'ISO3166alpha2' => 'ZA', 'ISO3166alpha3' => 'ZAF', 'ISO3166numeric' => '710', 'Capital' => 'Pretoria', 'Continent' => '1'),
      array('id' => '245', 'Name' => 'Zambia', 'ISO3166alpha2' => 'ZM', 'ISO3166alpha3' => 'ZMB', 'ISO3166numeric' => '894', 'Capital' => 'Lusaka', 'Continent' => '1'),
      array('id' => '246', 'Name' => 'Zimbabwe', 'ISO3166alpha2' => 'ZW', 'ISO3166alpha3' => 'ZWE', 'ISO3166numeric' => '716', 'Capital' => 'Harare', 'Continent' => '1')
    ),
    'mr_language' => array(
      array('id' => '1', 'Name' => 'RU', 'Description' => 'Русский'),
      array('id' => '2', 'Name' => 'EN', 'Description' => 'English')
    ),
  );
}