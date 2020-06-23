<template><!-- Страница Мои сертификаты -->
  <div>
    <div>
      <a href="#" class="btn btn-success btn-sm" v-on:click="ExportToExcel">Excel</a>
    </div>
    <div>
      <mr-table :mr_route="mr_route_list" v-on:selected="Selected"></mr-table>

    </div>
  </div>
</template>

<script>
  export default {
    name: "MrCertificateWatch",
    data()
    {
      return {
        table_body: [],
        table_header: [],
        mr_wait: false,
        mr_route_list: '/api/watch/list',
        selected: [],
      }
    },

    mounted()
    {

    },

    methods: {
      Selected: function (data)
      {
        this.selected = data;
      },

      ExportToExcel: function ()
      {
        console.log(this.selected);
      }
    }
  }
</script>

<style scoped>

</style>