<template>
  <table class="table text-md-center">
    <thead>
      <slot name="columns">
        <th v-for="translate in translates">{{translate}}</th>
      </slot>
    </thead>
    <tbody>
    <tr v-for="item in data">
      <slot :row="item">
        <td v-for="column in columns" v-if="hasValue(item, column)">{{itemValue(item, column)}}</td>
      </slot>
    </tr>
    <slot name="add" v-if="total">
    <tr>
        <td :colspan="(type === 'short') ? 3: 0">Общая сумма</td>
        <td class="text-danger">{{total}}</td>
        <td>{{(type === 'short') ? 12: 20}}</td>
    </tr>
    </slot>

    </tbody>
  </table>
</template>
<script>
  export default {
    name: 'l-table',
    props: {
        type: String,
        columns: Array,
        data: Array,
        translates: Array,
        total: Number,
    },
    methods: {
      hasValue (item, column) {
        return item[column.toLowerCase()] !== 'undefined'
      },
      itemValue (item, column) {
        return item[column.toLowerCase()]
      }
    }
  }
</script>
<style>
</style>
