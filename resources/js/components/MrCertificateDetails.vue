<template>
  <div class="row no-gutters col-md-12 padding-horizontal-0">
    <div class="col-md-12 no-gutters">
      <h4 class="mr-bold" :class="'mr_cert_status_certificate_'+certificate['Status']"><img
        style='height: 21px; border-radius: 4px;' :src="src" :alt="certificate['Country']">
        {{certificate['StatusName']}}</h4>
    </div>
    <div class="col-md-12 no-gutters">
      <h6 class="mr-bold" style="color: #090d2f">
        {{certificate['Number']}}
      </h6>
    </div>
    <div class="row no-gutters col-sm-12 m-b-10">
      <div class="mr_shadow btn mr_btn btn-sm m-l-5 m-r-5" v-on:click="change_data('visible_1')">Общее</div>
      <div class="mr_shadow btn mr_btn btn-sm m-l-5 m-r-5" v-on:click="change_data('visible_2')">Продукция</div>
      <div class="mr_shadow btn mr_btn btn-sm m-l-5 m-r-5" v-on:click="change_data('visible_3')">Документы</div>
      <div class="mr_shadow btn mr_btn btn-sm m-l-5 m-r-5" v-on:click="change_data('visible_4')">Заявитель</div>
    </div>
    <div class="row col-md-12 no-gutters" v-if="visible_1">

      <div class="shadow-sm col-sm-12 no-gutters col-md-6 mr-sm-0 m-b-10">
        <h6 data-toggle="collapse" aria-expanded="false" aria-controls="base_menu_1" href="#base_menu_1"
            class="mr_cursor mr-bold mt_table_header">{{certificate['CertificateKindShortName']}}
        </h6>
        <div id="base_menu_1" class="collapse show">
          <table class="table table-sm table-striped col-md-12 mr-auto-size">
            <tr>
              <td>Дата начала срока действия</td>
              <td>{{certificate['DateFrom']}}</td>
            </tr>
            <tr>
              <td>Дата окончания срока действия</td>
              <td>{{certificate['DateTo']}}</td>
            </tr>
            <tr>
              <td>Эксперт - аудитор</td>
              <td>{{certificate['Auditor']}}</td>
            </tr>
            <tr>
              <td>Номер бланка</td>
              <td>{{certificate['BlankNumber']}}</td>
            </tr>
            <tr>
              <td>Срок действия статуса</td>
              <td><span style="white-space:nowrap;">{{certificate['StatusDates']}}</span></td>
            </tr>
            <tr>
              <td>Документ, на основании которого установлен статус</td>
              <td>{{certificate['BaseDocument']}}</td>
            </tr>
            <tr>
              <td>Причина изменения статуса</td>
              <td></td>
            </tr>
            <tr>
              <td>Приложения к документу</td>
              <td>{{certificate['WhyChange']}}</td>
            </tr>
            <tr>
              <td>Схема сертификации (декларирования)</td>
              <td>{{certificate['SchemaCertificate']}}</td>
            </tr>
            <tr>
              <td>Дополнительная информация</td>
              <td>{{certificate['Description']}}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="shadow-sm col-sm-12 no-gutters col-md-6 mr-sm-0 m-b-10">
        <h6 data-toggle="collapse" aria-controls="base_menu_2" href="#base_menu_2"
            class="mr_cursor mt_table_header">Орган по сертификации</h6>
        <div id="base_menu_2" class="collapse show">
          <table class="table col-md-12 mr-auto-size table-sm">
            <tr>
              <td colspan="2" class="mr-bold">{{authority['Name']}}</td>
            </tr>
            <tr>
              <td>ФИО руководителя органа по сертификации</td>
              <td>{{authority['FIO']}}</td>
            </tr>
            <tr v-if="authority['Communicate']">
              <td colspan="2" class="mr-bold" style="padding-top: 5px;">Связь</td>
            </tr>
            <tr v-if="authority['Communicate']" v-for="item in authority['Communicate']">
              <td>
                <i class="m-r-5 mr-color-green" :class="item.icon"></i>{{item.kind}}
              </td>
              <td>{{item.address}}</td>
            </tr>
            <tr>
              <td>Документ, подтверждающий аккредитацию органа сертификации</td>
              <td>{{authority['DocumentNumber']}}</td>
            </tr>
            <tr>
              <td>Дата регистрации аттестата аккредитации</td>
              <td>{{authority['DocumentDate']}}</td>
            </tr>
            <tr>
              <td>
                <a v-if="authority['Address2']" target="_blank"
                   v-bind:href="'https://yandex.ru/maps/?text=' + authority['Address2']">
                  <i class="fa mr-color-green fa-map fa-lg"></i></a> Место осуществления деятельности
              </td>
              <td>{{authority['Address2']}}</td>
            </tr>
            <tr>
              <td>
                <a v-if="authority['Address1']" target="_blank"
                   v-bind:href="'https://yandex.ru/maps/?text=' + authority['Address1']">
                  <i class="fa mr-color-green fa-map fa-lg"></i></a> Юридический адрес
              </td>
              <td>{{authority['Address1']}}</td>
            </tr>
          </table>
        </div>
      </div>

    </div>
    <div class="row no-gutters shadow-sm col-md-12 m-b-10" v-if="visible_2">
      <h6 data-toggle="collapse" aria-controls="product_base_menu" href="#product_base_menu"
          class=" mr_cursor col-md-12 mt_table_header">Производитель и продукция</h6>
      <div id="product_base_menu"
           class="collapse show col-sm-12 no-gutters mr-sm-0 padding-horizontal-0 p-md-2 mr-auto-size m-b-10">
        <h6 data-toggle="collapse" aria-controls="manufacturer_menu" href="#manufacturer_menu"
            class="mr_cursor mt_table_header_name">Производитель</h6>
        <div id="manufacturer_menu" class="collapse show">
          <div class="m-t-5 m-b-5"><i>{{manufacturer['Name']}}</i> {{manufacturer['Country']}}</div>
          <table class="table col-md-12 mr-auto-size table-sm m-t-10" style="width: 100%;">
            <tr v-if="manufacturer['Address2']">
              <td class="mr-bold">
                <a target="_blank" v-bind:href="'https://yandex.ru/maps/?text=' + manufacturer['Address2']">
                  <i class="fa mr-color-green fa-map fa-lg"></i></a> <span class=" p-r-10">Место осуществления деятельности:</span>
              </td>
              <td>{{manufacturer['Address2']}}</td>
            </tr>
            <tr v-if="manufacturer['Address1']">
              <td class="mr-bold">
                <a target="_blank" v-bind:href="'https://yandex.ru/maps/?text=' + manufacturer['Address1']">
                  <i class="fa mr-color-green fa-map fa-lg"></i></a> <span class=" p-r-10">Юридический адрес:</span>
              </td>
              <td>{{manufacturer['Address1']}}</td>
            </tr>
          </table>
        </div>

        <h6 data-toggle="collapse" aria-controls="product_base" href="#product_base"
            class="mr_cursor mt_table_header_name">Продукция</h6>
        <div id="product_base" class="collapse show">
          <div class="m-t-5 m-b-5" v-for="product in manufacturer['products']"><i><b>{{product['Name']}}</b></i>
            <div class="mr-muted">{{product['Description']}}</div>
            <div class="mr-muted" v-if="product['TnvedCode']">Код ТНВЭД: {{product['TnvedCode']}}</div>
            <div class="mr-muted" v-if="product['AdditionalInfoText']">Дополнительная информация:{{product['AdditionalInfoText']}}</div>

            <table class="table table-sm mr-small">
              <thead>
              <tr>
                <th>Наименование</th>
                <th>Идентификатор или заводской номер</th>
                <th>ТН ВЭД код</th>
                <th>Дата производства</th>
                <th>Срок годности</th>
                <th>Примечание</th>
                <th>Ед. измерения</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="info in product['Info']">
                <td>{{info['Name']}}</td>
                <td>{{info['InstanceId']}}</td>
                <td>{{info['TnvedCode']}}</td>
                <td>{{info['ManufacturedDate']}}</td>
                <td>{{info['ExpiryDate']}}</td>
                <td>{{info['Description']}}</td>
                <td>{{info['Measure']}}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
    <div class="row no-gutters shadow-sm col-md-12 m-b-10" v-if="visible_3">
      <h6 data-toggle="collapse" aria-controls="doc_menu" href="#doc_menu" class="mr_cursor col-md-12 mt_table_header">
        Документы, привязанные к сертификату</h6>
      <div id="doc_menu"
           class="collapse show col-sm-12 no-gutters mr-sm-0 padding-horizontal-0 p-md-2 mr-auto-size m-b-10">
        <div v-if="documents">
          <div v-if="documents[3]">
            <h6 data-toggle="collapse" aria-controls="doc_menu_3" href="#doc_menu_3"
                class="mr_cursor mt_table_header_name">{{documents[3][0]['KindName']}}</h6>
            <div id="doc_menu_3" class="collapse show">
              <table class="table table-sm">
                <thead>
                <tr class="mr-bold">
                  <td>Документ</td>
                  <td>Дата выдачи документа</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in documents[3]">
                  <td>{{row['Name']}} {{row['Number']}}</td>
                  <td>{{row['Date']}}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="documents[2]">
            <h6 data-toggle="collapse" aria-controls="doc_menu_2" href="#doc_menu_2"
                class="mr_cursor mt_table_header_name">{{documents[2][0]['KindName']}}</h6>
            <div id="doc_menu_2" class="collapse show">
              <table class="table table-sm">
                <thead>
                <tr class="mr-bold">
                  <td>Документ</td>
                  <td>Дата выдачи документа</td>
                  <td>Орган выдачи</td>
                  <td>Номер и дата документа аккредитации</td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in documents[2]">
                  <td>{{row['Name']}} {{row['Number']}}</td>
                  <td>{{row['Date']}}</td>
                  <td>{{row['Organisation']}}</td>
                  <td>{{row['Accreditation']}}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="documents[1]">
            <h6 data-toggle="collapse" aria-controls="doc_menu_1" href="#doc_menu_1"
                class="mr_cursor mt_table_header_name">{{documents[1][0]['KindName']}}</h6>
            <div id="doc_menu_1" class="collapse show">
              <table class="table table-sm">
                <thead>
                <tr class="mr-bold">
                  <td>Документ</td>
                  <td>Дата выдачи документа</td>
                  <td>Признак включения документа в перечень стандартов, в результате применения которых на добровольной
                    основе обеспечивается соблюдение установленных требований
                  </td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row_1 in documents[1]">
                  <td>{{row_1['Name']}} {{row_1['Number']}}</td>
                  <td>{{row_1['Date']}}</td>
                  <td>{{row_1['IsIncludeIn']}}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row no-gutters shadow-sm col-md-12 m-b-10" v-if="visible_4">
      <h6 data-toggle="collapse" aria-controls="applicant_base_menu" href="#applicant_base_menu"
          class="mr_cursor col-md-12 mt_table_header">Заявитель</h6>
      <div id="applicant_base_menu"
           class="collapse show col-sm-12 no-gutters mr-sm-0 padding-horizontal-0 p-md-2 mr-auto-size m-b-10">
        <h6 class="mt_table_header_name">{{applicant['Name']}}</h6>
        <table class="table col-md-12 mr-auto-size table-sm">
          <tr>
            <td>Страна</td>
            <td>{{applicant['Country']}}</td>
          </tr>
          <tr>
            <td>Код государственной регистрации</td>
            <td>{{applicant['BusinessId']}}</td>
          </tr>
          <tr v-if="applicant['Communicate']">
            <td colspan="2" class="mr-bold" style="padding-top: 5px;">Связь</td>
          </tr>
          <tr v-if="applicant['Communicate']" v-for="item in applicant['Communicate']">
            <td>
              <i class="m-r-5 mr-color-green" :class="item.icon"></i>{{item.kind}}
            </td>
            <td>{{item.address}}</td>
          </tr>
          <tr v-if="applicant['Address2']">
            <td>
              <a target="_blank"
                 v-bind:href="'https://yandex.ru/maps/?text=' + authority['Address2']">
                <i class="fa mr-color-green fa-map fa-lg"></i></a> Место осуществления деятельности
            </td>
            <td>{{applicant['Address2']}}</td>
          </tr>
          <tr v-if="applicant['Address1']">
            <td>
              <a target="_blank"
                 v-bind:href="'https://yandex.ru/maps/?text=' + authority['Address1']">
                <i class="fa mr-color-green fa-map fa-lg"></i></a> Юридический адрес
            </td>
            <td>{{applicant['Address1']}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['certificate_json'],
    data()
    {
      return {
        visible_1: true,
        visible_2: true,
        visible_3: true,
        visible_4: true,
        certificate: [],
        authority: [],
        manufacturer: [],
        documents: [],
        applicant: [],
        src: '',
      }
    },
    mounted()
    {
      this.certificate = this.certificate_json.certificate;
      this.src = 'https://img.geonames.org/flags/m/' + this.certificate_json.certificate['CountryAlpha2'] + '.png';
      this.authority = this.certificate_json.authority;
      this.manufacturer = this.certificate_json.manufacturer;
      this.documents = this.certificate_json.documents;
      this.applicant = this.certificate_json.applicant;

      //console.log(this.manufacturer);
    },
    methods: {
      change_data(kind)
      {
        this.visible_1 = false;
        this.visible_2 = false;
        this.visible_3 = false;
        this.visible_4 = false;

        if (kind === 'visible_1')
        {
          this.visible_1 = true;
          this.visible_2 = true;
          this.visible_3 = true;
          this.visible_4 = true;
        }
        else if (kind === 'visible_2')
        {
          this.visible_2 = true;
        }
        else if (kind === 'visible_3')
        {
          this.visible_3 = true;
        }
        else if (kind === 'visible_4')
        {
          this.visible_4 = true;
        }
      }
    },
  }
