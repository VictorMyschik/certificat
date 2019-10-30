<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class MrAdminDefaultDataController extends Controller
{
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
      $network = MrSocialNetwork::loadBy($value['Name'], 'Name') ?: new MrSocialNetwork();

    }
  }
}
