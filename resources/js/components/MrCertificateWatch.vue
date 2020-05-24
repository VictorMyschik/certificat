<template><!-- Страница Мои сертификаты -->
  <div>
    <div id="my_certificate_list" class="collapse show" style="width: 100%; max-height: 300px; overflow: auto;">
      <a href="#" class="btn btn-success btn-sm">Excel</a>
      <table class="table table-sm table-hover">
        <thead class="mr-bold">
        <tr class="mr-auto-size">
          <td v-for="head in table_header" v-bind:class="head['sort'] ? 'mr_cursor' : ''"
              v-on:click="mr_sort_field(head)">
            <i v-if="mr_field === head['sort']" class="mr-color-green-dark"
               :class="[mr_sort === 'asc' ? arrow_up : arrow_down]"></i>
            {{head['name']}}
          </td>
        </tr>
        </thead>
        <tbody class="mr-middle" v-bind:class="mr_wait ? 'mr_wait_class' : ''">
        <tr v-for="item in table_body.data" class="border-top mr_cursor" v-on:click="qwerty(item['id'])">
          <td v-html="item['dates']"></td>
          <td v-html="item['status']"></td>
          <td>{{item['number']}}</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: "MrCertificateWatch",
    data()
    {

    },

    methods: {
      MyCertificateList: function ()
      {
        axios.post('/api/watch/list/' + param).then(response =>
          {
            this.table_body = response.data.body;
            this.table_header = response.data.header;
            this.mr_wait = false;
          }
        );
      }
    }
  }
</script>

<style scoped>

</style>