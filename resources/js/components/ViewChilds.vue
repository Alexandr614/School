<template>
  <div class="uk-section">
    <spin v-if="loading"></spin>
    <div v-else class="uk-container">
      <table class="uk-table uk-table-divider">
        <caption>
          Таблица учеников
          <button class="uk-button uk-button-primary" @click="sorted">Сортировать по {{sort_by}}</button>
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
        <tr v-for="(str, index) in items" :key="str.id">
          <td>{{index + 1}}</td>
          <td
            v-for="el in str"
            :key="el.id"
          >{{el}}
          </td>
        </tr>
        </tbody>
      </table>
      <hr/>
      <paginate
        v-model="page"
        :page-count="pageCount"
        :click-handler="pageChangeHandler"
        :prev-text="'Назад'"
        :next-text="'Вперед'"
        :container-class="'uk-pagination uk-flex-center'"
        :active-class="'uk-active'"
      />
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import Spin from './Spin'
  import _ from 'lodash'

  export default {
    components: {
      Spin
    },

    data() {
      return {
        loading: true,
        table: [],
        sort_by: 'классу',
        page: +this.$route.query.page || 1,
        pageSize: 5,
        pageCount: 0,
        allItems: [],
        items: []
      }
    },

    mounted() {
      this.loadTable()
      this.getClass()
    },

    methods: {
      loadTable() {
        axios.get('/api/school')
          .then(res => {
            for (var i = 0; i < res.data.length; i++) {
              res.data[i].date = res.data[i].date.split('-').reverse().join('.')
            }
            this.table = res.data
            this.table.sort((prev, next) => {
              if (prev.name > next.name) {
                return 1
              } else {
                return -1
              }
            })
            setTimeout(() => {
              this.loading = false;
            }, 250)
          })
      },

      getClass() {
        axios.get('/api/class')
          .then(res => {
            for (var i = 0; i < this.table.length; i++) {
              this.table[i].class_id = res.data.find(temp => temp.id === this.table[i].class_id).class
            }
            this.setupPagination()
          })
      },

      sorted() {
        if (this.sort_by === 'имени') {
          this.table.sort((prev, next) => {
            if (prev.name > next.name) {
              return 1
            } else {
              return -1
            }
          })
          this.sort_by = 'классу'
        } else {
          this.table.sort((prev, next) => {
            if (prev.class_id > next.class_id) {
              return 1
            } else {
              return -1
            }
          })
          this.sort_by = 'имени'
        }
        this.setupPagination()
      },

      pageChangeHandler() {
        this.$router.push(`${this.$route.path}?page=${this.page}`)
        this.items = this.allItems[this.page - 1] || this.allItems[0]
      },

      setupPagination() {
        this.allItems = _.chunk(this.table, this.pageSize)
        this.pageCount = _.size(this.allItems)
        this.items = this.allItems[this.page - 1] || this.allItems[0]
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

  .uk-button {
    float: right;
  }
</style>
