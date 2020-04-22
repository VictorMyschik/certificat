<template>
  <div class="row no-gutters col-md-12 padding-horizontal-0">

    <div class="row no-gutters col-md-12 m-r-5 m-l-5 m-b-10">
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(1)">Общее</div>
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(2)">Продукция</div>
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(3)">Изготовитель</div>
      <div class="btn border mr_btn btn-sm" v-on:click="change_data(4)">Документы</div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 1">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 p-md-2">
        <div class="col-md-12 mt_table_header"><h4 class="m-l-5 mr-auto-size-2 mr-bold">Сведения о документе</h4></div>
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
        <div class="col-md-12 mt_table_header"><h4 class="m-l-5 mr-auto-size-2 mr-bold">Сведения об органе по оценке соответствия</h4></div>
        <table class="table col-md-12 mr-auto-size table-sm">
          <tr>
            <td colspan="2" class="mr-bold">{{authority['Name']}}</td>
          </tr>
          <tr>
            <td>ФИО руководителя органа по сертификации</td>
            <td>{{authority['FIO']}}</td>
          </tr>
          <tr>
            <td>Телефон</td>
            <td></td>
          </tr>
          <tr>
            <td>Электронная почта</td>
            <td></td>
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
                <i class="fa fa-map mr-color-dark-blue fa-lg"></i></a> Место осуществления деятельности
            </td>
            <td>{{authority['Address2']}}</td>
          </tr>
          <tr>
            <td>
              <a v-if="authority['Address2']" target="_blank"
                 v-bind:href="'https://yandex.ru/maps/?text=' + authority['Address1']">
                <i class="fa fa-map mr-color-dark-blue fa-lg"></i></a> Юридический адрес
            </td>
            <td>{{authority['Address1']}}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 2">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 padding-horizontal-0 p-md-2">
        <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Продукция</h4></div>
      </div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 3">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 padding-horizontal-0 p-md-2">
        <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Изготовитель</h4></div>
      </div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 4">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 padding-horizontal-0 p-md-2">
        <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Документы</h4></div>
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
      }
    },
    mounted() {
      this.certificate = this.certificate_json.certificate;
      this.authority = this.certificate_json.authority;
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
    padding: 0 0 0 0;
  }

  .mt_table_header{
    background-color: rgba(221, 223, 247, 0.4);
    border-radius: 5px;
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