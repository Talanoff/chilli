<template>
    <div class="nav--mobile" @keyup.esc="visible = false">
        <div class="text-center mb-4">
            <a href="/products" class="btn-catalog">
                Весь каталог
            </a>
        </div>

        <div class="flex">
            <app-search class="search-container" :open="true"></app-search>
            <a href="#" class="btn btn-nav ml-auto"
               :class="{'is-open': visible}"
               @click.prevent="visible = !visible"></a>
        </div>

        <nav v-if="visible">
            <slot></slot>
        </nav>
    </div>
</template>

<script>
  import AppSearch from './AppSearch'

  export default {
    components: {
      AppSearch
    },
    data() {
      return {
        visible: false
      }
    },
  }
</script>

<style>
    .search-container {
        flex-grow: 1;
        margin-right: 10px;
    }

    .search-container .autocomplete-input {
        padding: 8px 12px;
        border: 1px solid rgba(255, 255, 255, 0.65);
        border-radius: 15px;
    }
</style>
