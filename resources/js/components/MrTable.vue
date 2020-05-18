<template>
  <div>
    <table class="table table-sm table-hover table-striped table-bordered col-md-12">
      <thead class="mr-bold mr-bg-table-header mr-test">
      <tr class="mr-auto-size">
        <td v-for="head in table_header"
            v-bind:class="typeof head['sort'] !== 'undefined' ? 'mr_cursor' : ''"
            v-on:click="mr_sort_field(head)">
          <i v-if="mr_field === head['sort']" class="mr-color-green-dark"
             :class="[mr_sort === 'asc' ? arrow_up : arrow_down]"></i>
          {{head['name']}}
        </td>
      </tr>
      </thead>
      <tbody class="mr-middle" v-bind:class="mr_wait ? 'mr_wait_class' : ''">
      <tr v-for="td in table_body.data">
        <td style="max-width: 300px; word-wrap: break-word;" v-for="item in td">
          <div v-if="Array.isArray(item)">
            <span v-for="small_item in item" v-html="small_item"></span>
          </div>
          <div style="white-space: pre-line; max-width: 500px;" v-else v-html="item"></div>
        </td>
      </tr>
      </tbody>
    </table>
    <pagination :data="table_body" @pagination-change-page="getResults" :limit="5">
      <span class="" slot="prev-nav">Previous</span>
      <span class="" slot="next-nav">Next</span>
    </pagination>
  </div>
</template>

<script>
  export default {

    props: ['mr_route', 'mr_object'],

    data()
    {
      return {
        mr_wait: false, // затемнение при загрузке
        table_body: {},
        table_header: [],
        // Сортировка
        mr_field: 'id',
        mr_sort: 'asc',
        // Стрелки сортировки
        arrow_up: 'fa fa-arrow-up',
        arrow_down: 'fa fa-arrow-down',
        token: '',
        limit: 5, // Макс кол ссылок на другие стр.
      }
    },

    mounted()
    {
      if (this.mr_route)
      {
        this.getResults();
      }

      if (this.mr_object)
      {
        this.table_body = this.mr_object.body;
        this.table_header = this.mr_object.header;
      }
    },

    methods: {
      getResults(page = 1)
      {
        this.mr_wait = true;
        let param = '?page=' + page + '&' + 'sort' + '=' + this.mr_sort + '&field=' + this.mr_field;
        console.log(param);
        axios.post(this.mr_route + param).then(response =>
          {
            this.table_body = response.data.body;
            this.table_header = response.data.header;
            this.token = this.mr_wait = false;
          }
        );
      },

      mr_sort_field(mr_sort)
      {
        if (typeof mr_sort['sort'] !== 'undefined')
        {
          this.mr_field = mr_sort['sort'];

          if (this.mr_sort === 'asc')
          {
            this.mr_sort = 'desc';
          }
          else
          {
            this.mr_sort = 'asc';
          }

          // Если нету роута - сортировка в пределах имеющегося списка
          if (this.mr_route)
          {
            this.getResults();
          }
        }
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

  .mr_cursor {
    cursor: pointer;
    color: #0a1041;
  }

  .mr_cursor:hover {
    background-color: rgba(230, 232, 254, 0.3);
  }

</style>