<template lang="">
    <div>
        <table class="w-full">
            <thead>
                <slot name="tableHead" />
            </thead>
            <tbody class="bg-white">

                <slot />
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>