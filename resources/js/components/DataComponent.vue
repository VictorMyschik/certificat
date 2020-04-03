<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Laravel vue pagination - codechief.org</div>

          <div class="card-body">
            <ul>
              <li v-for="post in laravelData.data" :key="post.id">@json(post)</li>
            </ul>

            <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {

    data() {
      return {
        // Our data object that holds the Laravel paginator data
        table_body: {},
      }
    },

    mounted() {
      // Fetch initial results
      this.getResults();
    },

    methods: {
      // Our method to GET results from a Laravel endpoint
      getResults(page = 1) {
        axios.get('/test?page=' + page)
            .then(response => {
              this.laravelData = response.data;
            });
      }
    }

  }
</script>