<template>


    <div class="mr-8 flex items-center">
        <button v-for="(color,theme) in themes"
                class="rounded-full w-4 h-4 bg-default border mr-2 focus:outline-none"
                :class="{'border-accent':selectTheme==theme}"
                :style="{ backgroundColor: color }"
                @click="selectTheme=theme">

        </button>


    </div>
</template>

<script>
    export default {
        data() {
            return{
                themes: {
                    'theme-light': '#f5f6f9',
                    'theme-dark': '#222'
                },
                selectTheme:'theme-light'
            };
        },

        created() {
            this.selectTheme = localStorage.getItem('theme') || 'theme-light';
        },

        watch:{
            selectTheme(){

                // alert('change',this.selectTheme);
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectTheme);
                localStorage.setItem('theme', this.selectTheme);

            }
        }

    }
</script>
