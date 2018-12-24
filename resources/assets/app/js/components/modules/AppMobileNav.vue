<template>
    <div class="nav--mobile" @keyup.esc="visible = false">
        <div class="flex">
            <app-search :open="true"></app-search>
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
