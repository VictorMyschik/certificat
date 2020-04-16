<?php


namespace App\Http\Controllers\Admin;


use App\Classes\Xml\MrXmlImportBase;
use App\Helpers\MrMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateAddressTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateAuthorityTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateCommunicateTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateFioTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateManufacturerTableController;
use App\Http\Controllers\TableControllers\Admin\Certificate\MrCertificateTableController;
use App\Http\Controllers\TableControllers\MrTableController;
use App\Models\Certificate\MrAddress;
use App\Models\Certificate\MrCertificate;
use App\Models\Certificate\MrCommunicate;
use App\Models\Certificate\MrConformityAuthority;
use App\Models\Certificate\MrFio;
use App\Models\Certificate\MrManufacturer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MrAdminCertificateController extends Controller
{
  public function View()
  {
    $out = array();
    $out['page_title'] = 'Сертификаты';
    $out['route_name'] = route('list_certificate_table');

    return View('Admin.Certificate.mir_admin_certificate')->with($out);
  }

  public function CertificateList()
  {
    return MrTableController::buildTable(MrCertificateTableController::class);
  }

  /**
   * Удаление сертификата
   * @param int $id
   * @return RedirectResponse
   */
  public function certificateDelete(int $id)
  {
    $certificate = MrCertificate::loadBy($id);
    $certificate->mr_delete();

    MrMessageHelper::SetMessage(true, 'Успешно удален');

    return back();
  }

  /**
   * Страница седений об адресах, таких как Email, Телефон и прочее
   */
  public function ViewCommunicate()
  {
    $out = array();
    $out['page_title'] = 'Связь';
    $out['route_name'] = route('list_communicate_table');

    return View('Admin.Certificate.mir_admin_certificate_communicate')->with($out);
  }

  /**
   * Api получение таблицы телефонов и Email-ов
   */
  public function CommunicateList()
  {
    return MrTableController::buildTable(MrCertificateCommunicateTableController::class);
  }

  /**
   * Удаление телефона, email
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function CommunicateDelete(int $id)
  {
    $communicate = MrCommunicate::loadBy($id);

    if($communicate)
    {
      $communicate->mr_delete();
    }

    return back();
  }

  /**
   * Страница производителей
   *
   * @return Factory|View
   */
  public function ViewManufacturer()
  {
    $out = array();
    $out['page_title'] = 'Производители';
    $out['route_name'] = route('list_manufacturer_table');

    return View('Admin.Certificate.mir_admin_certificate_manufacturer')->with($out);
  }

  /**
   * Таблица производителей
   *
   * @return array
   */
  public function ManufacturerList()
  {
    return MrTableController::buildTable(MrCertificateManufacturerTableController::class);
  }

  /**
   * Удаление производителя
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function ManufacturerDelete(int $id)
  {
    $manufacturer = MrManufacturer::loadBy($id);

    if(!$manufacturer->canEdit())
    {
      mr_access_violation();
    }

    $manufacturer->mr_delete();

    return back();
  }

  /**
   * Страница адресов
   */
  public function ViewAddress()
  {
    $out = array();
    $out['page_title'] = 'Адреса';
    $out['route_name'] = route('list_address_table');

    return View('Admin.Certificate.mir_admin_certificate_address')->with($out);
  }

  public function AddressList()
  {
    return MrTableController::buildTable(MrCertificateAddressTableController::class);
  }

  /**
   * Удаление адреса
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function AddressDelete(int $id)
  {
    $address = MrAddress::loadBy($id);

    if(!$address->canEdit())
    {
      mr_access_violation();
    }

    $address->mr_delete();

    return back();
  }

  /**
   * Страница адресов
   */
  public function ViewFio()
  {
    $out = array();
    $out['page_title'] = 'ФИО';
    $out['route_name'] = route('list_fio_table');

    return View('Admin.Certificate.mir_admin_certificate_fio')->with($out);
  }

  public function FioList()
  {
    return MrTableController::buildTable(MrCertificateFioTableController::class);
  }

  /**
   * Удаление адреса
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function FioDelete(int $id)
  {
    $Fio = MrFio::loadBy($id);

    if(!$Fio->canEdit())
    {
      mr_access_violation();
    }

    $Fio->mr_delete();

    return back();
  }

  /**
   * Страница органов по оценке соответствия
   */
  public function ViewAuthority()
  {
    $out = array();
    $out['page_title'] = 'Органы по оценке соответствия';
    $out['route_name'] = route('list_authority_table');

    return View('Admin.Certificate.mir_admin_certificate_authority')->with($out);
  }

  public function AuthorityList()
  {
    return MrTableController::buildTable(MrCertificateAuthorityTableController::class);
  }

  /**
   * Удаление орган по оценке соответствия
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function AuthorityDelete(int $id)
  {
    $Fio = MrConformityAuthority::loadBy($id);

    if(!$Fio->canEdit())
    {
      mr_access_violation();
    }

    $Fio->mr_delete();

    return back();
  }

  /**
   * Обновление сертификата
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function CertificateUpdate(int $id)
  {
    $certificate = MrCertificate::loadBy($id);

    if(!$certificate)
    {
      dd("Сертификат ID$id не найден");
    }

    $certificate->CertificateUpdate();
    $out = 'Сертификат ID' . $certificate->id() . ' №' . $certificate->getNumber() . ' обновлён';
    MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, $out);

    return back();
  }

  /**
   * Загрузка сертификата по ссылке из сайта ЕАЭС или по идентификатору
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function GetCertificateByURL(Request $request)
  {
    if($str = $request->get('url'))
    {
      // По ID
      if(strlen($str) == 24)
      {
        $url = "https://portal.eaeunion.org/_vti_bin/Portal.EEC.CDBProxy/PTS01.svc/Data('" . $str . "')";
      }
      elseif(stristr($str, '&'))
      {
        $d = parse_url($str);
        foreach (explode('&', $d['query']) as $param)
        {
          if(substr($param, 0, 10) == 'documentId')
          {
            $str = substr($param, 11);
          }
        }

        $url = $url = "https://portal.eaeunion.org/_vti_bin/Portal.EEC.CDBProxy/PTS01.svc/Data('" . $str . "')";;
      }
      elseif(stristr($str, 'https://portal.eaeunion.org/_vti_bin/Portal.EEC.CDBProxy/PTS01.svc/Data(\''))
      {
        $url = $str;
      }


      $xml_data = MrCertificate::GetCertificateFromURL($url);

      $out = MrXmlImportBase::ParseXmlFromString($xml_data);

      if(count($out))
      {

        $message_out = 'ID';
        $message_out .= $out[0]->id();
        $message_out .= ' ';
        $message_out .= $out[0]->getNumber();
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS, $message_out);
      }
      else
      {
        MrMessageHelper::SetMessage(MrMessageHelper::KIND_ERROR, 'Не удалось загрузить сертификат');
      }
    }

    return back();
  }
}