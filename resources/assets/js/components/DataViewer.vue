<template>
    <div class="dv">
        <div class="dv-header">
            <div class="dv-header-title">
                {{title}}
                {{highest_rating}}
            </div>
        </div>
        <div class="dv-body">
            <table class="dv-table">
                <thead>
                    <tr>
                        <th v-for="column in columns" @click="toggleOrder(column)" :filterable="true">
                            <span>{{column}}</span>
                            <span class="dv-table-column" v-if="column === query.column">
                                <span v-if="query.direction === 'desc'">&darr;</span>
                                <span v-else>&uarr;</span>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in model.data">
                        <td v-for="(value, key) in row">
                            {{value}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="dv-footer">
            <div class="dv-footer-item">
                <span>Displaying {{model.from}} - {{model.to}} of {{model.total}} rows</span>
            </div>
            <div class="dv-footer-item">
                <div class="dv-footer-sub">
                    <span>Rows per page</span>
                    <input type="text" v-model="query.per_page"
                           class="dv-footer-input"
                           @keyup.enter="fetchIndexData()">
                </div>
                <div class="dv-footer-sub">
                    <button class="dv-footer-btn" @click="prev()">&laquo;</button>
                    <input type="text" v-model="query.page"
                           class="dv-footer-input"
                           @keyup.enter="fetchIndexData()">
                    <button class="dv-footer-btn" @click="next()">&raquo;</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import axios from 'axios'
    //similar to vue-resource

    export default {
        props: ['source', 'title'],
        data() {
            return {
                model: {},
                columns: {},
                query: {
                    page: 1,
                    column: 'id',
                    direction: 'desc',
                    per_page: 15
                }
            }
        },
        created() {
            this.fetchIndexData()
        },
        methods: {
            next() {
                if (this.model.next_page_url) {
                    this.query.page++;
                    this.fetchIndexData()
                }
            },
            prev() {
                if (this.model.prev_page_url) {
                    this.query.page--;
                    this.fetchIndexData()
                }
            },
            toggleOrder(column) {
                if (column === this.query.column) {
                    if (this.query.direction === 'desc') {
                        this.query.direction = 'asc'
                    } else {
                        this.query.direction = 'desc'
                    }
                } else {
                    this.query.column = column;
                    this.query.direction = 'asc'
                }

                this.fetchIndexData()
            },
            fetchIndexData() {
                let vm = this;
                axios.get(`${this.source}?column=${this.query.column}&direction=${this.query.direction}&page=${this.query.page}&per_page=${this.query.per_page}`)
                    .then(function (response) {
                        Vue.set(vm.$data, 'model', response.data.model)
                        Vue.set(vm.$data, 'columns', response.data.columns)
                        Vue.set(vm.$data, 'highest_rating', response.data.model)

                        //console.log(response.data.highest_rating);
                    })
                    .catch(function (response) {
                        console.log(response)
                    })
            }
        }
    }
</script>