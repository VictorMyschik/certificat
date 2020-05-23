<template>
  <div class="row no-gutters col-md-12 col-sm-12 m-t-10 p-b-5 padding-horizontal">
    <div class="mr-bold mr_cursor mr-border-radius-5 mr_block_head p-l-5" style="width: 100%;" data-toggle="collapse"
         aria-expanded="false"
         aria-controls="base_menu_1" href="#my_certificate_list">
      Отслеживаемые сертификаты
    </div>
    <div id="my_certificate_list" class="collapse show" style="max-height: 200px; overflow: auto;">
      <table class="table table-sm table-hover col-md-12">
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
          <td class="" v-html="item['status']"></td>
          <td class="">{{item['number']}}</td>
        </tr>
        </tbody>
      </table>
      <a href="#" class="btn btn-success btn-sm">все сертификаты</a>
    </div>
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
      this.CertificateList();
    },

    methods: {

      qwerty(id)
      {
        this.$parent.getCertificate(id);
      },

      CertificateList(page = 1)
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

          this.CertificateList();
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
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>