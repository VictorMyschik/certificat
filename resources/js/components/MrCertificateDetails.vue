<template>
  <div class="row no-gutters col-md-12 padding-horizontal-0">

    <div class="row no-gutters col-md-12 m-r-5 m-l-5">
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(1)">Общее</div>
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(2)">Продукция</div>
      <div class="btn border mr_btn btn-sm m-r-5" v-on:click="change_data(3)">Изготовитель</div>
      <div class="btn border mr_btn btn-sm" v-on:click="change_data(4)">Документы</div>
    </div>

    <div class="row no-gutters col-md-12" v-if="visible_kind === 1">
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 p-md-2">
        <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Сведения о документе</h4></div>
        <table class="table table-sm col-md-12 mr-auto-size">
          <tr>
            <td>Дата начала срока действия</td>
            <td></td>
          </tr>
          <tr>
            <td>Дата окончания срока действия</td>
            <td></td>
          </tr>
          <tr>
            <td>Эксперт - аудитор</td>
            <td></td>
          </tr>
          <tr>
            <td>Номер бланка</td>
            <td></td>
          </tr>
          <tr>
            <td>Срок действия статуса</td>
            <td></td>
          </tr>
          <tr>
            <td>Документ, на основании которого установлен статус</td>
            <td></td>
          </tr>
          <tr>
            <td>Причина изменения статуса</td>
            <td></td>
          </tr>
          <tr>
            <td>Приложения к документу</td>
            <td></td>
          </tr>
          <tr>
            <td>Схема сертификации (декларирования)</td>
            <td></td>
          </tr>
          <tr>
            <td>Дополнительная информация</td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="col-sm-12 no-gutters col-md-6 mr-sm-0 p-md-2">
        <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Сведения об органе по оценке соответствия</h4></div>
        <table class="table col-md-12 mr-auto-size table-sm">
          <tr>
            <td>Орган по сертификации</td>
            <td></td>
          </tr>
          <tr>
            <td>ФИО руководителя органа по сертификации</td>
            <td></td>
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
            <td></td>
          </tr>
          <tr>
            <td>Дата регистрации аттестата аккредитации</td>
            <td></td>
          </tr>
          <tr>
            <td>Место осуществления деятельности</td>
            <td></td>
          </tr>
          <tr>
            <td>Юридический адрес</td>
            <td></td>
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
      }
    },
    mounted() {
      console.log(this.certificate_json);
    },
    methods: {
      change_data(kind) {
        this.visible_kind = kind;

      }
    },
  }
</script>

<style scoped>
  td {
    padding: 0 0 0 0;
  }

  .mr_btn {
    background-color: rgba(221, 223, 247, 0.2);
  }

  .mr_btn:hover {
    box-shadow: 0 0 0 0.1rem rgba(221, 223, 247, 0.5);
  }

</style>