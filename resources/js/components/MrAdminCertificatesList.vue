<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <thead>
      <tr class="mr-bold">
        <td v-for="head_name in laravelData.data" :key="head_name.id">{{ head_name }}</td>
      </tr>
      </thead>
      <tbody class="mr-middle">
      <tr v-for="td in laravelData.data">
        <td v-for="item in td">{{item}}</td>
      </tr>
      </tbody>
    </table>

    <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>
  </div>
</template>

<script>
  export default {

    data() {
      return {
        // Our data object that holds the Laravel paginator data
        laravelData: {},
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

          this.laravelData = response.data;
        });
      }
    }

  }
</script>

<style scoped>

</style>