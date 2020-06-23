<template><!-- Страница Мои сертификаты -->
  <div>
    <div>
      <a href="#" class="btn btn-success btn-sm" v-on:click="ExportToExcel">Excel</a>
    </div>

    <div>
      <mr-table :mr_route="mr_route_list" v-on:selected="Selected" v-on:doubleClick="DoubleClick"></mr-table>
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
        show_certificate_id: 0,
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
      },

      DoubleClick: function (data)
      {
        this.show_certificate_id = data;
        console.log(this.show_certificate_id);
      }
    }
  }
</script>

<style scoped>

</style>