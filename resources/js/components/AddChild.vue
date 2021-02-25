<template>
  <form class="uk-form-horizontal uk-margin-small" @submit.prevent="store">
    <fieldset class="uk-fieldset">
      <legend class="uk-legend">Добавление ученика</legend>

      <div class="uk-alert-success" uk-alert v-if="submitStatus === 'OK'">
        <a class="uk-alert-close" uk-close></a>
        <p>Ученик добавлен!</p>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="name1">Фамилия:</label>
        <div class="uk-form-controls uk-form-width-medium">
          <input
            id="name1"
            type="text"
            v-model.trim="$v.items.fam.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.items.fam.$error && $v.items.fam.$dirty,
            'uk-form-success': !$v.items.fam.$error && $v.items.fam.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.items.fam.required && $v.items.fam.$dirty">Введите фамилию!</div>
        <div class="uk-form-danger" v-if="!$v.items.fam.alphaRu && $v.items.fam.$dirty">Используйте кириллицу!</div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="name2">Имя:</label>
        <div class="uk-form-controls uk-form-width-medium">
          <input
            id="name2"
            type="text"
            v-model.trim="$v.items.name.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.items.name.$error && $v.items.name.$dirty,
            'uk-form-success': !$v.items.name.$error && $v.items.name.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.items.name.required && $v.items.name.$dirty">Введите имя!</div>
        <div class="uk-form-danger" v-if="!$v.items.name.alphaRu && $v.items.name.$dirty">Используйте кириллицу!</div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="name3">Отчество:</label>
        <div class="uk-form-controls uk-form-width-medium">
          <input
            id="name3"
            type="text"
            v-model.trim="$v.items.otch.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.items.otch.$error && $v.items.otch.$dirty,
            'uk-form-success': !$v.items.otch.$error && $v.items.otch.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.items.otch.required && $v.items.otch.$dirty">Введите отчество!</div>
        <div class="uk-form-danger" v-if="!$v.items.otch.alphaRu && $v.items.otch.$dirty">Используйте кириллицу!</div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label">Пол:</label>
        <div class="uk-form-controls uk-form-width-small">
          <label>
            <input type="radio" v-model.trim="form.gender"
                   class="uk-radio" value="Мужчина" name="gen"> Мужчина
          </label><br/>
          <label>
            <input type="radio" v-model.trim="form.gender"
                   class="uk-radio" value="Женщина" name="gen"> Женщина
          </label>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="born">Дата рождения:</label>
        <div class="uk-form-controls uk-form-width-medium">
          <input
            id="born"
            type="date"
            v-model.trim="$v.form.date.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.form.date.$error && $v.form.date.$dirty,
            'uk-form-success': !$v.form.date.$error && $v.form.date.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.form.date.required && $v.form.date.$dirty">Введите дату!</div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="class">Класс:</label>
        <div class="uk-form-controls uk-form-width-medium">
          <select id="class" type="text" v-model.trim="$v.form.class_id.$model" class="uk-select uk-form-small"
                  :class="{'uk-form-danger': $v.form.class_id.$error && $v.form.class_id.$dirty,
                  'uk-form-success': !$v.form.class_id.$error && $v.form.class_id.$dirty}">
            <option v-for="el in cls" :key="el.id" :value="el.id">{{el.class}}</option>
          </select>
        </div>
        <div class="uk-form-danger" v-if="!$v.form.class_id.required && $v.form.class_id.$dirty">Выберите класс!</div>
      </div>

      <p>
        <button class="uk-button uk-button-primary" type="submit" :disabled="$v.$invalid">
          <div uk-spinner v-if="loading"></div>
          <span v-else>Добавить</span>
        </button>
      </p>

    </fieldset>
  </form>
</template>

<script>
  import axios from 'axios'
  import {required, helpers} from 'vuelidate/lib/validators'

  export const alphaRu = helpers.regex('alphaRu', /[А-Яа-я]/)

  export default {
    data() {
      return {
        items: {
          name: '',
          fam: '',
          otch: ''
        },
        form: {
          name: '',
          gender: 'Мужчина',
          date: '',
          class_id: ''
        },
        cls: [],
        loading: false,
        submitStatus: null
      }
    },

    validations: {
      items: {
        name: {
          required,
          alphaRu
        },
        fam: {
          required,
          alphaRu
        },
        otch: {
          required,
          alphaRu
        }
      },
      form: {
        gender: {
          required
        },
        date: {
          required
        },
        class_id: {
          required
        }
      }
    },

    mounted() {
      this.getClass()
    },

    methods: {
      store() {
        this.$v.$touch()
        this.loading = true
        if (this.$v.$invalid) {
          this.submitStatus = 'ERROR'
          this.loading = false
        } else {
          this.form.name = this.items.fam + ' ' + this.items.name + ' ' + this.items.otch
          axios.post('/api/school', this.form, {
            headers: {
              "Content-type": "application/json"
            }
          })
            .then(res => {
              if (res.data.status) {
                this.clearInput()
                this.$v.$reset()
              }
            })
          setTimeout(() => {
            this.submitStatus = 'OK',
              this.loading = false
          }, 500)
          setTimeout(() => {
            this.submitStatus = null
          }, 3000)
        }
      },

      getClass() {
        axios.get('/api/class')
          .then(res => {
            this.cls = res.data
            this.cls.sort((prev, next) => {
              if (prev.class > next.class) {
                return 1
              } else {
                return -1
              }
            })
          })
      },

      clearInput() {
        this.items.otch = ''
        this.items.fam = ''
        this.items.name = ''
        this.form.name = ''
        this.form.gender = 'Мужчина'
        this.form.date = ''
        this.form.class_id = ''
      }
    }
  }
</script>

<style scoped>
  .uk-fieldset {
    margin-top: 20px;
    padding-left: 10px;
    font-family: Cambria;
  }

  .uk-legend {
    font-size: 32px;
  }

  .uk-margin {
    display: flex;
    padding-left: 10px;
  }

  .uk-form-label {
    width: 140px;
    font-size: 16px;
    margin-top: auto;
    margin-bottom: auto;
  }

  .uk-form-controls {
    margin-left: 0px;
    margin-right: 10px;
  }

  .uk-form-danger {
    margin-top: auto;
    margin-bottom: auto;
  }

  input {
    text-align: right;
  }

  select {
    text-align-last: right;
  }
</style>
