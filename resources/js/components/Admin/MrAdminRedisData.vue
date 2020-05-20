<template>
  <div>
    <h4 class="mr-bold">Состояние сервера</h4>
    <table class="table table-hover table-striped table-bordered">
      <thead class="mr-bold mr-bg-table-header">
      <tr>
        <td>Параметр</td>
        <td>Значение</td>
      </tr>
      </thead>
      <tbody class="mr-middle">
      <tr v-for="item in table_body">
        <td>{{item.Title}}</td>
        <td>{{item.Value}}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        table_body: [],
      }
    },

    mounted() {
      this.SearchCertificate();
    },

    methods: {
      SearchCertificate() {
        axios.post('api/admin/systemdata').then(response => {
              this.table_body = response.data;
              console.log(this.table_body);
            }
        );

        setTimeout(this.SearchCertificate, 2000);
      },
    },
  }
</script>

<style scoped>

</style>