<template>
  <div>
    <table class="table table-sm table-hover table-striped table-bordered col-md-12">
      <thead class="mr-bold mr-bg-table-header mr-test">
      <tr class="mr-auto-size">
        <td v-for="(head,ind_head) in table_header">
          <div v-if="table_header['#checkbox'] !== 'undefined' && ind_head === 0">
            <label><input type='checkbox' @click='checkAll()' v-model='is_check_all'></label>
          </div>
          <div v-else v-html="head['#name']"
               v-bind:class="typeof head['sort'] !== 'undefined' ? 'mr_cursor' : ''"
               v-on:click="mr_click_head_field(head)">
            <i v-if="mr_field === head['sort']" class="mr-color-green-dark"
               :class="[mr_sort === 'asc' ? arrow_up : arrow_down]"></i>
          </div>
        </td>
      </tr>
      </thead>
      <tbody class="mr-middle" v-bind:class="mr_wait ? 'mr_wait_class' : ''">
      <tr v-for="td in table_body.data">
        <td style="max-width: 300px; word-wrap: break-word;" v-for="(item, ind) in td">
          <div v-if="table_header['#checkbox'] !== 'undefined' && ind === 0">
            <label><input type='checkbox' v-bind:value='item' v-model='selected' @change='updateCheckAll()'></label>
          </div>
          <div v-else>
            <div v-if="Array.isArray(item)">
              <span v-for="small_item in item" v-html="small_item"></span>
            </div>
            <div style="white-space: pre-line; max-width: 500px;" v-else v-html="item"></div>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <pagination :data="table_body" @pagination-change-page="CertificateList" :limit="5">
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

        // Checkboxes
        is_check_all: false,
        selected: [],
      }
    },

    mounted()
    {
      if (this.mr_route)
      {
        this.CertificateList();
      }

      if (this.mr_object)
      {
        this.table_body = this.mr_object.body;
        this.table_header = this.mr_object.header;
      }
    },

    methods: {
      CertificateList(page = 1)
      {
        this.mr_wait = true;
        let param = '?page=' + page + '&' + 'sort' + '=' + this.mr_sort + '&field=' + this.mr_field;
        //console.log(param);
        axios.post(this.mr_route + param).then(response =>
            {
              this.table_body = response.data.body;
              this.table_header = response.data.header;
              this.token = this.mr_wait = false;
            }
        );
      },

      mr_click_head_field(head_name)
      {
        if (typeof (head_name['sort']) != "undefined" && head_name['sort'] !== null)
        {
          this.mr_field = head_name['sort'];

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
            this.CertificateList();
          }
        }
      },

      checkAll: function ()
      {
        this.is_check_all = !this.is_check_all;
        this.selected = [];
        if (this.is_check_all)
        {
          for (let key in this.table_body.data)
          {
            this.selected.push(this.table_body.data[key][0]);
          }
        }

        this.ReturnSelected();
      },

      updateCheckAll: function ()
      {
        if (this.selected.length === this.table_body.length)
        {
          this.is_check_all = true;
        }
        else
        {
          this.is_check_all = false;
        }

        this.ReturnSelected();
      },

      ReturnSelected: function ()
      {
        this.$emit('selected', this.selected);
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