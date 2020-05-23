<template>
  <div class="container col-md-11 col-sm-12 m-t-10">
    <div class="row no-gutters padding-horizontal">
      <div class="d-inline col-md-3 m-t-15">
        <div class="shadow mr-border-radius-10 padding-horizontal p-t-5 p-b-5 m-l-5 m-r-5">
          <input id="mr_input" v-model="v_query_text" type="text" @keyup="SearchCertificate(v_query_text)"
                 placeholder="search..."
                 autofocus class="mr-muted mr-border-radius-10 p-l-5" style="width: 100%;">

          <div class="">
            <div class="border mr-border-radius-5 m-t-5">
              <div class="history_search mr_cursor mr-middle mr-muted padding-horizontal mr-border-radius-5"
                   data-toggle="collapse" aria-expanded="false" aria-controls="base_menu_1"
                   href="#recent_search_list">Недавно искали
              </div>

              <div id="recent_search_list" class="p-l-5 collapse mr-middle" v-if="history_search">
                <div class="mr_cursor mr-border-radius-5" v-for="story in history_search"
                     v-on:click="ChangeSearch(story)">{{story}}
                </div>
              </div>
            </div>

            <div v-if="result" v-for="(it,ind) in result" v-on:click="getCertificate(ind)"
                 class="mr_cursor mr-middle">{{it['Status']}} {{it['Number']}}
            </div>
            <div v-if="not_found" class="mr-middle mr-muted">Не найдено</div>
          </div>

        </div>
        <hr>
        <div class="row no-gutters shadow padding-horizontal mr-border-radius-10 m-l-5 m-r-5">
          <mr-my-certificate></mr-my-certificate>
        </div>
        <hr>
      </div>

      <div v-if="certificate_json" class="d-inline col-md-9 m-t-15 shadow padding-horizontal">
        <div class="row no-gutters padding-horizontal m-b-15">
          <span class="btn btn-success btn-sm m-t-5" v-on:click="AddCertificateWatch">Отслеживать</span>
        </div>
        <hr>
        <mr-certificate-details class="padding-horizontal" v-model="certificate_json"
                                :certificate_json='certificate_json'></mr-certificate-details>
      </div>
      <div v-else>
        <mr-excel-block></mr-excel-block>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "MrSearchCertificatePage",
    props: ['history'],
    data()
    {
      return {
        certificate_json: null,
        v_query_text: '',
        result: [],
        history_search: [],
        watch_id: 0,
        not_found: false,
      }
    },

    mounted()
    {
      // Текущая история посика
      this.history_search = this.history;
    },

    methods: {
      // Поиск сертификатов
      SearchCertificate: function (query_text)
      {
        this.v_query_text = query_text;

        if (query_text.length > 2)
        {
          axios.post('/search/certificate', {'text': query_text}).then(response =>
            {
              this.result = response.data;

              if (Object.keys(this.result).length)
              {
                this.not_found = false;
              }
              else
              {
                this.not_found = true;
              }
            }
          );
        }
        else
        {
          this.result = [];
          this.certificate_json = null;
        }
      },

      getCertificate(id)
      {
        // Запись истории поиска для быстрого повтора
        this.SetSearchHistory(this.v_query_text);

        this.certificate_json = null;
        axios.post('/search/api/get/' + id).then(response =>
          {
            this.certificate_json = response.data;
            this.watch_id = id;
          }
        );
      },

      // Поставка отслеживания сертификата по нажатию на кнопку
      AddCertificateWatch()
      {
        axios.post('/watch/add/' + this.watch_id).then(response =>
          {
            alert('Сертификат №' + response.data['certificate'] + ' отслеживается');
          }
        );
      },

      // Сохранение запроса поиска для быстрого повтора
      SetSearchHistory(search_query)
      {
        axios.post('/api/search/user-history/' + search_query).then(response =>
        {
          this.history_search = response.data;
        });
      },

      // Искать по нажатию на строку в истории поиска
      ChangeSearch: function (story)
      {
        this.v_query_text = story;
        this.SearchCertificate(story);
      }
    },
  }
</script>

<style scoped>
  .history_search {
    background-color: rgba(119, 128, 229, 0.2);
  }

  .mr_cursor {
    cursor: pointer;
  }

  .mr_cursor:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>