<template>
  <div class="row no-gutters col-md-12 col-sm-12 m-t-10 padding-horizontal">
    <h5 class="mr-bold" data-toggle="collapse" aria-expanded="false" aria-controls="base_menu_1"
        href="#my_certificate_list" style="cursor: pointer;">Отслеживаемые сертификаты</h5>
    <table class="table table-sm table-hover col-md-12 collapse show" id="my_certificate_list">
      <thead class="mr-bold  mr-test">
      <tr class="mr-auto-size">
        <td v-for="head in table_header" v-bind:class="typeof head['sort'] !== 'undefined' ? 'mr_cursor' : ''"
            v-on:click="mr_sort_field(head)">
          <i v-if="mr_field === head['sort']" class="mr-color-green-dark"
             :class="[mr_sort === 'asc' ? arrow_up : arrow_down]"></i>
          {{head['name']}}
        </td>
      </tr>
      </thead>
      <tbody class="mr-middle" v-bind:class="mr_wait ? 'mr_wait_class' : ''">
      <tr v-for="td in table_body.data" class="border-top">
        <td style="max-width: 300px; word-wrap: break-word;" v-for="item in td">
          <div style="white-space: pre-line; max-width: 500px;" v-html="item"></div>
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
    name: "MrMyCertificate",
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
      this.SearchCertificate();
    },

    methods: {

      SearchCertificate(page = 1)
      {
        this.mr_wait = true;
        let param = '?page=' + page + '&' + 'sort' + '=' + this.mr_sort + '&field=' + this.mr_field;

        axios.post('/api/watch/list/' + param).then(response =>
            {
              this.table_body = response.data.body;
              this.table_header = response.data.header;
              this.mr_wait = false;
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

          this.SearchCertificate();
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
  }

  .mr_cursor:hover {
    background-color: rgba(230, 232, 254, 0.3);
  }
</style>