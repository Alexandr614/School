<template>
  <nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-center">
      <ul class="uk-navbar-nav">
        <li
          v-for="link in links"
          :key="link.href"
          :class="{'uk-active': $route.path === link.href}">
          <router-link :to="link.href">{{ link.title }}</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
  export default {
    data() {
      return {
        links: [
          {
            title: 'Список учеников',
            href: '/'
          },
          {
            title: 'Список классов',
            href: '/viewclass'
          },
          {
            title: 'Добавить класс',
            href: '/addclass'
          },
          {
            title: 'Добавить ученика',
            href: '/addchild'
          }
        ]
      }
    }
  }
</script>

<style scoped>
  .uk-navbar-container {
    background-color: #0f7ae5;
    font-family: Cambria;
    font-weight: bold;
  }
</style>
