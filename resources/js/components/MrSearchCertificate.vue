<template>
  <div class="container col-md-11 col-sm-12 m-t-10">
    <div class="row no-gutters padding-horizontal">
      <div class="d-inline col-md-3 m-t-15">
        <label><b>Введите номер сертификата, артикул, наименование...</b>
          <input v-model="message" type="text" @input="getResults($event)" placeholder="search..." autofocus
                 class="form-control col-md-12 mr-border-radius-10 p-l-5"></label>
        <div class="">
          <div class="history_search"></div>
          <div v-if="result" v-for="(it,ind) in result" v-text="it" v-on:click="getCertificate(ind)" class="list"></div>
        </div>
        <hr>
      </div>

      <div v-if="certificate_json" class="d-inline col-md-9 no-gutters">
        <div class="row no-gutters m-b-15">
          <span class="btn btn-success btn-sm" v-on:click="watch()">Отслеживать</span>
        </div>
        <mr-certificate-details v-model="certificate_json"
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
    name: "MrSearchCertificate",
    data()
    {
      return {
        certificate_json: null,
        message: '',
        result: [],
        watch_id: 0,
      }
    },
    methods: {
      getResults()
      {
        let url = '/search/api';

        if (this.message.length > 2)
        {
          axios.post(url, {'text': this.message}).then(response =>
            {
              this.result = response.data.data;
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

        this.certificate_json = null;
        axios.post(url).then(response =>
          {
            this.certificate_json = response.data;
            this.watch_id = id;
          }
        );
      },

      watch()
      {
        let url = '/watch/add/' + this.watch_id;

        axios.post(url).then(response =>
          {
            alert('Сертификат №' + response.data['certificate'] + ' отслеживается');
          }
        );
      }
    },
  }
</script>

<style scoped>
  .list {
    cursor: pointer;
  }

  .list:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }

  .history_search {
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>