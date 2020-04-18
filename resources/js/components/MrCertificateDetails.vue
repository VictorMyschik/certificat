<template>
  <div class="col-md-12 padding-horizontal-0">
  <div class="col-md-6 col-sm-12 p-l-5 p-r-5">
      <h4 class="mr-auto-size-2 mr-bold">Сведения о документе</h4>
      <table class="table mr-auto-size table-sm">
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
  <div class="col-md-6 col-sm-12 p-l-5 p-r-5">
      <h4 class="mr-auto-size-2 mr-bold">Сведения об органе по оценке соответствия</h4>
      <table class="table mr-auto-size table-sm">
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

</style>