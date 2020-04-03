<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <tbody class="mr-middle">
      <tr v-bind:class="{ mr_bold: index == 0 }" v-for="(td,index) in laravelData.data">
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
.mr_bold{
  font-weight: bold;
}
</style>