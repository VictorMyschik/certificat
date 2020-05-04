<template>
  <div>
    <label>Введите данные
      <input type="text" value="">
    </label>
  </div>
</template>

<script>
  export default {
    name: "MrSearchCertificate",

    getResults(text) {
      let url = '/search/api';
      if (text.length > 3) {
        axios.post(url).then(response => {
              console.log(response);
            }
        );
      }
    },
  }
</script>

<style scoped>

</style>