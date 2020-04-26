<template>
  <div class="row no-gutters col-md-12 padding-horizontal-0">

    <div class="row no-gutters col-md-12 m-r-5 m-l-5 m-b-10">
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(1)">Общее</div>
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(2)">Продукция</div>
      <div class="btn border mr_btn btn-sm" v-on:click="change_data(3)">Документы</div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 1">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 p-md-2">
        <div class="col-md-12 mr-auto-size-2 mt_table_header mr-bold">Сведения о документе</div>
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
            <td>{{certificate['StatusDates']}}</td>
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
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 p-md-2">
        <div class="col-md-12 mr-auto-size-2 mt_table_header mr-bold">Орган по сертификации</div>
        <table class="table col-md-12 mr-auto-size table-sm">
          <tr>
            <td colspan="2" class="mr-bold">{{authority['Name']}}</td>
          </tr>
          <tr>
            <td>ФИО руководителя органа по сертификации</td>
            <td>{{authority['FIO']}}</td>
          </tr>
          <tr v-if="authority['communicate']">
            <td colspan="2" class="mr-bold" style="padding-top: 5px;">Связь</td>
          </tr>
          <tr v-if="authority['communicate']" v-for="item in authority['communicate']">
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

    <div class="row no-gutters col-md-12 mr-sm-0 padding-horizontal-0 p-md-2" v-if="visible_kind === 2">
      <div class="col-md-12 mr-auto-size-2 mt_table_header mr-bold">Производитель</div>
      <div class="mr-auto-size">
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
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 3">
      <div class="col-sm-12 no-gutters mr-sm-0 padding-horizontal-0 p-md-2 mr-auto-size">
        <div v-if="documents">
          <div v-if="documents[2]">
            <h5 class="mr-bold mt_table_header">{{documents[2][0]['KindName']}}</h5>
            <table class="table table-striped table-sm">
              <thead>
              <tr class="mr-bold">
                <td>ID</td>
                <td>Документ</td>
                <td>Дата выдачи документа</td>
                <td>Орган выдачи</td>
                <td>Номер и дата документа аккредитации</td>
                <td>Примечание</td>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in documents[2]">
                <td>{{row['id']}}</td>
                <td>{{row['Name']}} {{row['Number']}}</td>
                <td>{{row['Date']}}</td>
                <td>{{row['Organisation']}}</td>
                <td>{{row['Accreditation']}}</td>
                <td>{{row['Description']}}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div v-if="documents[1]">
            <h5 class="mr-bold mt_table_header">{{documents[1][0]['KindName']}}</h5>
            <table class="table table-striped table-sm">
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
</template>

<script>
  export default {
    props: ['certificate_json'],
    data() {
      return {
        visible_kind: 1,
        certificate: [],
        authority: [],
        manufacturer: [],
        documents: []
      }
    },
    mounted() {
      this.certificate = this.certificate_json.certificate;
      this.authority = this.certificate_json.authority;
      this.manufacturer = this.certificate_json.manufacturer;
      this.documents = this.certificate_json.documents;
      console.log(this.documents);
    },
    methods: {
      change_data(kind) {
        this.visible_kind = kind;
      }
    },
  }
</script>

<style scoped>
  tr:hover {
    background-color: rgba(221, 223, 247, 0.2);
  }

  td {
    padding: 1px 1px 1px 1px;
  }

  .mt_table_header {
    background-color: rgba(221, 223, 247, 0.4);
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

</style>