</script>

<style scoped>
  h6, h6 {
    font-weight: bold;
  }

  tr:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }

  td {
    padding: 1px 1px 1px 1px;
    border: 1px solid rgba(239, 242, 255, 0.9);
  }

  .mt_table_header {
    background-color: rgba(108, 110, 245, 0.3);
    border-radius: 5px;
    padding-left: 5px;
    padding-top: 2px;
    padding-bottom: 2px;
    border: #6cb2eb 1px solid;
  }

  .mt_table_header_name {
    background-color: rgba(221, 223, 247, 0.3);
    border-radius: 5px;
    padding-left: 5px;
    padding-top: 2px;
    padding-bottom: 2px;
  }

  .mr_btn {
    background-color: rgba(221, 223, 247, 0.2);
    line-height: 1em;
  }

  .mr_btn:hover {
    box-shadow: 0 0 0 0.1rem rgba(209, 211, 235, 0.6);
    background-color: rgba(221, 223, 247, 0.6);
  }

  .mr_cursor {
    cursor: pointer;
  }

  .mr_cursor:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }

  .mr_shadow {
    box-shadow: 5px 5px rgba(221, 223, 247, 0.2);
    border: #6cb2eb 1px solid;
    color: #6cb2eb;
  }

  .mr_cert_status_certificate_1 {
    color: #009e00;
  }
</style>