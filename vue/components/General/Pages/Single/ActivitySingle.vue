<template>
    <div>
        Hello World
    </div>
</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'
    export default Base.extend({
        name: 'ActivitySingle',
        data: () => ({
            type: 'ActivitySingle',
        }),
        created() {
            this.setPageTitle('Activity - ');
        }
    });
</script>

<style scoped>

</style>
