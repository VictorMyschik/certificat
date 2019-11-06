<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\MrCurrency;
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


  public static function Start()
  {
    self::MrCurrencyData();

    return back();
  }

  public static function MrCurrencyData()
  {
    $arr = array(
      array(
        'Code' => '784',
        'TextCode' => 'AED',
        'DateFrom' => NULL,
        'DateTo' => NULL,
        'Name' => 'Дирхам (ОАЭ)',
        'Rounding' => '2',
        'Description' => ''
      ),
      array('ID' => '2','Code' => '971','TextCode' => 'AFN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Афгани','Rounding' => '2','Description' => ''),
      array('ID' => '3','Code' => '008','TextCode' => 'ALL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Лек','Rounding' => '2','Description' => ''),
      array('ID' => '4','Code' => '051','TextCode' => 'AMD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Армянский драм','Rounding' => '2','Description' => ''),
      array('ID' => '5','Code' => '532','TextCode' => 'ANG','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Нидерландский антильский гульден','Rounding' => '2','Description' => ''),
      array('ID' => '6','Code' => '973','TextCode' => 'AOA','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кванза','Rounding' => '2','Description' => 'Ангольская '),
      array('ID' => '7','Code' => '032','TextCode' => 'ARS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Аргентинское песо','Rounding' => '2','Description' => ''),
      array('ID' => '8','Code' => '040','TextCode' => 'ATS','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Австрийский шиллинг','Rounding' => '2','Description' => ''),
      array('ID' => '9','Code' => '036','TextCode' => 'AUD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Австралийский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '10','Code' => '533','TextCode' => 'AWG','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Арубанский флорин','Rounding' => '2','Description' => ''),
      array('ID' => '11','Code' => '944','TextCode' => 'AZN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Азербайджанский манат','Rounding' => '2','Description' => ''),
      array('ID' => '12','Code' => '977','TextCode' => 'BAM','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Конвертируемая марка ','Rounding' => '2','Description' => '(Босния и Герцеговина)'),
      array('ID' => '13','Code' => '052','TextCode' => 'BBD','DateFrom' => NULL,'DateTo' => NULL,'Name' => ' Барбадосский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '14','Code' => '050','TextCode' => 'BDT','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Така','Rounding' => '2','Description' => ''),
      array('ID' => '15','Code' => '056','TextCode' => 'BEF','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Бельгийский франк','Rounding' => '2','Description' => ''),
      array('ID' => '16','Code' => '975','TextCode' => 'BGN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Болгарский лев','Rounding' => '2','Description' => ''),
      array('ID' => '17','Code' => '048','TextCode' => 'BHD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бахрейнский динар','Rounding' => '2','Description' => ''),
      array('ID' => '18','Code' => '108','TextCode' => 'BIF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бурундийский франк','Rounding' => '2','Description' => ' 	
'),
      array('ID' => '19','Code' => '060','TextCode' => 'BMD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бермудский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '20','Code' => '096','TextCode' => 'BND','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Брунейский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '21','Code' => '068','TextCode' => 'BOB','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Боливиано','Rounding' => '2','Description' => ''),
      array('ID' => '22','Code' => '986','TextCode' => 'BRL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бразильский реал','Rounding' => '2','Description' => ''),
      array('ID' => '23','Code' => '044','TextCode' => 'BSD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Багамский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '24','Code' => '064','TextCode' => 'BTN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Нгултрум','Rounding' => '2','Description' => ''),
      array('ID' => '25','Code' => '072','TextCode' => 'BWP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Пула','Rounding' => '2','Description' => ''),
      array('ID' => '26','Code' => '974','TextCode' => 'BYR','DateFrom' => NULL,'DateTo' => '2016-06-30 00:00:00','Name' => 'Белорусский рубль <1>','Rounding' => '0','Description' => '<1> Применяется для денежных средств, уплаченных до 30 июня 2016 г. включительно.'),
      array('ID' => '27','Code' => '933','TextCode' => 'BYN','DateFrom' => '2016-07-01 00:00:00','DateTo' => NULL,'Name' => 'Белорусский рубль','Rounding' => '2','Description' => 'новый, с 1.07.2016'),
      array('ID' => '28','Code' => '084','TextCode' => 'BZD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Белизский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '29','Code' => '124','TextCode' => 'CAD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Канадский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '30','Code' => '976','TextCode' => 'CDF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Конголезский франк','Rounding' => '2','Description' => ''),
      array('ID' => '31','Code' => '756','TextCode' => 'CHF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Швейцарский франк','Rounding' => '2','Description' => ''),
      array('ID' => '32','Code' => '152','TextCode' => 'CLP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Чилийское песо','Rounding' => '2','Description' => ''),
      array('ID' => '33','Code' => '156','TextCode' => 'CNY','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Юань','Rounding' => '2','Description' => ''),
      array('ID' => '34','Code' => '170','TextCode' => 'COP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Колумбийское песо','Rounding' => '2','Description' => ''),
      array('ID' => '35','Code' => '970','TextCode' => 'COU','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Единица реальной стоимости ','Rounding' => '2','Description' => '(Колумбия)'),
      array('ID' => '36','Code' => '188','TextCode' => 'CRC','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Костариканский колон','Rounding' => '2','Description' => ''),
      array('ID' => '37','Code' => '931','TextCode' => 'CUC','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Конвертируемое песо','Rounding' => '2','Description' => ''),
      array('ID' => '38','Code' => '192','TextCode' => 'CUP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кубинское песо','Rounding' => '2','Description' => ''),
      array('ID' => '39','Code' => '132','TextCode' => 'CVE','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Эскудо  Кабо-Верде ','Rounding' => '2','Description' => ''),
      array('ID' => '40','Code' => '203','TextCode' => 'CZK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Чешская крона','Rounding' => '2','Description' => ''),
      array('ID' => '41','Code' => '276','TextCode' => 'DEM','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Немецкая марка','Rounding' => '2','Description' => ''),
      array('ID' => '42','Code' => '262','TextCode' => 'DJF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Франк Джибути','Rounding' => '2','Description' => ' '),
      array('ID' => '43','Code' => '208','TextCode' => 'DKK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Датская крона','Rounding' => '2','Description' => ''),
      array('ID' => '44','Code' => '214','TextCode' => 'DOP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доминиканское песо','Rounding' => '2','Description' => ''),
      array('ID' => '45','Code' => '012','TextCode' => 'DZD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Алжирский динар','Rounding' => '2','Description' => ''),
      array('ID' => '46','Code' => '233','TextCode' => 'EEK','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Эстонская крона','Rounding' => '2','Description' => ''),
      array('ID' => '47','Code' => '818','TextCode' => 'EGP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Египетский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '48','Code' => '232','TextCode' => 'ERN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Накфа ','Rounding' => '2','Description' => '(Эритрея)'),
      array('ID' => '49','Code' => '724','TextCode' => 'ESP','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Испанская песета','Rounding' => '2','Description' => ''),
      array('ID' => '50','Code' => '230','TextCode' => 'ETB','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Эфиопский быр','Rounding' => '2','Description' => ''),
      array('ID' => '51','Code' => '978','TextCode' => 'EUR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Евро','Rounding' => '2','Description' => '(Единая европейская валюта)

'),
      array('ID' => '52','Code' => '246','TextCode' => 'FIM','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Финляндская марка','Rounding' => '2','Description' => ''),
      array('ID' => '53','Code' => '242','TextCode' => 'FJD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар Фиджи','Rounding' => '2','Description' => ''),
      array('ID' => '54','Code' => '238','TextCode' => 'FKP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Фунт Фолклендских островов','Rounding' => '2','Description' => ''),
      array('ID' => '55','Code' => '250','TextCode' => 'FRF','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Французский франк','Rounding' => '2','Description' => ''),
      array('ID' => '56','Code' => '826','TextCode' => 'GBP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Фунт стерлингов ','Rounding' => '2','Description' => ''),
      array('ID' => '57','Code' => '981','TextCode' => 'GEL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Лари','Rounding' => '2','Description' => 'Грузинский '),
      array('ID' => '58','Code' => '936','TextCode' => 'GHS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Ганский седи','Rounding' => '2','Description' => ''),
      array('ID' => '59','Code' => '292','TextCode' => 'GIP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гибралтарский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '60','Code' => '270','TextCode' => 'GMD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Даласи','Rounding' => '2','Description' => ''),
      array('ID' => '61','Code' => '324','TextCode' => 'GNF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гвинейский франк','Rounding' => '2','Description' => ''),
      array('ID' => '62','Code' => '300','TextCode' => 'GRD','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Греческая драхма','Rounding' => '2','Description' => ''),
      array('ID' => '63','Code' => '320','TextCode' => 'GTQ','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кетсаль','Rounding' => '2','Description' => ''),
      array('ID' => '64','Code' => '328','TextCode' => 'GYD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гайанский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '65','Code' => '344','TextCode' => 'HKD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гонконгский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '66','Code' => '340','TextCode' => 'HNL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Лемпира','Rounding' => '2','Description' => ''),
      array('ID' => '67','Code' => '191','TextCode' => 'HRK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Куна','Rounding' => '2','Description' => ' (Хорватия)'),
      array('ID' => '68','Code' => '332','TextCode' => 'HTG','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гурд','Rounding' => '2','Description' => ''),
      array('ID' => '69','Code' => '348','TextCode' => 'HUF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Форинт','Rounding' => '2','Description' => ''),
      array('ID' => '70','Code' => '360','TextCode' => 'IDR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Рупия','Rounding' => '2','Description' => ''),
      array('ID' => '71','Code' => '372','TextCode' => 'IEP','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Ирландский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '72','Code' => '376','TextCode' => 'ILS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Новый израильский шекель','Rounding' => '2','Description' => ''),
      array('ID' => '73','Code' => '356','TextCode' => 'INR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Индийская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '74','Code' => '368','TextCode' => 'IQD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Иракский динар','Rounding' => '2','Description' => ''),
      array('ID' => '75','Code' => '364','TextCode' => 'IRR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Иранский риал','Rounding' => '2','Description' => ''),
      array('ID' => '76','Code' => '352','TextCode' => 'ISK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Исландская крона','Rounding' => '2','Description' => ''),
      array('ID' => '77','Code' => '380','TextCode' => 'ITL','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Итальянская лира','Rounding' => '2','Description' => ''),
      array('ID' => '78','Code' => '388','TextCode' => 'JMD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Ямайский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '79','Code' => '400','TextCode' => 'JOD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Иорданский динар','Rounding' => '2','Description' => ''),
      array('ID' => '80','Code' => '392','TextCode' => 'JPY','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Иена','Rounding' => '2','Description' => ''),
      array('ID' => '81','Code' => '404','TextCode' => 'KES','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кенийский шиллинг','Rounding' => '2','Description' => ''),
      array('ID' => '82','Code' => '417','TextCode' => 'KGS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сом','Rounding' => '2','Description' => '(Киргизский)'),
      array('ID' => '83','Code' => '116','TextCode' => 'KHR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Риель','Rounding' => '2','Description' => ''),
      array('ID' => '84','Code' => '174','TextCode' => 'KMF','DateFrom' => NULL,'DateTo' => '2017-10-12 00:00:00','Name' => 'Франк Комор','Rounding' => '2','Description' => ''),
      array('ID' => '85','Code' => '408','TextCode' => 'KPW','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Северокорейская вона','Rounding' => '2','Description' => ''),
      array('ID' => '86','Code' => '410','TextCode' => 'KRW','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Вона','Rounding' => '2','Description' => ''),
      array('ID' => '87','Code' => '414','TextCode' => 'KWD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кувейтский динар','Rounding' => '2','Description' => ''),
      array('ID' => '88','Code' => '136','TextCode' => 'KYD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар островов Кайман','Rounding' => '2','Description' => ''),
      array('ID' => '89','Code' => '398','TextCode' => 'KZT','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Тенге','Rounding' => '2','Description' => ''),
      array('ID' => '90','Code' => '418','TextCode' => 'LAK','DateFrom' => NULL,'DateTo' => '2017-10-12 00:00:00','Name' => 'Кип','Rounding' => '2','Description' => ''),
      array('ID' => '91','Code' => '422','TextCode' => 'LBP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Ливанский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '92','Code' => '144','TextCode' => 'LKR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Шри-Ланкийская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '93','Code' => '430','TextCode' => 'LRD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Либерийский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '94','Code' => '426','TextCode' => 'LSL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Лоти ','Rounding' => '2','Description' => ''),
      array('ID' => '95','Code' => '440','TextCode' => 'LTL','DateFrom' => NULL,'DateTo' => '2018-06-23 00:00:00','Name' => 'Литовский лит <3>','Rounding' => '2','Description' => '<3> Не применяется с 1 января 2015 г.'),
      array('ID' => '96','Code' => '442','TextCode' => 'LUF','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Люксембургский франк','Rounding' => '2','Description' => ''),
      array('ID' => '97','Code' => '428','TextCode' => 'LVL','DateFrom' => NULL,'DateTo' => '2014-01-14 00:00:00','Name' => 'Латвийский лат <2>','Rounding' => '2','Description' => '<2> Не применяется с 15 января 2014 г.'),
      array('ID' => '98','Code' => '434','TextCode' => 'LYD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Ливийский динар','Rounding' => '2','Description' => ''),
      array('ID' => '99','Code' => '504','TextCode' => 'MAD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Марокканский дирхам','Rounding' => '2','Description' => ''),
      array('ID' => '100','Code' => '498','TextCode' => 'MDL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Молдавский лей','Rounding' => '2','Description' => ''),
      array('ID' => '101','Code' => '969','TextCode' => 'MGA','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Малагасийский ариари','Rounding' => '2','Description' => ''),
      array('ID' => '102','Code' => '807','TextCode' => 'MKD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Денар','Rounding' => '2','Description' => ''),
      array('ID' => '103','Code' => '104','TextCode' => 'MMK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кьят','Rounding' => '2','Description' => ''),
      array('ID' => '104','Code' => '496','TextCode' => 'MNT','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Тугрик','Rounding' => '2','Description' => ''),
      array('ID' => '105','Code' => '446','TextCode' => 'MOP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Патака','Rounding' => '2','Description' => ''),
      array('ID' => '106','Code' => '478','TextCode' => 'MRO','DateFrom' => NULL,'DateTo' => '2018-06-23 00:00:00','Name' => 'Угия <4>','Rounding' => '2','Description' => 'Мавританская 
<4> Не применяется с 1 января 2018 г.'),
      array('ID' => '107','Code' => '480','TextCode' => 'MUR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Маврикийская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '108','Code' => '462','TextCode' => 'MVR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Руфия','Rounding' => '2','Description' => ''),
      array('ID' => '109','Code' => '454','TextCode' => 'MWK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Малавийская квача','Rounding' => '2','Description' => ''),
      array('ID' => '110','Code' => '484','TextCode' => 'MXN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Мексиканское песо','Rounding' => '2','Description' => ''),
      array('ID' => '111','Code' => '458','TextCode' => 'MYR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Малайзийский ринггит','Rounding' => '2','Description' => ''),
      array('ID' => '112','Code' => '943','TextCode' => 'MZN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Мозамбикский метикал','Rounding' => '2','Description' => ''),
      array('ID' => '113','Code' => '516','TextCode' => 'NAD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар Намибии','Rounding' => '2','Description' => ''),
      array('ID' => '114','Code' => '566','TextCode' => 'NGN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Найра','Rounding' => '2','Description' => ''),
      array('ID' => '115','Code' => '558','TextCode' => 'NIO','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Золотая кордоба','Rounding' => '2','Description' => ''),
      array('ID' => '116','Code' => '528','TextCode' => 'NLG','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Нидерландский гульден','Rounding' => '2','Description' => ''),
      array('ID' => '117','Code' => '578','TextCode' => 'NOK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Норвежская крона','Rounding' => '2','Description' => ''),
      array('ID' => '118','Code' => '524','TextCode' => 'NPR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Непальская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '119','Code' => '554','TextCode' => 'NZD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Новозеландский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '120','Code' => '512','TextCode' => 'OMR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Оманский риал','Rounding' => '2','Description' => ''),
      array('ID' => '121','Code' => '590','TextCode' => 'PAB','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бальбоа','Rounding' => '2','Description' => 'Панамский '),
      array('ID' => '122','Code' => '604','TextCode' => 'PEN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Соль','Rounding' => '2','Description' => ''),
      array('ID' => '123','Code' => '598','TextCode' => 'PGK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Кина','Rounding' => '2','Description' => ' Папуа-Новой Гвинеи'),
      array('ID' => '124','Code' => '608','TextCode' => 'PHP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Филиппинское песо','Rounding' => '2','Description' => ''),
      array('ID' => '125','Code' => '586','TextCode' => 'PKR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Пакистанская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '126','Code' => '985','TextCode' => 'PLN','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Злотый','Rounding' => '2','Description' => ''),
      array('ID' => '127','Code' => '620','TextCode' => 'PTE','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Португальский эскудо','Rounding' => '2','Description' => ''),
      array('ID' => '128','Code' => '600','TextCode' => 'PYG','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гуарани','Rounding' => '2','Description' => 'Парагвайский '),
      array('ID' => '129','Code' => '634','TextCode' => 'QAR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Катарский риал','Rounding' => '2','Description' => ''),
      array('ID' => '130','Code' => '946','TextCode' => 'RON','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Румынский Лей ','Rounding' => '2','Description' => ''),
      array('ID' => '131','Code' => '941','TextCode' => 'RSD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сербский динар','Rounding' => '2','Description' => ''),
      array('ID' => '132','Code' => '643','TextCode' => 'RUB','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Российский рубль','Rounding' => '2','Description' => ''),
      array('ID' => '133','Code' => '646','TextCode' => 'RWF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Франк Руанды','Rounding' => '2','Description' => ''),
      array('ID' => '134','Code' => '682','TextCode' => 'SAR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Саудовский риял','Rounding' => '2','Description' => ''),
      array('ID' => '135','Code' => '090','TextCode' => 'SBD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар Соломоновых островов','Rounding' => '2','Description' => ''),
      array('ID' => '136','Code' => '690','TextCode' => 'SCR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сейшельская рупия','Rounding' => '2','Description' => ''),
      array('ID' => '137','Code' => '938','TextCode' => 'SDG','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Суданский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '138','Code' => '752','TextCode' => 'SEK','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Шведская крона','Rounding' => '2','Description' => ''),
      array('ID' => '139','Code' => '702','TextCode' => 'SGD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сингапурский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '140','Code' => '654','TextCode' => 'SHP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Фунт Святой Елены ','Rounding' => '2','Description' => ''),
      array('ID' => '141','Code' => '705','TextCode' => 'SIT','DateFrom' => NULL,'DateTo' => '2016-12-31 00:00:00','Name' => 'Толар (Словения)','Rounding' => '2','Description' => ''),
      array('ID' => '142','Code' => '694','TextCode' => 'SLL','DateFrom' => NULL,'DateTo' => NULL,'Name' => ' Леоне','Rounding' => '2','Description' => ''),
      array('ID' => '143','Code' => '706','TextCode' => 'SOS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сомалийский шиллинг','Rounding' => '2','Description' => ''),
      array('ID' => '144','Code' => '968','TextCode' => 'SRD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Суринамский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '145','Code' => '678','TextCode' => 'STD','DateFrom' => NULL,'DateTo' => '2018-06-23 00:00:00','Name' => 'Добра <4>','Rounding' => '2','Description' => '<4> Не применяется с 1 января 2018 г.'),
      array('ID' => '146','Code' => '222','TextCode' => 'SVC','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сальвадорский колон','Rounding' => '2','Description' => ''),
      array('ID' => '147','Code' => '760','TextCode' => 'SYP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сирийский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '148','Code' => '748','TextCode' => 'SZL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Лилангени','Rounding' => '2','Description' => 'Свазилендский'),
      array('ID' => '149','Code' => '764','TextCode' => 'THB','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Бат','Rounding' => '2','Description' => ''),
      array('ID' => '150','Code' => '972','TextCode' => 'TJS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Сомони','Rounding' => '2','Description' => 'Таджикский '),
      array('ID' => '151','Code' => '934','TextCode' => 'TMT','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Новый туркменский манат','Rounding' => '2','Description' => ''),
      array('ID' => '152','Code' => '788','TextCode' => 'TND','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Тунисский динар','Rounding' => '2','Description' => ''),
      array('ID' => '153','Code' => '776','TextCode' => 'TOP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Паанга','Rounding' => '2','Description' => ''),
      array('ID' => '154','Code' => '949','TextCode' => 'TRY','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Турецкая лира','Rounding' => '2','Description' => ''),
      array('ID' => '155','Code' => '780','TextCode' => 'TTD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар Тринидада и Тобаго','Rounding' => '2','Description' => ''),
      array('ID' => '156','Code' => '901','TextCode' => 'TWD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Новый Тайваньский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '157','Code' => '834','TextCode' => 'TZS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Танзанийский шиллинг','Rounding' => '2','Description' => '

'),
      array('ID' => '158','Code' => '980','TextCode' => 'UAH','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Гривна','Rounding' => '2','Description' => 'Украинская '),
      array('ID' => '159','Code' => '800','TextCode' => 'UGX','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Угандийский шиллинг','Rounding' => '2','Description' => ''),
      array('ID' => '160','Code' => '840','TextCode' => 'USD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар США','Rounding' => '2','Description' => ''),
      array('ID' => '161','Code' => '940','TextCode' => 'UYI','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Уругвайское песо в индексированных единицах','Rounding' => '2','Description' => ''),
      array('ID' => '162','Code' => '858','TextCode' => 'UYU','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Уругвайское песо','Rounding' => '2','Description' => ''),
      array('ID' => '163','Code' => '860','TextCode' => 'UZS','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Узбекский Сум','Rounding' => '2','Description' => ''),
      array('ID' => '164','Code' => '937','TextCode' => 'VEF','DateFrom' => NULL,'DateTo' => '2019-06-15 00:00:00','Name' => 'Боливар <5>','Rounding' => '2','Description' => '<5> Не применяется с 20 августа 2018 г.'),
      array('ID' => '165','Code' => '704','TextCode' => 'VND','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Донг','Rounding' => '2','Description' => 'Ветнамский '),
      array('ID' => '166','Code' => '548','TextCode' => 'VUV','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Вату','Rounding' => '2','Description' => 'Республики  Вануату '),
      array('ID' => '167','Code' => '882','TextCode' => 'WST','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Тала','Rounding' => '2','Description' => ''),
      array('ID' => '168','Code' => '950','TextCode' => 'XAF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Франк КФА ВЕАС  <6>','Rounding' => '2','Description' => '<6>- денежная единица Банка государств Центральной Африки'),
      array('ID' => '169','Code' => '951','TextCode' => 'XCD','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Восточно-карибский доллар','Rounding' => '2','Description' => ''),
      array('ID' => '170','Code' => '960','TextCode' => 'XDR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'СДР (Специальные права заимствования)','Rounding' => '2','Description' => ' Международный валютный фонд'),
      array('ID' => '171','Code' => '952','TextCode' => 'XOF','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Франк КФА BCEAO <7>','Rounding' => '2','Description' => '<7> - денежная единица Центрального Банка государств Западной Африки.'),
      array('ID' => '172','Code' => '953','TextCode' => 'XPF','DateFrom' => NULL,'DateTo' => NULL,'Name' => ' Франк КФП','Rounding' => '2','Description' => ''),
      array('ID' => '173','Code' => '886','TextCode' => 'YER','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Йеменский риал','Rounding' => '2','Description' => ''),
      array('ID' => '174','Code' => '710','TextCode' => 'ZAR','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Рэнд','Rounding' => '2','Description' => ''),
      array('ID' => '175','Code' => '967','TextCode' => 'ZMW','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Замбийская квача','Rounding' => '2','Description' => ''),
      array('ID' => '176','Code' => '932','TextCode' => 'ZWL','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Доллар Зимбабве','Rounding' => '2','Description' => ''),
      array('ID' => '177','Code' => '728','TextCode' => 'SSP','DateFrom' => NULL,'DateTo' => NULL,'Name' => 'Южносуданский фунт','Rounding' => '2','Description' => ''),
      array('ID' => '178','Code' => '174','TextCode' => 'KMF','DateFrom' => '2017-10-13 00:00:00','DateTo' => NULL,'Name' => 'Коморский франк','Rounding' => '2','Description' => ''),
      array('ID' => '179','Code' => '418','TextCode' => 'LAK','DateFrom' => '2017-10-13 00:00:00','DateTo' => NULL,'Name' => 'Лаосский кип','Rounding' => '2','Description' => ''),
      array('ID' => '180','Code' => '929','TextCode' => 'MRU','DateFrom' => '2018-06-24 00:00:00','DateTo' => NULL,'Name' => 'Угия','Rounding' => '2','Description' => ''),
      array('ID' => '181','Code' => '930','TextCode' => 'STN','DateFrom' => '2018-06-24 00:00:00','DateTo' => NULL,'Name' => 'Добра','Rounding' => '2','Description' => ''),
      array('ID' => '182','Code' => '928','TextCode' => 'VES','DateFrom' => '2019-06-16 00:00:00','DateTo' => NULL,'Name' => 'Боливар Соберано','Rounding' => '2','Description' => NULL)
    );

    foreach ($arr as $value)
    {
      $object = MrCurrency::loadBy($value['Code'], 'Code') ?: new MrCurrency();

      $object->setCode($value['Code']);
      $object->setTextCode($value['TextCode']);
      $object->setName($value['Name']);
      $object->setRounding($value['Rounding']);
      $object->setDescription($value['Description']?:null);
      $object->setDateFrom($value['DateFrom']?:null);
      $object->setDateTo($value['DateTo']?:null);

      $object->save_mr();
    }
  }
}