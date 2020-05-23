<template>
  <div class="row no-gutters padding-horizontal col-md-12">

  </div>
</template>

<script>
  export default {
    name: "MrExcelBlock",
    data()
    {
      return {
        certificate_json: null,
        v_query_text: '',
        result: [],
      }
    },
    methods: {},
  }
</script>

<style scoped>
  .mr_cursor {
    cursor: pointer;
  }

  .mr_cursor:hover {
    background-color: rgba(119, 128, 229, 0.2);
  }
</style>