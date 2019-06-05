<template>


    <div class="mr-8 flex items-center">
        <button class="rounded-full w-4 h-4 bg-default border border-accent mr-2" @click="selectTheme='theme-light'"></button>
        <button class="rounded-full w-4 h-4 bg-default border border-accent mr-2" @click="selectTheme='theme-dark'"></button>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                selectTheme:'theme-light'
            };
        },
        watch:{
            selectTheme(){

                // alert('change',this.selectTheme);
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectTheme);

            }
        }

    }
</script>
