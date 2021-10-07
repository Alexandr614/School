<template>
  <div class="uk-section">
    <spin v-if="loading"></spin>
    <div v-else class="uk-container">
      <table class="uk-table uk-table-divider">
        <caption>
          <div class="container">
            <div>
              Таблица учеников
            </div>
            <form @submit.prevent="filterClass">
              <label for="filter">Фильтр по классам: </label>
              <select id="filter"
                      class="uk-select uk-form-width-small uk-form-small"
                      v-model="form">
                <option>Все классы</option>
                <option v-for="el in classes" :key="el.id" :value="el.id">{{ el.class }}</option>
              </select>
              <button class="uk-button uk-button-primary" type="submit">Показать</button>
            </form>
          </div>
        </caption>
        <thead>
        <tr>
          <th>№</th>
          <th>ФИО</th>
          <th>Пол</th>
          <th>Дата рождения</th>
          <th>Класс</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="str in table" :key="str.id">
          <td v-for="el in str" :key="el.id">
            {{ el }}
          </td>
        </tr>
        </tbody>
      </table>

      <ul class="uk-pagination uk-flex-center" uk-margin>
        <li :class="{ 'uk-disabled': !pagination.prev_page }"
            @click.prevent="loadTable(pagination.first_page_url)">
          <a href="">В начало</a>
        </li>

        <li v-for="temp in pagination.links" :key="temp.id"
            :class="{ 'uk-disabled': temp.active }"
            @click.prevent="loadTable(temp.url)">
          <a href="">{{ temp.label }}</a>
        </li>

        <li :class="{ 'uk-disabled': !pagination.next_page }"
            @click.prevent="loadTable(pagination.last_page_url)">
          <a href="">В конец</a>
        </li>
      </ul>

      <hr/>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import Spin from './Spin'

  export default {
    components: {
      Spin
    },

    data() {
      return {
        loading: true,
        table: [],
        classes: [],
        temp: [],
        pagination: [],
        form: 'Все классы'
      }
    },

    mounted() {
      this.loadTable()
      this.getClass()
    },

    methods: {
      loadTable(page_url) {
        page_url = page_url || '/api/school'
        axios
          .get(page_url)
          .then(res => {
            for (var i = 0; i < res.data.data.length; i++) {
              res.data.data[i].date = res.data.data[i].date.split('-').reverse().join('.')
            }
            this.temp = res.data.data
            this.makePagination(res.data)
          })
          .catch(error => {
            if (error.res) {
              console.log(error.res.data)
            }
          })
        axios
          .get('/api/class')
          .then(res => {
            for (var i = 0; i < this.temp.length; i++) {
              this.temp[i].class_id = res.data.find(temp => temp.id === this.temp[i].class_id).class
            }
            this.table = this.temp
            setTimeout(() => {
              this.loading = false;
            }, 100)
          })
      },

      getClass() {
        axios
          .get('/api/class')
          .then(res => {
            this.classes = res.data
            this.classes.sort((prev, next) => {
              if (prev.class > next.class) {
                return 1
              } else {
                return -1
              }
            })
          })
      },

      makePagination(res) {
        this.pagination = {
          current_page: res.current_page,
          next_page: res.next_page_url,
          prev_page: res.prev_page_url,
          first_page_url: res.first_page_url,
          last_page_url: res.last_page_url
        }
        if (res.links.length <= 7) {
          this.pagination.links = res.links.slice(1, res.links.length - 1)
        } else {
          if ((this.pagination.current_page - 3) <= 0) {
            this.pagination.links = res.links.slice(1, 6)
          } else if ((this.pagination.current_page - 3) > 0 && (this.pagination.current_page + 3) <= res.links.length - 2) {
            this.pagination.links = res.links
              .slice((this.pagination.current_page - 2), (this.pagination.current_page + 3))
          } else {
            this.pagination.links = res.links
              .slice(res.links.length - 6, res.links.length - 1)
          }
        }
      },

      filterClass() {
        this.loading = true
        if (this.form == 'Все классы') {
          this.class_id = ''
        } else {
          this.class_id = this.form
        }
        axios
          .get(`/api/school/${this.class_id}`)
          .then(res => {
            for (var i = 0; i < res.data.data.length; i++) {
              res.data.data[i].date = res.data.data[i].date.split('-').reverse().join('.')
            }
            this.temp = res.data.data
            this.makePagination(res.data)
            console.log(res)
            console.log("OK")
          })
          .catch(error => {
            if (error.res) {
              console.log(error.res.data)
              console.log("Error!!!")
            }
          })
        axios
          .get('/api/class')
          .then(res => {
            for (var i = 0; i < this.temp.length; i++) {
              this.temp[i].class_id = res.data.find(temp => temp.id === this.temp[i].class_id).class
            }
            this.table = this.temp
            setTimeout(() => {
              this.loading = false;
            }, 100)
          })
      }
    }
  }
</script>

<style scoped>
  th {
    text-align: left;
  }

  caption {
    font-size: 32px;
    text-align: left;
  }

  .uk-section {
    padding-top: 20px;
    padding-left: 10px;
    padding-bottom: 10px;
    font-family: Cambria;
  }

  .uk-select {
    text-align: right;
  }

  .container {
    display: flex;
    justify-content: space-between;
  }
</style>
