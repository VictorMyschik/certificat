<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\MrSocialNetwork;

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
      [
        'Name' => 'Viber',
        'Templates' => 'viber://chat?number=',
        'Description' => 'для ПК',
        'Link' => 'https://www.viber.com/',
        'LinkPartner' => '',
        'Postfix' => '',
      ],
      [
        'Name' => 'Vk',
        'Templates' => 'https://vk.me/',
        'Description' => '',
        'Link' => 'https://www.vk.com/',
        'LinkPartner' => '',
        'Postfix' => '',
      ],
      [
        'Name' => 'Telegram',
        'Templates' => 'tg://resolve?domain=',
        'Description' => '',
        'Link' => 'https://telegram.org/',
        'LinkPartner' => '',
        'Postfix' => '',
      ],
      [
        'Name' => 'Skype',
        'Templates' => 'skype:',
        'Description' => '',
        'Link' => 'https://www.skype.com/ru/',
        'LinkPartner' => '',
        'Postfix' => '?call',
      ],
      [
        'Name' => 'Mobile',
        'Templates' => 'tel:',
        'Description' => '',
        'Link' => '',
        'LinkPartner' => '',
        'Postfix' => '?call',
      ],
      [
        'Name' => 'Facebook',
        'Templates' => 'https://www.messenger.com/t/',
        'Description' => '',
        'Link' => 'https://facebook.com',
        'LinkPartner' => '',
        'Postfix' => '',
      ],
      [
        'Name' => 'Site',
        'Templates' => '',
        'Description' => 'Любой сайт',
        'Link' => '',
        'LinkPartner' => '',
        'Postfix' => '',
      ]
    );

    foreach ($arr as $value)
    {
      $network = MrSocialNetwork::loadBy($value['Name'],'Name') ?: new MrSocialNetwork();
      $network->setName($value['Name']);
      $network->setTemplates($value['Templates']);
      $network->setDescription($value['Description']);
      $network->setLink($value['Link']);
      $network->setLinkPartner($value['LinkPartner']);
      $network->setPostfix($value['Postfix']);
      $network->save_mr();
    }
  }
}
