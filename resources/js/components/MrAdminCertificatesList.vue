<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <thead class="mr-bold">
      <tr>
        <td v-for="head_name in table_header">{{head_name}}</td>
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
      }
    },

    mounted() {
      // Fetch initial results
      this.getResults();
    },

    methods: {
      // Our method to GET results from a Laravel endpoint
      getResults(page = 1) {
        axios.get('/certificates?page=' + page).then(response => {

          console.log(response);

          this.table_body = response.data.body;
          this.table_header = response.data.header;
        });
      }
    }

  }
</script>

<style scoped>
  .mr_bold {
    font-weight: bold;
  }
</style>