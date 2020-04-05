<template>
  <div>
    <table class="table table-hover table-striped table-bordered">
      <thead class="mr-bold mr-bg-table-header">
      <tr>
        <td style="cursor: pointer; color: #0a1041;" v-on:click="mr_sort_field(header_key)"
            v-for="(head_name, header_key) in table_header">
          <i v-if="mr_field === header_key" class="mr-color-green-dark"
             :class="[mr_sort === 'asc' ? arrow_up : arrow_down]"></i> {{head_name}}
        </td>
      </tr>
      </thead>
      <tbody class="mr-middle" v-bind:class="mr_wait ? 'mr_wait_class' : ''">
      <tr v-for="td in table_body.data">
        <td v-for="item in td">{{item}}</td>
      </tr>
      </tbody>
    </table>
      <pagination :data="table_body" @pagination-change-page="getResults">
        <span class="" slot="prev-nav">Previous</span>
        <span class="" slot="next-nav">Next</span>
      </pagination>
  </div>
</template>

<script>
  export default {

    props: ['mr_route'],

    data() {
      return {
        mr_wait: false,

        table_body: {},
        table_header: [],

        mr_field: 'id',
        mr_sort: 'asc',
        arrow_up: 'fa fa-arrow-up',
        arrow_down: 'fa fa-arrow-down',
      }
    },

    mounted() {
      this.getResults();
    },

    methods: {
      getResults(page = 1) {
        this.mr_wait = true;
        let param = '?page=' + page + '&' + 'sort' + '=' + this.mr_sort + '&field=' + this.mr_field;

        axios.post(this.mr_route + param).then(response => {
              this.table_body = response.data.body;
              this.table_header = response.data.header;

              this.mr_wait = false;
            }
        )
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
  .mr_wait_class {
    background-color: rgba(162, 164, 185, 0.6);
    color: #a2a4b9;
  }

  .page-link {
    color: red;
    padding: 0 0 0 0;
  }
  .mr-previous {
  }
</style>