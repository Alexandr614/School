<template>
  <form name="viewcl">
    <div class="uk-grid-row-small" uk-grid>
      <div v-for="value in form" class="uk-card uk-card-body">
          {{value.class}}
      </div>
    </div>
  </form>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        form: []
      }
    },

    mounted() {
      this.loadClass()
    },

    methods: {
      loadClass() {
        axios
          .get('/api/class')
          .then(res => {
            this.form = res.data
            this.form.sort((prev, next) => {
              if (prev.class > next.class) {
                return 1
              } else {
                return -1
              }
            })
          })
          .catch(error => {
            console.log(error.res.data)
          })
      }
    }
  }
</script>

<style scoped>
  .uk-card {
    font-family: Cambria,serif;
    font-size: 24px;
    background-color: #95c5ed;
    width: 150px;
    text-align: center;
    float: left;
  }

  .uk-card-body {
    margin-left: 10px;
    margin-right: 10px;
    margin-bottom: 10px;
  }
</style>
