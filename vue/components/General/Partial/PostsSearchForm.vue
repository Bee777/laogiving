<template>
    <aside class="widget widget_search">
        <h3>Search bar</h3>
        <form @submit.prevent class="search-form" method="get">
            <input @keyup.enter="triggerButton" v-model="inputText" title="Search for:" class="search-field" type="search"
                   placeholder="Search …">
            <input ref="search-button" @click="searchEnter" type="submit" value="Search" class="search-submit btn btn-default">
        </form>
    </aside>
</template>

<script>
    export default {
        name: "PostsSearchForm",
        data: () => ({
            inputText: '',
        }),
        props: {
            value: {}
        },
        watch: {
            inputText: function (n, o) {
                this.emits();
            }
        },
        methods: {
            emits() {
                this.$emit('send', this.inputText);
                this.$emit('input', this.inputText);
            },
            searchEnter() {
                this.$emit('onSearchEnter', this.inputText)
            },
            triggerButton() {
                this.$refs['search-button'].click();
                this.$utils.hideKeyboard(this.$refs['search-button']);
            }
        },
        mounted() {
            this.inputText = this.value;
        }
    };
</script>

<style scoped>
    .widget_search {
        overflow: hidden;
    }
    .search-field {
        outline: none;
    }
</style>
