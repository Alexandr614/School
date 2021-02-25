<template>
  <form class="uk-form-horizontal" @submit.prevent="store">
    <fieldset class="uk-fieldset">
      <legend class="uk-legend" style="font-size: 32px">Добавление класса</legend>

      <div class="uk-alert-success" uk-alert v-if="submitStatus === 'OK'">
        <a class="uk-alert-close" uk-close></a>
        <p>Класс создан!</p>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="number">Номер класса:</label>
        <div class="uk-form-controls uk-form-width-small">
          <input
            id="number"
            type="number"
            v-model.trim="$v.num.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.num.$error && $v.num.$dirty, 'uk-form-success': !$v.num.$error && $v.num.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.num.required && $v.num.$dirty">Введите число!</div>
        <div class="uk-form-danger" v-if="!$v.num.between && $v.num.$dirty">Необходимо ввести число от 1 до 11!</div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="litera">Буква класса:</label>
        <div class="uk-form-controls uk-form-width-small">
          <input
            id="litera"
            type="text"
            v-model.trim="$v.lit.$model"
            class="uk-input uk-form-small"
            :class="{'uk-form-danger': $v.lit.$error && $v.lit.$dirty, 'uk-form-success': !$v.lit.$error && $v.lit.$dirty}"
          />
        </div>
        <div class="uk-form-danger" v-if="!$v.lit.required && $v.lit.$dirty">Введите букву!</div>
        <div class="uk-form-danger" v-if="!$v.lit.maxLength && $v.lit.$dirty">Необходимо ввести одну букву!</div>
        <div class="uk-form-danger" v-if="!$v.lit.alphaRu && $v.lit.$dirty">Необходимо ввести букву русского алфавита!
        </div>
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
  import {required, maxLength, between, helpers} from 'vuelidate/lib/validators'

  export const alphaRu = helpers.regex('alphaRu', /[А-Я]/)

  export default {
    data() {
      return {
        lit: '',
        num: '',
        loading: false,
        submitStatus: null,
        form: {
          class: ''
        }
      }
    },

    validations: {
      num: {
        required,
        between: between(1, 11)
      },
      lit: {
        required,
        maxLength: maxLength(1),
        alphaRu
      }
    },

    methods: {
      store() {
        this.$v.$touch()
        this.loading = true
        if (this.$v.$invalid) {
          this.submitStatus = 'ERROR'
          this.loading = false
        } else {
          this.form.class = this.num + this.lit
          axios.post('/api/class', this.form, {
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

      clearInput() {
        this.lit = ''
        this.num = ''
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

  .uk-margin {
    display: flex;
    padding-left: 10px;
  }

  .uk-form-label {
    width: 140px;
    font-size: 16px;
    margin-top: auto;
    margin-bottom: auto;
    float: left;
  }

  .uk-form-controls {
    margin-left: 0px;
    margin-right: 10px;
  }

  .uk-form-danger {
    margin-top: auto;
    margin-bottom: auto;
  }
</style>
