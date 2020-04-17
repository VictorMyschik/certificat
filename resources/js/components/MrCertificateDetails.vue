<template>
  <div class="row col-md-12">
    <div class="col-md-6 padding-horizontal-0">
      <h4>Сведения о документе</h4>
      <table class="table table-sm">
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
    <div class="col-md-6 padding-horizontal-0">
      <h4>Сведения об органе по оценке соответствия</h4>
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