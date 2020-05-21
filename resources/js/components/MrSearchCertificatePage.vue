<template>
  <div class="container col-md-11 col-sm-12 m-t-10">
    <div class="row no-gutters padding-horizontal">
      <div class="d-inline col-md-3 m-t-15">
        <div class="shadow mr-border-radius-10 padding-horizontal p-t-5 p-b-5 m-l-5 m-r-5">
          <h5><label class="mr-bold">Номер сертификата, артикул, наименование...
            <input v-model="message" type="text" @keyup="SearchCertificate" placeholder="search..." autofocus
                   class="mr-muted mr-border-radius-10 p-l-5" style="width: 100%;"></label></h5>
          <div class="">
            <div class="history_search mr-middle mr-muted padding-horizontal mr-border-radius-5"
                 style="cursor: pointer;" data-toggle="collapse" aria-expanded="false" aria-controls="base_menu_1"
                 href="#recent_search_list">Недавно искали
            </div>
            <div id="recent_search_list" class="padding-horizontal collapse mr-middle cursor" v-if="history_search"
                 v-for="story in history_search" v-on:click="SearchCertificate(message = story)">{{story}}
            </div>
            <div v-if="result" v-for="(it,ind) in result" v-on:click="getCertificate(ind)"
                 class="list mr-middle">
              {{it['Status']}} {{it['Number']}}
            </div>
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
        message: '',
        result: [],
        history_search: [],
        watch_id: 0,
        my_certificate_list: null,
      }
    },

    mounted()
    {
      this.history_search = this.history;
    },

    methods: {
      // Поиск сертификатов
      SearchCertificate()
      {
        let url = '/search/certificate';

        if (this.message.length > 2)
        {
          axios.post(url, {'text': this.message}).then(response =>
            {
              console.log(response.data);
              this.result = response.data;
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
        let url = '/search/api/get/' + id;

        // Запись истории поиска для быстрого повтора
        this.SetSearchHistory(this.message);

        this.certificate_json = null;
        axios.post(url).then(response =>
          {
            this.certificate_json = response.data;
            this.watch_id = id;
          }
        );
      },

      // Поставка отслеживания сертификата
      AddCertificateWatch()
      {
        let url = '/watch/add/' + this.watch_id;

        axios.post(url).then(response =>
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
      }
    },
  }
</script>

<style scoped>
  .list {
    cursor: pointer;
  }

  .cursor {
    cursor: pointer;
  }

  .list:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }

  .history_search {
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>