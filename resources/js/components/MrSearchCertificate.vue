<template>
  <div>
    <h3>Поиск сертификата</h3>
    <div class="row no-gutters border">
      <div class=""><label><b>Введите данные</b>
        <input v-model="message" type="text" @input="getResults($event)"
               placeholder="номер сертификата, артикул, наименование..."
               class="mr-border-radius-10" style="width: 100%">
      </label></div>
    </div>
    <div v-if="result" v-for="(item,index) in result">
      <li v-text="item" v-on:click="getCertificate(index)" style="cursor: pointer;"></li>
    </div>
    <div class="row no-gutters" v-if="certificate_json">
      <mr-certificate-details v-model="certificate_json" :certificate_json='certificate_json'></mr-certificate-details>
    </div>
  </div>
</template>

<script>
  export default {
    name: "MrSearchCertificate",
    data() {
      return {
        certificate_json: null,
        message: '',
        result: [],
      }
    },
    methods: {
      getResults() {
        let url = '/search/api';

        if (this.message.length > 2) {
          axios.post(url, {'text': this.message}).then(response => {
                this.result = response.data.data;
              }
          );
        } else {
          this.result = [];
          this.certificate_json = null;
        }
      },

      getCertificate() {
        let url = '/search/api/get/2';

        axios.post(url).then(response => {
              console.log(response);
              this.certificate_json = response.data;
            }
        );
      }
    },
  }
</script>

<style scoped>
  li:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>