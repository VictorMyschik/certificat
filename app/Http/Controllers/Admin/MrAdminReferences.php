<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Models\MrCountry;
use App\Http\Models\MrCurrency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MrAdminReferences extends Controller
{
  /**
   * Загрузка одного справочника
   * @return Factory|View
   */
  public function ViewCountry()
  {
    $out = array();
    $out['page_title'] = 'Справочник стран мира';
    $out['list'] = MrCountry::GetAll();

    return View('Admin.mir_admin_reference_country')->with($out);
  }

  public function ViewCurrency()
  {
    $out = array();
    $out['page_title'] = 'Справочник Валют';
    $out['list'] = MrCurrency::GetAll();

    return View('Admin.mir_admin_reference_currency')->with($out);
  }

  /**
   * Переустановка справочника
   * @return RedirectResponse
   */
  public function RebuildCountry()
  {
    MrCountry::RebuildReference();

    $text_number_codes = array(
      'RU' => '643',
      'KG' => '417',
      'KZ' => '398',
      'BY' => '112',
      'AM' => '051',
    );

    foreach ($text_number_codes as $key => $value)
    {
      $country = MrCountry::loadBy($key, 'Code');
      if($country)
      {
        $country->setNumericCode($value);
        $country->save_mr();
      }
      else
      {
        MrMessageHelper::SetMessage(false, 'Не все цифровые коды были добавлены');
      }
    }

    return back();
  }

  /**
   * Переустановка справочника валют
   *
   * @return RedirectResponse
   */
  public function RebuildCurrency()
  {
    MrAdminBackUpController::MrCurrencyData();

    return back();
  }

  /**
   * Удаление строки из справочника по ID
   *
   * @param string $reference
   * @param int $id
   * @return RedirectResponse
   */
  public function DeleteForID(string $reference, int $id)
  {
    $pref = 'Mr';
    $l = substr($reference, 0, 1);

    $class_name = substr_replace($reference, mb_strtoupper($l), 0,1);

    $class_name = "App\\Http\\Models\\" . $pref . $class_name;

    /** @var object $class_name */
    $row = $class_name::loadBy($id);
    $row->mr_delete();

    return back();
  }

}