<template>
  <div class="row no-gutters col-md-12 padding-horizontal-0">

    <div class="mr-btn">Сведения о документе и органе по оценке соответствия</div>
    <a href="#" class="btn btn-success">Сведения о продукции</a>
    <a href="#" class="mr-btn">Сведения об изготовителе</a>
    <div class="mr-btn">Документы</div>

    <div class="col-sm-12 col-md-6 mr-sm-0 p-md-2">
      <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Сведения о документе</h4></div>
      <table class="table col-md-12 mr-auto-size  table-sm">
        <tr>
          <td>Дата начала срока действия</td>
          <td>12/12/2015</td>
        </tr>
        <tr>
          <td>Дата окончания срока действия</td>
          <td></td>
        </tr>
        <tr>
          <td>Эксперт - аудитор</td>
          <td>Ивано Иван Иванович</td>
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

    <div class="col-sm-12 col-md-6 mr-sm-0 p-md-2">
      <div class="col-md-12"><h4 class="mr-auto-size-2 mr-bold">Сведения об органе по оценке соответствия</h4></div>
      <table class="table col-md-12 mr-auto-size  table-sm">
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
</template>

<script>
  export default {
    name: "mr-certificate-details",
    props: ['certificate'],
    data() {
      return {}
    },
    mounted() {
      console.log(this.certificate)
    },
    methods: {},
  }
</script>

<style scoped>
  td {
    padding: 0 0 0 0;
  }

</style>