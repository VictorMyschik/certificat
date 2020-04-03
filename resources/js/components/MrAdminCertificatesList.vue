<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <thead class="mr-bold mr-bg-table-header">
      <tr>
        <td v-for="(head_name,h_key ) in table_header"><span v-on:click="getResults(h_key)">{{head_name}}</span></td>
      </tr>
      </thead>
      <tbody class="mr-middle">
      <tr v-for="td in table_body.data">
        <td v-for="item in td">{{item}}</td>
      </tr>
      </tbody>
    </table>

    <pagination :data="table_body" @pagination-change-page="getResults"></pagination>
  </div>
</template>

<script>
  export default {

    data() {
      return {
        table_body: {},
        table_header: [],
        mr_key: 'id',
        way: 'ASC',
      }
    },

    mounted() {
      this.getResults();
    },

    methods: {
      getResults(page = 1) {

        if (this.way === 'ASC') {
          this.way = 'DESC';
        } else {
          this.way = 'ASC';
        }

        let mr_key = '';
        let param = '&' + mr_key + '=' + this.way;

        axios.get('/certificates?page=' + page + param).then(response => {

          console.log(response);

          this.table_body = response.data.body;
          this.table_header = response.data.header;
        });
      },

      mr_show(mr_key) {
        this.header_key = mr_key;
      },
    }

  }
</script>

<style scoped>
  .mr_bold {
    font-weight: bold;
  }

</style>