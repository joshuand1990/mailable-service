<template>
    <div :class="[{ 'bg-indigo-50 hover:bg-indigo-100' : active }]" class="px-3 py-3 rounded-r-full hover:bg-gray-50 transition duration-300 text-sm cursor-pointer mr-3 flex">
        <div class="flex justify-between w-full items-center pr-3">
            <div class="flex items-center text-gray-600 transition duration-300 font-medium" :class="[{ 'text-indigo-500' : active }]">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ItemSidebar',
    props: {
        active: { type: Boolean, default: false },
    }
}
</script>