<template>
  <div class="container col-md-10 col-sm-12 m-t-10">
    <h4>Отслеживаемые сертификаты</h4>
    <mr-table :mr_route='route'></mr-table>
  </div>
</template>

<script>
  export default {
    name: "MrMyCertificate",
    data()
    {
      return {
        route: '/office',
      }
    },
    methods: {},
  }
</script>

<style scoped>

</style>