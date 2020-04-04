<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <thead class="mr-bold mr-bg-table-header">
      <tr>
        <td style="cursor: pointer;" v-on:click="mr_sort_field(h_key)" v-for="(head_name, h_key) in table_header">
           {{head_name}}
        </td>
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
        mr_field: 'id',
        mr_sort: 'asc',
      }
    },

    mounted() {
      this.getResults();
    },

    methods: {
      getResults(page = 1) {

        let param = '&' + 'sort' + '=' + this.mr_sort + '&field=' + this.mr_field;

        axios.get('/certificates?page=' + page + param).then(response => {
          this.table_body = response.data.body;
          this.table_header = response.data.header;
        });
      },

      mr_sort_field(mr_sort) {
        this.mr_field = mr_sort;

        if (this.mr_sort === 'asc') {
          this.mr_sort = 'desc';
        } else {
          this.mr_sort = 'asc';
        }

        this.getResults();
      }
    },


  }
</script>

<style scoped>
  .mr_bold {
    font-weight: bold;
  }

</style>