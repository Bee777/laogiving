<template>
    <div>
         <textarea v-model="text" class="span12 textarea-ctn" :class="[classes]" :rows="rows"
                   :id="`text-area-${_uid}`"
                   :style="`height: ${height}px`"
                   :placeholder="placeholder" :maxlength="max">{{text}}</textarea>
        <label :for="`text-area-${_uid}`" v-show="(text || '').length > 0">
            Maximum {{max}} characters ( {{ max - (text
            || '').length}} remaining )</label>
    </div>
</template>

<script>
    export default {
        name: "TextAreaLimiter",
        props: {
            value: {
                default: ''
            },
            max: {
                default: 1500,
            },
            rows: {
                default: 8
            },
            classes: {
                default: ''
            },
            placeholder: {
                default: ''
            },
            height: {
                default: 250
            }
        },
        data: () => ({
            text: '',
        }),
        watch: {
            text: function () {
                this.emit();
            },
        },
        methods: {
            emit() {
                if (this.max && this.max < (this.text || '').length) {
                    return;
                }
                this.$emit('send', this.text);
                this.$emit('input', this.text);
            },
            set(val) {
                if (this.max && this.max > 0) {
                    this.text = this.$utils.sub(val, this.max);
                } else {
                    this.text = val;
                }
            }
        },
        created() {
            this.set(this.value);
        }
    }
</script>

<style scoped>

</style>
